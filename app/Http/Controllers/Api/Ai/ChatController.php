<?php

namespace App\Http\Controllers\Api\Ai;

use App\Ai\Agents\ListingAgent;
use App\Events\MessageReceived;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ChatMessageResource;
use App\Http\Resources\Api\PaginateChatMessage;
use App\Models\AgentConversation;
use App\Models\AgentConversationMessage;
use App\Services\Ai\ListingRagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Ai\Messages\Message;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $conversation = AgentConversation::where('user_id', Auth::id())->first();

        if (!$conversation) {
            return response()->json([
                'success' => false,
                'message' => trans('api.ai.conversations.index.not_found'),
                'data'    => null,
            ], 404);
        }

        $perPage = $request->get('per_page', 10);

        $messages = AgentConversationMessage::where('conversation_id', $conversation->id)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => trans('api.ai.conversations.index.success'),
            'data' => [
                'conversation' => [
                    'id'              => $conversation->id,
                    'title'           => $conversation->title,
                    'last_message_at' => $conversation->updated_at,
                    'created_at'      => $conversation->created_at,
                ],
                'messages' => new PaginateChatMessage($messages),
            ],
        ]);
    }

    public function handle(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string'],
        ]);

        $userId = Auth::user()->id;
        $message = trim($validated['message']);

        // 1. Get or Create the single conversation for this user
        $conversation = AgentConversation::firstOrCreate(
            ['user_id' => $userId],
            [
                'id' => (string) Str::uuid(),
                'title' => 'Chat with AI',
            ]
        );

        $conversationId = $conversation->id;

        // 2. Save User Message
        $userMessage = AgentConversationMessage::create([
            'id' => (string) Str::uuid(),
            'conversation_id' => $conversationId,
            'user_id' => $userId,
            'agent' => 'ListingAgent',
            'role' => 'user',
            'content' => $message,
            'attachments' => [],
            'tool_calls' => [],
            'tool_results' => [],
            'usage' => [],
            'meta' => [],
        ]);

        // 3. Fetch History (last 10 messages)
        $history = AgentConversationMessage::where('conversation_id', $conversationId)
            ->where('id', '!=', $userMessage->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->reverse()
            ->map(fn($m) => new Message($m->role, $m->content))
            ->toArray();

        $agent = (new ListingAgent())->withHistory($history);
        $response = $agent->prompt($message);

        $text = trim($response->text);
        $filters = $this->extractSearchFilters($text);

        if ($filters === null && $this->looksLikeSearchRequest($message)) {
            $repairPrompt = <<<PROMPT
The previous reply did not include a valid [SEARCH_LISTINGS] block.
For the user's last request below, return:
1. one short natural sentence in the user's language
2. one valid [SEARCH_LISTINGS] block only

User request: {$message}
PROMPT;

            $retryResponse = $agent->prompt($repairPrompt);
            $retryText = trim($retryResponse->text);
            $retryFilters = $this->extractSearchFilters($retryText);

            if ($retryFilters !== null) {
                $text = $retryText;
                $filters = $retryFilters;
            }
        }

        $recommendations = collect();
        $searchType = null;

        /**
         * 4. Extract structured search block
         */
        if ($filters !== null) {
            $results = app(ListingRagService::class)->search($filters);

            /**
             * IMPORTANT:
             * service returns ['type' => ..., 'items' => ...]
             */
            $recommendations = $results['items'];
            $searchType = $results['type'];

            $text = $this->stripSearchBlock($text);

            if ($searchType === 'no_results') {
                $text = trans('api.ai.chat.no_results');
            } elseif ($searchType === 'price_relaxed' || $searchType === 'rooms_relaxed') {
                $text = trim($text . "\n\n" . trans('api.ai.chat.relaxed_results'));
            }
        }

        // 5. Format Recommendations as requested
        $formattedRecommendations = $recommendations->map(function ($item) {
            $listing = $item['listing'] ?? $item;
            return [
                'id' => $listing->id,
                'title' => $listing->title,
                'price' => $listing->price,
                'phone' => optional($listing->member->user)->phone,
                'nbr_room' => $listing->number_rooms,
                'main_image' => $listing->main_image,
                'type' => optional($listing->type)->name,
                'rent_duration' => optional($listing->rentDuration)->name,
                'is_boosted' => (bool)$listing->active_boost_id,
            ];
        });

        // 6. Save Bot Message
        $botMessage = AgentConversationMessage::create([
            'id' => (string) Str::uuid(),
            'conversation_id' => $conversationId,
            'user_id' => $userId,
            'agent' => 'ListingAgent',
            'role' => 'assistant',
            'content' => $text,
            'attachments' => [],
            'tool_calls' => [],
            'tool_results' => [],
            'usage' => [],
            'meta' => [
                'filters' => $filters,
                'search_type' => $searchType,
                'recommendations' => $formattedRecommendations->values()->all(),
            ],
        ]);

        event(new MessageReceived($botMessage));

        /**
         * 7. Final response using ChatMessageResource with Envelope
         */
        return response()->json([
            'success' => true,
            'message' => trans('api.ai.chat.success'),
            'data' => new ChatMessageResource($botMessage)
        ]);
    }

    private function extractSearchFilters(string $text): ?array
    {
        if (! preg_match('/\[SEARCH_LISTINGS\](.*?)\[\/SEARCH_LISTINGS\]/s', $text, $matches)) {
            return null;
        }

        $filters = json_decode(trim($matches[1]), true);

        return json_last_error() === JSON_ERROR_NONE && is_array($filters)
            ? $filters
            : null;
    }

    private function stripSearchBlock(string $text): string
    {
        return trim((string) preg_replace('/\[SEARCH_LISTINGS\].*?\[\/SEARCH_LISTINGS\]/s', '', $text));
    }

    private function looksLikeSearchRequest(string $message): bool
    {
        $normalized = Str::lower($message);

        $keywords = [
            'apartment', 'appartement', 'house', 'home', 'studio', 'villa', 'flat', 'room',
            'rent', 'sale', 'buy', 'sell', 'exchange',
            'شقة', 'دار', 'منزل', 'كراء', 'للبيع', 'غرفة',
        ];

        return Str::contains($normalized, $keywords);
    }
}

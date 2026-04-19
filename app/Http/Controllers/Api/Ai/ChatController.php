<?php

namespace App\Http\Controllers\Api\Ai;

use App\Ai\Agents\ListingAgent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ChatMessageResource;
use App\Http\Resources\Api\ConversationResource;
use App\Models\AgentConversation;
use App\Models\AgentConversationMessage;
use App\Models\Listing;
use App\Services\Ai\ListingRagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index()
    {
        $conversation = AgentConversation::with(['messages' => function($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->where('user_id', Auth::id())
            ->first();

        if (!$conversation) {
            return response()->json([
                'success' => false,
                'message' => trans('api.ai.conversations.index.not_found'),
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => trans('api.ai.conversations.index.success'),
            'data' => new ConversationResource($conversation)
        ]);
    }

    public function handle(Request $request)
    {
        $userId = Auth::user()->id;

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
        AgentConversationMessage::create([
            'id' => (string) Str::uuid(),
            'conversation_id' => $conversationId,
            'user_id' => $userId,
            'agent' => 'ListingAgent',
            'role' => 'user',
            'content' => $request->message,
            'attachments' => [],
            'tool_calls' => [],
            'tool_results' => [],
            'usage' => [],
            'meta' => [],
        ]);

        $agent = new ListingAgent();
        $response = $agent->prompt($request->message);

        $text = $response->text;
        $filters = null;
        $recommendations = collect();
        $searchType = null;

        /**
         * 3. Extract structured search block
         */
        if (preg_match('/\[SEARCH_LISTINGS\](.*?)\[\/SEARCH_LISTINGS\]/s', $text, $matches)) {

            $filters = json_decode(trim($matches[1]), true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($filters)) {
                $filters = null;
            }

            // safety check
            if (json_last_error() === JSON_ERROR_NONE && is_array($filters)) {

                $results = app(ListingRagService::class)->search($filters);

                /**
                 * IMPORTANT:
                 * service returns ['type' => ..., 'items' => ...]
                 */
                $recommendations = $results['items'];
                $searchType = $results['type'];

                // remove block from AI message
                $text = str_replace($matches[0], '', $text);

                if ($searchType === 'no_results') {
                    $text = trans('api.ai.chat.no_results');
                } elseif ($searchType === 'price_relaxed' || $searchType === 'rooms_relaxed') {
                    $relaxedNote = "\n\n" . trans('api.ai.chat.relaxed_results');
                    $text .= $relaxedNote;
                }
            }
        }

        // 4. Format Recommendations as requested
        $formattedRecommendations = $recommendations->map(function ($item) {
            $listing = $item['listing'] ?? $item;
            return [
                'id' => $listing->id,
                'title' => $listing->title,
                'price' => $listing->price,
                'phone' => optional($listing->member->user)->phone,
                'nbr_room' => $listing->number_rooms,
                'main_image' => $listing->main_image_url,
                'type' => optional($listing->type)->name,
                'rent_duration' => optional($listing->rentDuration)->name,
            ];
        });

        // 5. Save Bot Message
        $botMessage = AgentConversationMessage::create([
            'id' => (string) Str::uuid(),
            'conversation_id' => $conversationId,
            'user_id' => $userId,
            'agent' => 'ListingAgent',
            'role' => 'assistant',
            'content' => trim($text),
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

        /**
         * 6. Final response using ChatMessageResource with Envelope
         */
        return response()->json([
            'success' => true,
            'message' => trans('api.ai.chat.success'),
            'data' => new ChatMessageResource($botMessage)
        ]);
    }
}

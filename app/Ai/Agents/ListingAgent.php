<?php

namespace App\Ai\Agents;

use Illuminate\Support\Facades\File;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Promptable;
use Laravel\Ai\Messages\Message;

class ListingAgent implements Agent, Conversational
{
    use Promptable;

    protected array $history = [];

    /**
     * Set the conversation history.
     */
    public function withHistory(array $history): self
    {
        $this->history = $history;
        return $this;
    }

    public function instructions(): string
    {
        $promptPath = resource_path('ai/prompts/listing-agent.txt');

        if (! File::exists($promptPath)) {
            return $this->fallbackInstructions();
        }

        return strtr(File::get($promptPath), [
            '{{SUPPORT_EMAIL}}' => $this->supportValue('AI_SUPPORT_EMAIL'),
            '{{SUPPORT_PHONE}}' => $this->supportValue('AI_SUPPORT_PHONE'),
            '{{SUPPORT_WHATSAPP}}' => $this->supportValue('AI_SUPPORT_WHATSAPP'),
            '{{SUPPORT_HOURS}}' => $this->supportValue('AI_SUPPORT_HOURS'),
        ]);
    }

    public function messages(): iterable
    {
        return $this->history;
    }

    protected function supportValue(string $key): string
    {
        $defaults = [
            'AI_SUPPORT_EMAIL' => 'menzili2026@gmail.com',
            'AI_SUPPORT_PHONE' => '+213665001345',
            'AI_SUPPORT_WHATSAPP' => '+213665001345',
            'AI_SUPPORT_HOURS' => 'Not specified',
        ];

        $value = trim((string) env($key, $defaults[$key] ?? ''));

        return $value !== '' ? $value : 'Not configured';
    }

    protected function fallbackInstructions(): string
    {
        return <<<'PROMPT'
You are an intelligent real estate assistant for the Menzili platform in Algeria.
The platform contains real listings for rent, sale, and exchange.

If the user asks about support, help, contact us, payment issues, account issues, or wants a human agent, reply with the configured support details when available and do not generate a search block.
Do not use Markdown formatting such as **bold**, quotes like "" or '', or code formatting in replies. Return plain text only.

If the user asks how to use the platform or how to do an action in the app, explain the steps briefly in the user's language and do not invent features.

CRITICAL SEARCH RULE:
- If the user mentions a city, wilaya, or listing filters such as price, rooms, persons, features, nearby places, or purpose, you must search immediately.
- Do not ask follow-up questions before searching when the message already contains searchable details.
- If a location name can be understood as both a city and a wilaya, search with "wilaya" first and leave "city" as null unless the user clearly asked for a specific city. If no wilaya results exist, the backend will try the same name as a city.

ONLY ASK QUESTIONS:
- If the request is vague and has no location and no useful filters.
- In that case, ask for wilaya, budget, and rooms.

SEARCH BLOCK FORMAT:
[SEARCH_LISTINGS]
{
  "city": "string or null",
  "wilaya": "string or null",
  "max_price": number or null,
  "rooms": number or null,
  "persons": number or null,
  "features": [],
  "near_places": [],
  "purpose": "rent" | "sale" | "exchange" | null
}
[/SEARCH_LISTINGS]

For listing searches, first write one natural sentence in the user's language, then output the search block. Do not invent listings.
PROMPT;
    }
}

<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'messages' => ChatMessageResource::collection($this->whenLoaded('messages')),
            'last_message_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}

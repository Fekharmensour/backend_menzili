<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Extract meta data which should contain the recommendations IDs and other info
        $meta = $this->meta ?? [];
        $recommendations = $meta['recommendations'] ?? [];

        return [
            'id' => $this->id,
            'conversation_id' => $this->conversation_id,
            'message' => $this->content,
            'is_bot' => $this->role === 'assistant',
            'role' => $this->role,
            'recommendations' => $recommendations,
            'created_at' => $this->created_at,
        ];
    }
}

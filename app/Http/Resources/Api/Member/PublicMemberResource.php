<?php

namespace App\Http\Resources\Api\Member;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicMemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->user;
        return [
            'id' => $this->id,
            'name' => $user->name,
            'profile_image' => $user->image_url,
            'email' => $user->email,
            'phone' => $user->phone,
            'verification' => [
                'is_member_verified' => (bool)$this->member_verified_at,
                'is_agent_verified' => (bool)$this->agent_verified_at,
            ],
            'views' => $this->views ?? 0,
            'rating' => $this->rating ?? 4.5,
        ];
    }
}

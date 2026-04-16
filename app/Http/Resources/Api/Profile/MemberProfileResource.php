<?php

namespace App\Http\Resources\Api\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\This;

class MemberProfileResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'has_password' =>  $this->password ? true : false,
            'profile_image' => $this->image_url,
            'verification' => [
                'is_member_verified' => (bool)$this->member?->member_verified_at,
                'is_agent_verified' => (bool)$this->member?->agent_verified_at,
            ],
            'wallet_balance' => $this->member?->wallet?->balance ?? 0,
            'views' => $this->member?->views ?? 0,
            'rating' => $this->member?->rating ?? 4.5,
        ];
    }
}

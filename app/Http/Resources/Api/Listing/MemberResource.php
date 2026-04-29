<?php

namespace App\Http\Resources\Api\Listing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'email' => $user->email,
            'phone' => $user->phone,
            'profile_image' => $user->profile_image,
            'member_verified' => $this->member_verified_at?true:false,
            'agent_verified' => $this->agent_verified_at?true:false,
            'views' => $this->views ?? 0 ,
            'rating' => $this->rating ?? 4.9 ,
        ];
    }
}

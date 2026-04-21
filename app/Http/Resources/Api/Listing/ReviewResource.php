<?php

namespace App\Http\Resources\Api\Listing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'member_id'=>$this->member?->id,
            'username' => $this->member?->user?->name,
            'profile_image' => $this->member?->user?->image_url,
            'is_verified' => !is_null($this->member?->member_verified_at),
            'rating' => $this->rating,
            'review' => $this->review,
            'date' => $this->created_at?->format('Y-m-d H:i'),
        ];
    }
}

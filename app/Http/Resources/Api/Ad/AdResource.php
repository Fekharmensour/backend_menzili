<?php

namespace App\Http\Resources\Api\Ad;

use App\Http\Resources\Api\Listing\ListingResource;
use App\Http\Resources\Api\Listing\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
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
            'image' => \Storage::url($this->image_path),
            'target_type' => $this->target_type,
            'redirect_url' => $this->redirect_url,
            'status' => $this->status,
            'listing' => $this->listing ? new ListingResource($this->listing):null ,
            'target_member_id' => $this->targetMember ? new MemberResource($this->targetMember) : null ,
            'external_url' => $this->external_url ?? null,
//            'start_date',
//            'end_date',
            'member' => new MemberResource($this->member),
        ];
    }
}

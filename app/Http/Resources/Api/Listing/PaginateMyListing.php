<?php

namespace App\Http\Resources\Api\Listing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginateMyListing extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'listing' => MyListingResource::collection($this->items()),
            'pagination' =>[
                // basic info
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),

                // navigation
                'has_pages' => $this->hasPages(),
                'has_more_pages' => $this->hasMorePages(),

                // page URLs (very useful for frontend)
                'first_page_url' => $this->url(1),
                'last_page_url' => $this->url($this->lastPage()),
                'next_page_url' => $this->nextPageUrl(),
                'prev_page_url' => $this->previousPageUrl(),

                // index positions
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),

                // query meta
                'path' => $this->path(),
                'current_page_url' => $this->url($this->currentPage()),
            ]
        ];
    }
}

<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginateChatMessage extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'messages' => ChatMessageResource::collection($this->items()),
            'pagination' => [
                // basic info
                'total'          => $this->total(),
                'count'          => $this->count(),
                'per_page'       => $this->perPage(),
                'current_page'   => $this->currentPage(),
                'total_pages'    => $this->lastPage(),

                // navigation
                'has_pages'      => $this->hasPages(),
                'has_more_pages' => $this->hasMorePages(),

                // page URLs
                'first_page_url'    => $this->url(1),
                'last_page_url'     => $this->url($this->lastPage()),
                'next_page_url'     => $this->nextPageUrl(),
                'prev_page_url'     => $this->previousPageUrl(),

                // index positions
                'from' => $this->firstItem(),
                'to'   => $this->lastItem(),

                // query meta
                'path'             => $this->path(),
                'current_page_url' => $this->url($this->currentPage()),
            ],
        ];
    }
}

<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'latitude' => $this->latitude,
            'longitude'=> $this->longitude ,
            'zip_code'=> $this->zip_code,
            'city' => $this->whenLoaded('city') ,
        ];
    }
}

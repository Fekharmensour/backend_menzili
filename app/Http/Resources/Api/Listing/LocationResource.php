<?php

namespace App\Http\Resources\Api\Listing;

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
            'city' => $this->city->name,
            'wilaya'=>$this->city->wilaya->name,
            'Wilaya_code'=>$this->city->wilaya->code,
            'country'=>$this->city->wilaya->country->name,
        ];
    }
}

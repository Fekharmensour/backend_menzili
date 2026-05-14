<?php

namespace App\Http\Resources\Api\Ad;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdsPlanResource extends JsonResource
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
            'coins' => $this->coins,
            'duration_days' => $this->duration_days,
            'is_active' => $this->is_active,
        ];
    }
}

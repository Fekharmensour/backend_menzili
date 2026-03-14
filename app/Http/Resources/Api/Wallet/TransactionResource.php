<?php

namespace App\Http\Resources\Api\Wallet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $meta = $this->meta ?? [];

        return [
            'id' => $this->id,
            'type' => $this->type, // deposit or withdraw
            'amount' => (int) $this->amount,
            'confirmed' => $this->confirmed,
            'reason' => $meta['reason'] ?? null,
            'payment_method' => $meta['payment_method'] ?? null,
            'payment_id' => $meta['payment_id'] ?? null,
            'listing_id' => $meta['listing_id'] ?? null,
            'date' => $this->created_at,
        ];
    }
}

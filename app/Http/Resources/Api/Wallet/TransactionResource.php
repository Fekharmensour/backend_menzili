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
            'type' => __("transactions.{$this->type}"), // translated deposit or withdraw
            'type_slug' => $this->type,
            'amount' => (int) $this->amount,
            'confirmed' => $this->confirmed,
            'reason' => isset($meta['reason']) ? __("transactions.{$meta['reason']}") : null,
            'reason_slug' => $meta['reason'] ?? null,
            'payment_method' => $meta['payment_method'] ?? null,
            'payment_id' => $meta['payment_id'] ?? null,
            'listing_id' => $meta['listing_id'] ?? null,
            'date' => $this->created_at,
        ];
    }
}

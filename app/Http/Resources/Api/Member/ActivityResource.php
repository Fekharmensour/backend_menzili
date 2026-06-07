<?php

namespace App\Http\Resources\Api\Member;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $meta = $this->meta ?? [];
        $reason = $meta['reason'] ?? $meta['description'] ?? 'activity';
        
        $activity = $this->mapActivity($reason, $meta);

        return [
            'id'    => $this->id,
            'icon'  => $activity['icon'],
            'title_full' => $activity['title'],
            'type'  => $activity['type'],
            'status' => $this->confirmed ? 'success' : 'pending',
            'change' => [
                'income' => $this->type === 'deposit',
                'valuer_coins' => (int) abs($this->amount),
            ],
            'date'  => $this->created_at,
        ];
    }

    private function mapActivity(string $reason, array $meta): array
    {
        if (str_contains($reason, 'Listing creation fee')) {
            $title = explode(': ', $reason)[1] ?? 'Property';
            return [
                'icon' => 'home',
                'title' => __('api.activities.listing_creation', ['title' => $title]),
                'type' => 'listing',
            ];
        }

        if ($reason === 'coin_purchase') {
            return [
                'icon' => 'wallet',
                'title' => __('api.activities.coin_purchase'),
                'type' => 'payment',
            ];
        }

        if ($reason === 'ad_publication' || $reason === 'ad_publishing') {
            return [
                'icon' => 'megaphone',
                'title' => __('api.activities.ad_publication') . (isset($meta['ad_title']) ? ': ' . $meta['ad_title'] : ''),
                'type' => 'ad',
            ];
        }

        if ($reason === 'initial_bonus') {
            return [
                'icon' => 'gift',
                'title' => __('api.activities.initial_bonus'),
                'type' => 'bonus',
            ];
        }

        if ($reason === 'listing_boost') {
            return [
                'icon' => 'rocket',
                'title' => __('api.activities.boost', ['title' => $meta['listing_title'] ?? 'Listing']),
                'type' => 'boost',
            ];
        }

        return [
            'icon' => 'activity',
            'title' => $reason,
            'type' => 'other',
        ];
    }
}

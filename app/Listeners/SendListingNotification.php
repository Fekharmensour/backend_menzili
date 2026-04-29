<?php

namespace App\Listeners;

use App\Events\ListingCreated;
use App\Models\User;
use App\Services\Notification\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;

class SendListingNotification implements ShouldQueue
{
    public function __construct(private readonly NotificationService $notificationService)
    {
    }

    public function handle(ListingCreated $event): void
    {
        $listing = $event->listing;
        $owner = $this->resolveOwner($listing);

        if ($owner) {
            $this->notificationService->sendFromKey(
                user: $owner,
                key: 'listing_created',
                params: ['title' => (string) data_get($listing, 'title', '')],
                reference: $listing instanceof Model ? $listing : null,
                icon: 'listing'
            );
        }

        // Optional global broadcast for newly created listings.
        if ((bool) env('BROADCAST_LISTING_CREATED', false)) {
            $this->notificationService->broadcastFromKey(
                key: 'listing_created',
                params: ['title' => (string) data_get($listing, 'title', '')],
                icon: 'listing'
            );
        }
    }

    private function resolveOwner($listing): ?User
    {
        if (!$listing) {
            return null;
        }

        $owner = data_get($listing, 'member.user');
        if ($owner instanceof User) {
            return $owner;
        }

        $userId = data_get($listing, 'member.user_id');
        return $userId ? User::query()->find($userId) : null;
    }
}

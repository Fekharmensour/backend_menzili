<?php

namespace App\Providers;

use App\Events\AppointmentCreated;
use App\Events\ListingCreated;
use App\Events\MessageReceived;
use App\Listeners\SendAppointmentNotification;
use App\Listeners\SendListingNotification;
use App\Listeners\SendMessageNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        AppointmentCreated::class => [
            SendAppointmentNotification::class,
        ],
        ListingCreated::class => [
            SendListingNotification::class,
        ],
        MessageReceived::class => [
            SendMessageNotification::class,
        ],
    ];

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

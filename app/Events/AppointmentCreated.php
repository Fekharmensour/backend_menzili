<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppointmentCreated
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public $appointment)
    {
    }
}

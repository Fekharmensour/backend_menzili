<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageReceived
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public $message)
    {
    }
}

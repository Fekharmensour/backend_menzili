<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ListingCreated
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public $listing)
    {
    }
}

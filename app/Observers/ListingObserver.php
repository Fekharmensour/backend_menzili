<?php

namespace App\Observers;

use App\Models\Listing;
use Illuminate\Support\Facades\Cache;

class ListingObserver
{

    private function clearCache(Listing $listing)
    {
        Cache::tags(['listings_index'])->flush();

        Cache::tags(['listings_show'])
            ->forget("listing_show_{$listing->id}");
    }

    public function created(Listing $listing): void
    {
        $this->clearCache($listing);
    }

    public function updated(Listing $listing): void
    {
        $this->clearCache($listing);
    }

    public function deleted(Listing $listing): void
    {
        $this->clearCache($listing);
    }

    public function restored(Listing $listing): void
    {
        $this->clearCache($listing);
    }

}

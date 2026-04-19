<?php

namespace App\Observers;

use App\Jobs\GenerateListingEmbeddingJob;
use App\Models\Listing;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Ai\Ai;

class ListingObserver
{

    private function clearCache(Listing $listing)
    {
        Cache::tags(['listings_index'])->flush();

        Cache::tags(['listings_show'])
            ->forget("listing_show_{$listing->id}");
    }

    private function formatListing(Listing $l): string
    {
        $l->loadMissing([
            'location.city.wilaya',
            'type',
            'rentDuration',
            'features',
            'nearPlaces'
        ]);

            return "
                Apartment Listing:

                Title: {$l->title}

                Description:
                {$l->description}

                Price: {$l->price} DZD

                Details:
                        - Rooms: {$l->number_rooms}
                        - Persons: {$l->number_persons}
                        - Surface: {$l->surface} m²
                        - Floor: {$l->floor}

                Location:
                        - City: " . optional($l->location->city)->name . "
                        - Wilaya: " . optional($l->location->city->wilaya)->name . "

                Type: " . optional($l->type)->name . "
                    Rent Duration: " . optional($l->rentDuration)->name . "

                Features:
                        " . $l->features->pluck('name')->join(', ') . "

                Near Places:
                        " . $l->nearPlaces->pluck('name')->join(', ') . "
                        ";
    }
//    private function generateEmbedding(Listing $listing): void
//    {
//        dispatch(function () use ($listing) {
//
//            $text = $this->formatListing($listing);
//
//            $embedding = Cache::remember(
//                'embedding_' . md5($text),
//                86400, // 1 day
//                fn () => Ai::embeddings()->create($text)
//            );
//
//            DB::table('listing_embeddings')->updateOrInsert(
//                ['listing_id' => $listing->id],
//                [
//                    'content' => $text,
//                    'embedding' => $embedding,
//                    'updated_at' => now(),
//                    'created_at' => now(),
//                ]
//            );
//        });
//    }

    private function generateEmbedding(Listing $listing): void
    {
        $text = $this->formatListing($listing);

        $embedding = Cache::remember(
            'embedding_' . md5($text),
            86400,
            fn () => Ai::embeddings([$text])->embeddings[0]
        );

        DB::table('listing_embeddings')->updateOrInsert(
            ['listing_id' => $listing->id],
            [
                'content' => $text,
                'embedding' => $embedding,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }

    public function created(Listing $listing): void
    {
//        dd('OBSERVER CREATED FIRED');
//        $this->clearCache($listing);
        GenerateListingEmbeddingJob::dispatch($listing);

    }

    public function updated(Listing $listing): void
    {
//        dd('OBSERVER UPDATED FIRED', $listing->id);
//        $this->clearCache($listing);
        GenerateListingEmbeddingJob::dispatch($listing);
    }

    public function deleted(Listing $listing): void
    {
//        $this->clearCache($listing);
        DB::table('listing_embeddings')
            ->where('listing_id', $listing->id)
            ->delete();
    }

    public function restored(Listing $listing): void
    {
//        $this->clearCache($listing);
        $this->generateEmbedding($listing);
    }

}

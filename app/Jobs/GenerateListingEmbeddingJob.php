<?php

namespace App\Jobs;

use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Laravel\Ai\Ai;

class GenerateListingEmbeddingJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(public Listing $listing) {}

    public function handle(): void
    {
        // \Log::info('JOB STARTED', ['listing_id' => $this->listing->id]);
        $l = $this->listing->load([
            'location.city.wilaya',
            'type',
            'rentDuration',
            'features',
            'nearPlaces'
        ]);

        $text = "
        Title: {$l->title}
        Description: {$l->description}
        Price: {$l->price}
        Rooms: {$l->number_rooms}
        Persons: {$l->number_persons}
        City: " . optional($l->location->city)->name;

        $embedding = Cache::remember(
            'embedding_' . md5($text),
            86400,
            fn () => Ai::embeddings([$text])->embeddings[0]
        );

        DB::table('listing_embeddings')->updateOrInsert(
            ['listing_id' => $this->listing->id],
            [
                'content' => $text,
                'embedding' => json_encode($embedding),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}

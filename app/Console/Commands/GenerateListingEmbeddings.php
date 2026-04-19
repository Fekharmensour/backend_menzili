<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Listing;
use Illuminate\Support\Facades\DB;
use Laravel\Ai\Ai;

class GenerateListingEmbeddings extends Command
{
    protected $signature = 'listings:embed';
    protected $description = 'Generate embeddings for all listings';

    public function handle()
    {
        $this->info('Generating embeddings for all listings (direct processing)...');

        $count = Listing::count();
        $bar = $this->output->createProgressBar($count);

        Listing::chunk(50, function ($listings) use ($bar) {
            foreach ($listings as $listing) {
                try {
                    $text = $listing->toSearchableText();

                    // Correct embedding logic as established in ListingRagService
                    $response = Ai::embeddings([$text]);
                    $embedding = $response->embeddings[0];

                    DB::table('listing_embeddings')->updateOrInsert(
                        ['listing_id' => $listing->id],
                        [
                            'content' => $text,
                            'embedding' => json_encode($embedding),
                            'updated_at' => now(),
                            'created_at' => now(),
                        ]
                    );
                } catch (\Exception $e) {
                    $this->newLine();
                    $this->error("❌ Failed to embed Listing {$listing->id}: " . $e->getMessage());
                }

                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine();
        $this->info("Done! Processed {$count} listings. ✅");
    }
}

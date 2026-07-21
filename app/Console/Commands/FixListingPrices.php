<?php

namespace App\Console\Commands;

use App\Models\Listing;
use Illuminate\Console\Command;

class FixListingPrices extends Command
{
    protected $signature = 'listings:fix-prices';
    protected $description = 'Update all listing prices to realistic values based on type (rent / sell / exchange)';

    // Price ranges in DZD
    private const RENT_MIN =   3000;
    private const RENT_MAX =   7500;
    private const SELL_MIN = 500000;
    private const SELL_MAX = 1000000;

    public function handle(): int
    {
        $listings = Listing::with('type')->get();

        if ($listings->isEmpty()) {
            $this->warn('No listings found in the database.');
            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($listings->count());
        $bar->start();

        $updated = 0;

        foreach ($listings as $listing) {
            $typeName = strtolower($listing->type?->name_en ?? '');

            $price = match (true) {
                str_contains($typeName, 'rent')     => $this->realisticRent(),
                str_contains($typeName, 'sell'),
                str_contains($typeName, 'sale')     => $this->realisticSell(),
                str_contains($typeName, 'exchange') => $this->realisticSell(), // exchange ≈ sale value
                default                             => $this->realisticRent(), // fallback
            };

            $listing->update(['price' => $price]);
            $updated++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("✅ Updated {$updated} listing prices.");

        return self::SUCCESS;
    }

    /** Generate a realistic rent price rounded to 500 DZD. */
    private function realisticRent(): int
    {
        return (int) (round(rand(self::RENT_MIN, self::RENT_MAX) / 500) * 500);
    }

    /** Generate a realistic sell price rounded to 50 000 DZD. */
    private function realisticSell(): int
    {
        return (int) (round(rand(self::SELL_MIN, self::SELL_MAX) / 50000) * 50000);
    }
}

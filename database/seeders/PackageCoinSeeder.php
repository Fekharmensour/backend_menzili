<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PackageCoin;
use Carbon\Carbon;

class PackageCoinSeeder extends Seeder
{
    public function run(): void
    {
        $dateEnd = Carbon::now()->addMonths(2)->toDateString();
        $packages = [
            [
                'coins' => 50,
                'price' => 500,
                'date_end_offer' => $dateEnd,
                'is_active' => true,
            ],
            [
                'coins' => 120,
                'price' => 1000,
                'date_end_offer' => $dateEnd,
                'is_active' => true,
            ],
            [
                'coins' => 300,
                'price' => 2000,
                'date_end_offer' => $dateEnd,
                'is_active' => true,
            ],
        ];
        foreach ($packages as $package) {
            PackageCoin::create($package);
        }
    }
}

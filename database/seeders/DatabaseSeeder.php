<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            MemberSeeder::class,
            
            NotificationSeeder::class,

            CategoryListingSeeder::class,
            FeaturedListingSeeder::class,
            ListingTypeSeeder::class,
            NearPlaceSeeder::class,
            RentDurationSeeder::class,

            // Coins and ad plans
            PackageCoinSeeder::class,
            AdsPlanSeeder::class,

            CountrySeeder::class,
            WilayaSeeder::class,
            CitySeeder::class,
            NewWilayasCitiesSeeder::class,
            MajorCitiesLocationsSeeder::class,
            LocationSeeder::class,

            
            // ListingSeeder::class,
            ScrapedListingSeeder::class,
            AdSeeder::class,
        ]);
    }
}

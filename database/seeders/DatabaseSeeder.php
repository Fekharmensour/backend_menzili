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
            MemberSeeder::class,
            CategoryListingSeeder::class,
            FeaturedListingSeeder::class,
            ListingTypeSeeder::class,
            NearPlaceSeeder::class,
            RentDurationSeeder::class,

            CountrySeeder::class,
            WilayaSeeder::class,
            CitySeeder::class,
            NewWilayasCitiesSeeder::class, // Seeder pour les nouvelles wilayas et leurs villes
            MajorCitiesLocationsSeeder::class,

            ListingSeeder::class,
        ]);
    }
}

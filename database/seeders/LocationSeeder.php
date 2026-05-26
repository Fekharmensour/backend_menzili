<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'latitude' => 36.8663,
                'longitude' => 6.9063,
                'altitude' => 20,
                'zip_code' => '21000',
                'city_id' => 753, // Skikda
            ],
            [
                'latitude' => 36.3650,
                'longitude' => 6.6147,
                'altitude' => 650,
                'zip_code' => '25000',
                'city_id' => 866, // Constantine
            ],
            [
                'latitude' => 36.7538,
                'longitude' => 3.0588,
                'altitude' => 120,
                'zip_code' => '16000',
                'city_id' => 560, // Algiers
            ],
            [
                'latitude' => 32.4894,
                'longitude' => 3.6731,
                'altitude' => 380,
                'zip_code' => '47000',
                'city_id' => 1445, // Ghardaia
            ],
            [
                'latitude' => 32.8266,
                'longitude' => 3.7664,
                'altitude' => 380,
                'zip_code' => '47100',
                'city_id' => 1444, // Berriane
            ],
        ];

        foreach ($locations as $loc) {
            Location::updateOrCreate([
                'city_id' => $loc['city_id']
            ], $loc);
        }
    }
}

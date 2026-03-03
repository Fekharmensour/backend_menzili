<?php

namespace Database\Seeders;

use App\Models\RentDuration;
use Illuminate\Database\Seeder;

class RentDurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $durations = [
            [
                'name_ar' => 'يومي',
                'name_en' => 'Day',
                'name_fr' => 'Jour',
                'active' => true,
            ],
            [
                'name_ar' => 'شهري',
                'name_en' => 'Month',
                'name_fr' => 'Mois',
                'active' => true,
            ],
            [
                'name_ar' => '6 أشهر',
                'name_en' => '6 Months',
                'name_fr' => '6 Mois',
                'active' => true,
            ],
            [
                'name_ar' => 'سنوي',
                'name_en' => 'Year',
                'name_fr' => 'Année',
                'active' => true,
            ],
        ];

        foreach ($durations as $duration) {
            RentDuration::create($duration);
        }
    }
}

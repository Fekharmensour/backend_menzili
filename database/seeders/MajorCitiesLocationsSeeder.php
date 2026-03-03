<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Location;
use Illuminate\Database\Seeder;

class MajorCitiesLocationsSeeder extends Seeder
{
    public function run(): void
    {
        // Format: commune_name_ar => [ [lat, lng, alt_m, zip_code, description (for comment)], ... ]
        $locationsData = [

            // Constantine (wilaya 25) - "City of Bridges"
            'قسنطينة' => [
                [36.3650, 6.6147, 650, '25000', 'جامعة قسنطينة 1 (Université Frères Mentouri Constantine 1) - main campus'],
                [36.3667, 6.6167, 640, '25017', 'جامعة قسنطينة 2 (Université Constantine 2)'],
                [36.3500, 6.6000, 660, '25000', 'جسر سيدي راشد (Sidi Rached Bridge) - iconic landmark'],
                [36.3700, 6.6100, 670, '25000', 'جسر سيدي امحمد (Sidi M\'Cid Bridge) - famous suspension bridge'],
                [36.3650, 6.6140, 650, '25000', 'جامع الباي (El Bey Mosque) - historic mosque'],
            ],

            // Algiers (capital, wilaya 16)
            'الجزائر' => [
                [36.7539, 3.0589, 120, '16000', 'جامعة الجزائر 1 (Université d\'Alger 1) - central campus'],
                [36.6600, 3.1700, 50,  '16111', 'جامعة العلوم والتكنولوجيا هواري بومدين (USTHB) - major tech university'],
                [36.7850, 3.0600, 100, '16000', 'القصبة (Casbah of Algiers) - UNESCO historic old town'],
                [36.7850, 3.0600, 90,  '16000', 'جامع كتشاوة (Ketchaoua Mosque) - famous historic mosque'],
                [36.7400, 3.0800, 80,  '16000', 'حديقة التجارب (Jardin d\'Essai) - central botanical garden/park'],
            ],

            // Skikda (wilaya 21)
            'سكيكدة' => [
                [36.8670, 6.9000, 20,  '21000', 'جامعة سكيكدة (Université de Skikda) - main campus'],
                [36.8715, 6.9102, 10,  '21000', 'ميناء سكيكدة (Port of Skikda) - third largest commercial port in Algeria'],
                [36.8700, 6.9050, 15,  '21000', 'قصر الثقافة (Palace of Culture) - cultural landmark'],
                [36.8667, 6.9000, 25,  '21000', 'المدينة القديمة (Old Town / Historic Center)'],
            ],
        ];

        $count = 0;
        $skipped = 0;

        foreach ($locationsData as $communeNameAr => $locs) {
            $city = City::where('name_ar', $communeNameAr)
                ->whereHas('wilaya', function ($q) use ($communeNameAr) {
                    // Quick filter by common wilaya codes
                    if ($communeNameAr === 'قسنطينة') $q->where('code', '25');
                    if ($communeNameAr === 'الجزائر') $q->where('code', '16');
                    if ($communeNameAr === 'سكيكدة') $q->where('code', '21');
                })
                ->first();

            if (!$city) {
                $this->command->warn("City not found: $communeNameAr → skipping");
                $skipped += count($locs);
                continue;
            }

            foreach ($locs as [$lat, $lng, $alt, $zip, $desc]) {
                Location::updateOrCreate(
                    [
                        'city_id'    => $city->id,
                        'latitude'   => $lat,
                        'longitude'  => $lng,
                    ],
                    [
                        'altitude'   => $alt,
                        'zip_code'   => $zip,
                        // Optional: add a 'description' column to your model if you want to store notes
                        // 'description' => $desc,
                    ]
                );
                $count++;
            }
        }

        $this->command->info("Seeded $count real locations for Constantine, Algiers, and Skikda.");
        if ($skipped > 0) $this->command->warn("$skipped skipped (cities missing in DB)");
    }
}
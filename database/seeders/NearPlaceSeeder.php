<?php

namespace Database\Seeders;

use App\Models\NearPlace;
use Illuminate\Database\Seeder;

class NearPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $places = [
            [
                'name_ar' => 'مسجد',
                'name_en' => 'Mosque',
                'name_fr' => 'Mosquée',
                'icon' => null,
                'icon_path' => '/storage/near_places/mosque.png',
                'description' => 'Near a mosque',
                'active' => true,
            ],
            [
                'name_ar' => 'مدرسة أطفال',
                'name_en' => 'Child School',
                'name_fr' => 'École maternelle',
                'icon' => null,
                'icon_path' => '/storage/near_places/child_school.png',
                'description' => 'Near a child school',
                'active' => true,
            ],
            [
                'name_ar' => 'مدرسة',
                'name_en' => 'School',
                'name_fr' => 'École',
                'icon' => null,
                'icon_path' => '/storage/near_places/school.png',
                'description' => 'Near a school',
                'active' => true,
            ],
            [
                'name_ar' => 'مركز شرطة',
                'name_en' => 'Police Station',
                'name_fr' => 'Poste de police',
                'icon' => null,
                'icon_path' => '/storage/near_places/police_station.png',
                'description' => 'Near a police station',
                'active' => true,
            ],
            [
                'name_ar' => 'شاطئ',
                'name_en' => 'Beach',
                'name_fr' => 'Plage',
                'icon' => null,
                'icon_path' => '/storage/near_places/beach.png',
                'description' => 'Near a beach',
                'active' => true,
            ],
            [
                'name_ar' => 'مقهى',
                'name_en' => 'Cafe',
                'name_fr' => 'Café',
                'icon' => null,
                'icon_path' => '/storage/near_places/cafe.png',
                'description' => 'Near cafes',
                'active' => true,
            ],
            [
                'name_ar' => 'مستشفى',
                'name_en' => 'Hospital',
                'name_fr' => 'Hôpital',
                'icon' => null,
                'icon_path' => '/storage/near_places/hospital.png',
                'description' => 'Near a hospital',
                'active' => true,
            ],
            [
                'name_ar' => 'سوق',
                'name_en' => 'Market',
                'name_fr' => 'Marché',
                'icon' => null,
                'icon_path' => '/storage/near_places/market.png',
                'description' => 'Near a market',
                'active' => true,
            ],
            [
                'name_ar' => 'محطة نقل',
                'name_en' => 'Bus Station',
                'name_fr' => 'Gare routière',
                'icon' => null,
                'icon_path' => '/storage/near_places/bus_station.png',
                'description' => 'Near public transportation',
                'active' => true,
            ],
            [
                'name_ar' => 'متنزه',
                'name_en' => 'Park',
                'name_fr' => 'Parc',
                'icon' => null,
                'icon_path' => '/storage/near_places/park.png',
                'description' => 'Near a park',
                'active' => true,
            ],
            [
                'name_ar' => 'موقف سيارات',
                'name_en' => 'Car Park',
                'name_fr' => 'Parking',
                'icon' => null,
                'icon_path' => '/storage/near_places/car_park.png',
                'description' => 'Near a car park',
                'active' => true,
            ]
        ];

        foreach ($places as $place) {
            NearPlace::create($place);
        }
    }
}

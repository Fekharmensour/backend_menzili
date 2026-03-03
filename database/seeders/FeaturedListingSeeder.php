<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\FeaturedListing;
use Illuminate\Database\Seeder;

class FeaturedListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'name_ar' => 'تلفاز',
                'name_en' => 'TV',
                'name_fr' => 'Télévision',
                'icon' => null,
                'icon_path' => '/storage/featured_listings/tv.png',
                'description' => 'Property has television',
                'active' => true,
            ],
            [
                'name_ar' => 'مسبح',
                'name_en' => 'Pool',
                'name_fr' => 'Piscine',
                'icon' => null,
                'icon_path' => '/storage/featured_listings/pool.png',
                'description' => 'Property has swimming pool',
                'active' => true,
            ],
            [
                'name_ar' => 'واي فاي',
                'name_en' => 'WiFi',
                'name_fr' => 'Wi-Fi',
                'icon' => null,
                'icon_path' => '/storage/featured_listings/wifi.png',
                'description' => 'Property has wireless internet',
                'active' => true,
            ],
            [
                'name_ar' => 'مكيف الهواء',
                'name_en' => 'AC',
                'name_fr' => 'Climatisation',
                'icon' => null,
                'icon_path' => '/storage/featured_listings/ac.png',
                'description' => 'Property has air conditioning',
                'active' => true,
            ],
            [
                'name_ar' => 'جراج',
                'name_en' => 'Garage',
                'name_fr' => 'Garage',
                'icon' => null,
                'icon_path' => '/storage/featured_listings/garage.png',
                'description' => 'Property has garage',
                'active' => true,
            ],
            [
                'name_ar' => 'حديقة',
                'name_en' => 'Garden',
                'name_fr' => 'Jardin',
                'icon' => null,
                'icon_path' => '/storage/featured_listings/garden.png',
                'description' => 'Property has garden',
                'active' => true,
            ],
            [
                'name_ar' => 'شرفة',
                'name_en' => 'Balcony',
                'name_fr' => 'Balcon',
                'icon' => null,
                'icon_path' => '/storage/featured_listings/balcony.png',
                'description' => 'Property has balcony',
                'active' => true,
            ],
            [
                'name_ar' => 'مطبخ مفتوح',
                'name_en' => 'Open Kitchen',
                'name_fr' => 'Cuisine ouverte',
                'icon' => null,
                'icon_path' => '/storage/featured_listings/kitchen.png',
                'description' => 'Property has open kitchen',
                'active' => true,
            ],
            [
                'name_ar' => 'حمام مستقل',
                'name_en' => 'Ensuite Bathroom',
                'name_fr' => 'Salle de bain attenante',
                'icon' => null,
                'icon_path' => '/storage/featured_listings/bathroom.png',
                'description' => 'Property has ensuite bathroom',
                'active' => true,
            ],
            [
                'name_ar' => 'أمن 24/7',
                'name_en' => '24/7 Security',
                'name_fr' => 'Sécurité 24/7',
                'icon' => null,
                'icon_path' => '/storage/featured_listings/security.png',
                'description' => 'Property has 24/7 security',
                'active' => true,
            ],
            [
                'name_ar' => 'كاميرات مراقبة',
                'name_en' => 'Security Cameras',
                'name_fr' => 'Caméras de surveillance',
                'icon' => null,
                'icon_path' => '/storage/featured_listings/camera.png',
                'description' => 'Property has security cameras',
                'active' => true,
            ]
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}

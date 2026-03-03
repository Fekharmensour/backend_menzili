<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class ListingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name_ar' => 'للإيجار',
                'name_en' => 'Rent',
                'name_fr' => 'Louer',
                'icon' => null,
                'icon_path' => '/storage/listing_types/rent.png',
                'description' => 'Property available for rent',
                'active' => true,
            ],
            [
                'name_ar' => 'للبيع',
                'name_en' => 'Sell',
                'name_fr' => 'Vendre',
                'icon' => null,
                'icon_path' => '/storage/listing_types/sell.png',
                'description' => 'Property available for sale',
                'active' => true,
            ],
            [
                'name_ar' => 'للمقايضة',
                'name_en' => 'Exchange',
                'name_fr' => 'Échanger',
                'icon' => null,
                'icon_path' => '/storage/listing_types/exchange.png',
                'description' => 'Property available for exchange',
                'active' => true,
            ],
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}

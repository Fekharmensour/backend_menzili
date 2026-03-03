<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryListing;
use Illuminate\Database\Seeder;

class CategoryListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name_ar' => 'شقة',
                'name_en' => 'Apartment',
                'name_fr' => 'Appartement',
                'icon' => null,
                'icon_path' => '/storage/category_listings/apartment.png',
                'description' => 'Apartment rental and sales',
                'active' => true,
            ],
            [
                'name_ar' => 'منزل',
                'name_en' => 'House',
                'name_fr' => 'Maison',
                'icon' => null,
                'icon_path' => '/storage/category_listings/house.png',
                'description' => 'House rental and sales',
                'active' => true,
            ],
            [
                'name_ar' => 'فيلا',
                'name_en' => 'Villa',
                'name_fr' => 'Villa',
                'icon' => null,
                'icon_path' => '/storage/category_listings/villa.png',
                'description' => 'Villa rental and sales',
                'active' => true,
            ],
            [
                'name_ar' => 'مكتب',
                'name_en' => 'Office',
                'name_fr' => 'Bureau',
                'icon' => null,
                'icon_path' => '/storage/category_listings/office.png',
                'description' => 'Office space rental',
                'active' => true,
            ],
            [
                'name_ar' => 'متجر',
                'name_en' => 'Store',
                'name_fr' => 'Magasin',
                'icon' => null,
                'icon_path' => '/storage/category_listings/store.png',
                'description' => 'Commercial store rental',
                'active' => true,
            ],
            [
                'name_ar' => 'أرض',
                'name_en' => 'Land',
                'name_fr' => 'Terrain',
                'icon' => null,
                'icon_path' => '/storage/category_listings/land.png',
                'description' => 'Land for sale or rent',
                'active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Listing;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        // Titles and descriptions grouped by language
        $titles = [
            'ar' => [
                'شقة عصرية في وسط المدينة',
                'فيلا فاخرة مع مسبح خاص',
                'استوديو مفروش بالقرب من الجامعة',
                'منزل عائلي واسع في حي هادئ',
                'شقة مطلة على البحر مفروشة',
            ],
            'en' => [
                'Modern apartment downtown',
                'Luxury villa with private pool',
                'Furnished studio near university',
                'Spacious family house in quiet area',
                'Furnished sea view apartment',
            ],
            'fr' => [
                'Appartement moderne au centre-ville',
                'Villa de luxe avec piscine privée',
                'Studio meublé près de l’université',
                'Grande maison familiale dans un quartier calme',
                'Appartement meublé avec vue sur la mer',
            ],
        ];

        $descriptions = [
            'ar' => [
                'شقة جميلة ومجهزة بالكامل تقع في قلب المدينة، قريبة من جميع المرافق مثل المحلات التجارية ووسائل النقل. مناسبة للعائلات أو الأزواج.',
                'فيلا راقية تحتوي على مسبح خاص وحديقة واسعة، تقع في حي هادئ وآمن. مثالية للعائلات الكبيرة.',
                'استوديو صغير ومريح مفروش بالكامل، قريب جداً من الجامعة ووسائل النقل. مناسب للطلبة.',
                'منزل عائلي بمساحة كبيرة يحتوي على حديقة وموقف سيارات، يقع في حي سكني هادئ وآمن.',
                'شقة راقية بإطلالة مباشرة على البحر، مفروشة بالكامل وجاهزة للسكن، قريبة من المطاعم والمقاهي.',
            ],
            'en' => [
                'A beautiful, fully equipped apartment in the heart of the city, close to all amenities. Perfect for families or couples.',
                'A luxury villa with a private pool and large garden, located in a quiet and safe neighborhood. Ideal for large families.',
                'A small, cozy, fully furnished studio, very close to the university and transport. Suitable for students.',
                'A spacious family house with a garden and parking, located in a quiet and safe residential area.',
                'A high-end apartment with direct sea view, fully furnished and ready to move in, close to restaurants and cafes.',
            ],
            'fr' => [
                'Bel appartement entièrement équipé situé au cœur de la ville, proche de toutes commodités. Idéal pour familles ou couples.',
                'Villa haut de gamme avec piscine privée et grand jardin, située dans un quartier calme et sécurisé. Parfait pour les grandes familles.',
                'Petit studio confortable et entièrement meublé, très proche de l’université et des transports. Idéal pour les étudiants.',
                'Grande maison familiale avec jardin et parking, située dans un quartier résidentiel calme et sécurisé.',
                'Appartement haut de gamme avec vue directe sur la mer, entièrement meublé et prêt à emménager, proche des restaurants et cafés.',
            ],
        ];

        // Category, feature, and near place IDs (from seeders)
        $categoryIds = [1, 2, 3, 4, 5, 6];
        $featureIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        $nearPlaceIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        $member = User::where('phone', '=', '+213562695982')->first()->member;
        $languages = ['ar', 'en', 'fr'];
        // Get all location IDs seeded by LocationSeeder
        $locationIds = \App\Models\Location::pluck('id')->toArray();
        for ($i = 0; $i < 30; $i++) {
            $lang = $languages[array_rand($languages)];
            $title = $titles[$lang][array_rand($titles[$lang])];
            $description = $descriptions[$lang][array_rand($descriptions[$lang])];
            $price = rand(20000, 200000);
            $floor = rand(1, 6);
            $surface = rand(40, 350);
            $min_duration = [3, 6, 12][array_rand([3, 6, 12])];
            $number_rooms = rand(1, 7);
            $number_persons = rand(1, 12);
            $type_id = rand(1, 3);
            $main_image = 'listings/img-' . rand(1, 10) . '.jpg';
            $location_id = $locationIds[array_rand($locationIds)];

            $listing = Listing::create([
                'title' => $title,
                'description' => $description,
                'location_id' => $location_id,
                'rent_duration_id' => 1,
                'type_id' => $type_id,
                'member_id' => $member ? $member->id : 1,
                'price' => $price,
                'floor' => $floor,
                'surface' => $surface,
                'min_duration' => $min_duration,
                'number_rooms' => $number_rooms,
                'number_persons' => $number_persons,
                'is_active' => true,
                'is_ready' => true,
                'is_negotiable' => (bool)rand(0, 1),
                'verified_at' => now(),
                'moderation_status' => 'approved',
                'main_image' => $main_image,
            ]);

            // Attach random categories (1-2)
            $cats = array_rand(array_flip($categoryIds), rand(1, 2));
            $listing->categories()->attach((array)$cats);

            // Attach random features (2-4)
            $feats = array_rand(array_flip($featureIds), rand(2, 4));
            $listing->features()->attach((array)$feats);

            // Attach random near places (1-3)
            $nps = array_rand(array_flip($nearPlaceIds), rand(1, 3));
            $listing->nearPlaces()->attach((array)$nps);
        }
    }
}

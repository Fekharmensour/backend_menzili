<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Listing;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        $listings = [

            [
                'title' => 'شقة عصرية في وسط المدينة',
                'description' => 'شقة جميلة ومجهزة بالكامل تقع في قلب المدينة، قريبة من جميع المرافق مثل المحلات التجارية ووسائل النقل. مناسبة للعائلات أو الأزواج.',
                'price' => 45000,
                'floor' => 3,
                'surface' => 95,
                'min_duration' => 6,
                'number_rooms' => 3,
                'number_persons' => 5,
            ],

            [
                'title' => 'فيلا فاخرة مع مسبح خاص',
                'description' => 'فيلا راقية تحتوي على مسبح خاص وحديقة واسعة، تقع في حي هادئ وآمن. مثالية للعائلات الكبيرة.',
                'price' => 180000,
                'floor' => 1,
                'surface' => 320,
                'min_duration' => 12,
                'number_rooms' => 6,
                'number_persons' => 10,
            ],

            [
                'title' => 'استوديو مفروش بالقرب من الجامعة',
                'description' => 'استوديو صغير ومريح مفروش بالكامل، قريب جداً من الجامعة ووسائل النقل. مناسب للطلبة.',
                'price' => 25000,
                'floor' => 2,
                'surface' => 45,
                'min_duration' => 3,
                'number_rooms' => 1,
                'number_persons' => 2,
            ],

            [
                'title' => 'منزل عائلي واسع في حي هادئ',
                'description' => 'منزل عائلي بمساحة كبيرة يحتوي على حديقة وموقف سيارات، يقع في حي سكني هادئ وآمن.',
                'price' => 90000,
                'floor' => 2,
                'surface' => 210,
                'min_duration' => 12,
                'number_rooms' => 5,
                'number_persons' => 8,
            ],

            [
                'title' => 'شقة مطلة على البحر مفروشة',
                'description' => 'شقة راقية بإطلالة مباشرة على البحر، مفروشة بالكامل وجاهزة للسكن، قريبة من المطاعم والمقاهي.',
                'price' => 120000,
                'floor' => 5,
                'surface' => 130,
                'min_duration' => 6,
                'number_rooms' => 4,
                'number_persons' => 6,
            ],
        ];

        $member = User::where('phone' , '=' , '+213562695982')->first()->member;
        foreach ($listings as $index => $data) {

            $listing = Listing::create([
                'title' => $data['title'],
                'description' => $data['description'],

                'location_id' => 1,
                'rent_duration_id' => 1,
                'type_id' => 1,
                'member_id' => $member? $member->id : 1,

                'price' => $data['price'],
                'floor' => $data['floor'],
                'surface' => $data['surface'],
                'min_duration' => $data['min_duration'],
                'number_rooms' => $data['number_rooms'],
                'number_persons' => $data['number_persons'],

                'is_active' => true,
                'is_ready' => true,
                'is_negotiable' => false,
                'verified_at' => now(),
                'boost_level' => 1,
                'moderation_status' => 'approved',

                'main_image' => '/storage/listings/img-' . ($index + 1) . '.jpg',
            ]);

            // Attach relations (make sure IDs exist)
            $listing->categories()->attach([1]);
            $listing->features()->attach([1, 2]);
            $listing->nearPlaces()->attach([1]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ad;
use App\Models\Listing;
use App\Models\Member;
use App\Models\AdsPlan;
use Carbon\Carbon;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        $images = [];
        for ($i = 1; $i <= 5; $i++) {
            $images[] = 'ads/img-' . $i . '.jpg';
        }

        $externalUrls = [
            'https://example.com/promo',
            'https://example.org/offer',
            'https://booking.example.com/deal',
        ];

        $listingIds = Listing::pluck('id')->toArray();
        $memberIds = Member::pluck('id')->toArray();
        $adsPlans = AdsPlan::pluck('id', 'duration_days')->toArray();

        // fallback duration
        $defaultDuration = 7;

        for ($i = 0; $i < 5; $i++) {
            $image = $images[$i];

            // choose target type: prefer listing and external, occasionally member
            $types = ['listing', 'external', 'listing', 'external', 'member'];
            $targetType = $types[array_rand($types)];

            $listingId = null;
            $targetMemberId = null;
            $externalUrl = null;

            if ($targetType === 'listing' && count($listingIds) > 0) {
                $listingId = $listingIds[array_rand($listingIds)];
            } else if ($targetType === 'member' && count($memberIds) > 0) {
                $targetMemberId = $memberIds[array_rand($memberIds)];
            } else {
                // fallback to external
                $targetType = 'external';
                $externalUrl = $externalUrls[array_rand($externalUrls)];
            }

            // pick a plan (random) to set duration
            $plan = AdsPlan::inRandomOrder()->first();
            $duration = $plan ? ($plan->duration_days ?? $defaultDuration) : $defaultDuration;
            $adsPlanId = $plan ? $plan->id : null;

            $start = Carbon::now()->subDays(rand(0, 3));
            $end = (clone $start)->addDays($duration);

            Ad::create([
                'title' => 'Promotional Ad ' . ($i + 1),
                'description' => 'This is a sample ad for testing purposes.',
                'image_path' => $image,
                'target_type' => $targetType,
                'listing_id' => $listingId,
                'target_member_id' => $targetMemberId,
                'external_url' => $externalUrl,
                'start_date' => $start->toDateString(),
                'end_date' => $end->toDateString(),
                'status' => 'active',
                'member_id' => $memberIds ? $memberIds[array_rand($memberIds)] : null,
                'ads_plan_id' => $adsPlanId,
            ]);
        }
    }
}

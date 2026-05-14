<?php

namespace App\Services\Ad;

use App\Models\Ad;
use App\Models\AdsPlan;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdPublishingService
{
    /**
     * Business logic to publish an ad with a selected plan.
     * 
     * @throws ValidationException
     */
    public function publish(Member $member, AdsPlan $plan, array $adData): Ad
    {
        if (!$plan->is_active) {
            throw ValidationException::withMessages([
                'ads_plan_id' => 'This plan is currently not available.',
            ]);
        }

        // 1. Validate wallet balance
        if ($member->balance < $plan->coins) {
            throw ValidationException::withMessages([
                'wallet' => 'Insufficient coin balance. Please purchase more coins.',
            ]);
        }

        return DB::transaction(function () use ($member, $plan, $adData) {
            
            // 2. Deduct coins using bavix/laravel-wallet
            $member->withdraw($plan->coins, [
                'reason' => 'ad_publication',
                'plan_name' => $plan->name,
                'ad_title' => $adData['title'],
            ]);

            // 3. Calculate dates
            $startDate = now();
            $endDate = now()->addDays($plan->duration_days);

            // 4. Create the ad
            return Ad::create([
                ...$adData,
                'member_id' => $member->id,
                'ads_plan_id' => $plan->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
            ]);
        });
    }
}

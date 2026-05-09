<?php

namespace App\Services;

use App\Models\Boost;
use App\Models\Listing;
use App\Models\Member;

class RankingService
{
    /**
     * Apply boost to listing
     */
    public function boost(Listing $listing, Member $member, int $coins, int $durationDays = 30): Boost
    {
        // Check wallet
        if ($member->balance < $coins) {
            throw new \Exception("Insufficient coins. You have {$member->balance}, need {$coins}");
        }

        // Deduct coins
        $member->forceWithdraw($coins, ['reason' => 'listing_boost']);

        // Create boost
        $boost = Boost::create([
            'listing_id' => $listing->id,
            'member_id' => $member->id,
            'coins_spent' => $coins,
            'started_at' => now(),
            'expires_at' => now()->addDays($durationDays),
        ]);

        // Link to listing
        $listing->update(['active_boost_id' => $boost->id]);

        // Recalculate score
        $listing->updateFinalScore();

        return $boost;
    }

    /**
     * Expire boost and recalculate score
     */
    public function expireBoost(Boost $boost): void
    {
        $boost->expire();

        $listing = $boost->listing;
        $listing->update(['active_boost_id' => null]);
        $listing->updateFinalScore();
    }

    /**
     * Recalculate score for all listings
     * Run daily via scheduler
     */
    public function recalculateAllScores(): void
    {
        Listing::where('is_active', true)
               ->chunk(100, function ($listings) {
                   foreach ($listings as $listing) {
                       $listing->updateFinalScore();
                   }
               });
    }

    /**
     * Get score breakdown (for debugging)
     */
    public function getScoreBreakdown(Listing $listing): array
    {
        $boostScore = $listing->getBoostScore();
        $viewsScore = $listing->getViewsScore();
        $ratingScore = $listing->getRatingScore();
        $finalScore = $listing->calculateFinalScore();

        return [
            'boost_score' => [
                'value' => $boostScore,
                'weight' => 0.7,
                'contribution' => $boostScore * 0.7,
            ],
            'views_score' => [
                'value' => $viewsScore,
                'weight' => 0.2,
                'contribution' => $viewsScore * 0.2,
            ],
            'rating_score' => [
                'value' => $ratingScore,
                'weight' => 0.1,
                'contribution' => $ratingScore * 0.1,
            ],
            'final_score' => $finalScore,
        ];
    }
}

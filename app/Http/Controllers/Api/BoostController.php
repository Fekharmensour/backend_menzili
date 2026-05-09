<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Services\RankingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BoostController extends Controller
{
    public function __construct(protected RankingService $rankingService) {}

    /**
     * Apply boost to listing
     * POST /api/listings/{id}/boost
     * Body: { "coins": 200 }
     */
    public function boost(Request $request, Listing $listing)
    {
        $member = Auth::user()->member;
        if(!$member || $listing->member_id != $member->id){
            return response()->json([
                'success' => false,
                'message' => __('api.common.unauthorized'),
                'status' => 403


            ]);
        }

        $validated = $request->validate([
            'coins' => 'required|integer',
        ]);


        try {
            $boost = $this->rankingService->boost(
                $listing,
                $member,
                $validated['coins']
            );

            return response()->json([
                'success' => true,
                'message' => __('api.boost.success'),
                'boost' => $boost,
                'listing_final_score' => $listing->fresh()->final_score,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Get score breakdown for listing
     * GET /api/listings/{id}/score-breakdown
     */
    public function getScoreBreakdown(Listing $listing)
    {
        return response()->json([
            'success' => true,
            'message' => __('api.boost.score_breakdown'),
            "data" => $this->rankingService->getScoreBreakdown($listing)]
        );
    }
}

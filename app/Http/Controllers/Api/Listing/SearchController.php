<?php

namespace App\Http\Controllers\Api\Listing;

use App\Filters\ListingFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Listing\ListingResource;
use App\Http\Resources\Api\Listing\PaginateResource;
use App\Models\Listing;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Get listings ranked by final score
     * GET /api/listings?category=&location=
     */
    #[Group('Listings with score ranked')]
    public function search(Request $request)
    {
        $query = Listing::where('is_active', true)
            ->with([
                'rentDuration',
                'location.city.wilaya.country'
            ])
            ->orderByDesc('final_score');

        // ✅ Apply filters (same as ListingController)
        $query = (new ListingFilter($request, $query))->apply();

        $listings = $query->paginate(
            (int) $request->get('per_page', 8)
        );

        // ✅ Same response format
        return response()->json([
            'success' => true,
            'data' => new PaginateResource($listings)
        ]);
    }

    /**
     * Get top boosted listings
     * GET /api/listings/top-boosted
     */
    public function topBoosted()
    {
        $topListings = Listing::where('is_active', true)
            ->with([
                'rentDuration',
                'location.city.wilaya.country'
            ])
            ->orderByDesc('final_score')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => ListingResource::collection($topListings)
        ]);
    }
}

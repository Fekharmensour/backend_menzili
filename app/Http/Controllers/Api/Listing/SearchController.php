<?php

namespace App\Http\Controllers\Api\Listing;

use App\Filters\ListingFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Listing\ListingResource;
use App\Http\Resources\Api\Listing\PaginateResource;
use App\Models\Listing;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Get listings ranked by final score
     * GET /api/listings?category=&location=
     */
    #[Group('Listings with score ranked')]
    #[QueryParameter('search', type: 'string', description: 'Search in title or description')]

    #[QueryParameter('type_id', type: 'integer', description: 'Property type id')]
    #[QueryParameter('member_id', type: 'integer', description: 'Owner member id')]
    #[QueryParameter('rent_duration_id', type: 'integer', description: 'Rent duration type')]

    #[QueryParameter('wilaya_id', type: 'integer', description: 'Filter by wilaya')]
    #[QueryParameter('city_id', type: 'integer', description: 'Filter by city')]

    #[QueryParameter('category_ids', type: 'array', description: 'Filter by categories')]
    #[QueryParameter('feature_ids', type: 'array', description: 'Filter by features')]
    #[QueryParameter('near_place_ids', type: 'array', description: 'Filter by nearby places')]

    #[QueryParameter('min_price', type: 'number', description: 'Minimum price')]
    #[QueryParameter('max_price', type: 'number', description: 'Maximum price')]

    #[QueryParameter('min_surface', type: 'number', description: 'Minimum surface')]
    #[QueryParameter('max_surface', type: 'number', description: 'Maximum surface')]

    #[QueryParameter('number_rooms', type: 'integer', description: 'Minimum number of rooms')]
    #[QueryParameter('number_persons', type: 'integer', description: 'Minimum number of persons')]

    #[QueryParameter('min_floor', type: 'integer', description: 'Minimum floor')]
    #[QueryParameter('max_floor', type: 'integer', description: 'Maximum floor')]

    #[QueryParameter('min_duration', type: 'integer', description: 'User rent duration in months')]

    #[QueryParameter('is_ready', type: 'boolean', description: 'Property ready to move in')]
    #[QueryParameter('is_negotiable', type: 'boolean', description: 'Price negotiable')]

    #[QueryParameter('per_page', type: 'integer', example: 4, description: 'Pagination size')]
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

<?php

namespace App\Http\Controllers\Api\Listing;

use App\Filters\ListingFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Listing\StoreRequest;
use App\Http\Requests\Listing\UpdateRequest;
use App\Http\Resources\Api\Listing\ListingResource;
use App\Http\Resources\Api\Listing\PaginateResource;
use App\Models\Listing;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Dedoc\Scramble\Attributes\QueryParameter;
use Dedoc\Scramble\Attributes\BodyParameter;
//use OpenApi\Attributes as OA;

class ListingController extends Controller
{

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
    public function index(Request $request)
    {

        $query = Listing::with([
            'rentDuration',
            'location.city.wilaya.country'
        ]);

        $query = (new ListingFilter($request, $query))->apply();

        $listings = $query->paginate($request->get('per_page', 4));

        return response()->json([
            'success' => true,
            'data' => new PaginateResource($listings)
        ]);
    }

    public function show(Listing $listing)
    {
        $listing->load([
            'member',
            'rentDuration',
            'type',
            'location.city.wilaya',
            'categories',
            'features',
            'nearPlaces',
            'images'
        ]);

        return response()->json([
            'success' => true,
            'message' => __('api.listings.show.success'),
            'data' => new ListingResource($listing),
        ]);

    }




//    public function index(Request $request)
//    {
//        $perPage = $request->get('per_page', 4);
//
//        $cacheKey = 'listings_index_' . md5(json_encode($request->all()));
//
//        $listings = Cache::tags(['listings_index'])->remember(
//            $cacheKey,
//            now()->addMinutes(10),
//            function () use ($request, $perPage) {
//
//                $query = Listing::query()
//                    ->with([
//                        'rentDuration',
//                        'location.city.wilaya.country'
//                    ]);
//
//                $query = (new ListingFilter($request, $query))->apply();
//
//                return $query->paginate($perPage);
//            }
//        );
//
//        return response()->json([
//            'success' => true,
//            'message' => __('api.listings.index.success'),
//            'data' => new PaginateResource($listings)
//        ]);
//    }
//    public function show(Listing $listing)
//    {
//        $cacheKey = "listing_show_{$listing->id}";
//
//        $listing = Cache::tags(['listings_show'])->remember(
//            $cacheKey,
//            now()->addMinutes(30),
//            function () use ($listing) {
//
//                return Listing::with([
//                    'member',
//                    'rentDuration',
//                    'type',
//                    'location.city.wilaya',
//                    'categories',
//                    'features',
//                    'nearPlaces',
//                    'images'
//                ])->findOrFail($listing->id);
//
//            }
//        );
//
//        return response()->json([
//            'success' => true,
//            'message' => __('api.listings.show.success'),
//            'data' => new ListingResource($listing),
//        ]);
//    }


    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */

    /**
     * @requestMediaType application/json
     */

}

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
//        return response()->json([
//            'all' => $request->all(),
//            'input' => $request->input(),
//            'query' => $request->query(),
//            'search' => $request->get('search'),
//            'json' => $request->json()->all(),
//            'content' => json_decode($request->getContent(), true)
//        ]);
        $query = Listing::with([
            'rentDuration',
//            'member',
//            'features',
//            'categories',
//            'nearPlaces',
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
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        $listing = DB::transaction(function () use ($validated, $request) {

            // 1️⃣ Create Location first
            $location = Location::create([
                'latitude'  => $validated['location']['latitude'],
                'longitude' => $validated['location']['longitude'],
                'altitude'  => $validated['location']['altitude'] ?? null,
                'zip_code'  => $validated['location']['zip_code'] ?? null,
                'city_id'   => $validated['location']['city_id'],
            ]);

            // 2️⃣ Handle image upload
            $imagePath = null;
            if ($request->hasFile('main_image')) {
                $imagePath = $request->file('main_image')
                    ->store('listings', 'public');
            }

            // 3️⃣ Create Listing explicitly
            $listing = Listing::create([
                'title'            => $validated['title'],
                'description'      => $validated['description'] ?? null,
                'price'            => $validated['price'],
                'floor'            => $validated['floor'] ?? 1,
                'surface'          => $validated['surface'] ?? null,
                'min_duration'     => $validated['min_duration'] ?? 1,
                'number_rooms'     => $validated['number_rooms'] ?? 1,
                'number_persons'   => $validated['number_persons'] ?? 2,

                'is_ready'         => $validated['is_ready'] ?? true,
                'is_negotiable'    => $validated['is_negotiable'] ?? false,

                'boost_level'      => $validated['boost_level'] ?? 7 ,      // system default

                'main_image'       => $imagePath,

                'member_id'        => auth()->id(), // secure
                'rent_duration_id' => $validated['rent_duration_id'],
                'type_id'          => $validated['type_id'],
                'location_id'      => $location->id,
            ]);
            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $image) {

                    $listing->images()->create([
                        'path' => $image->store('listings/gallery', 'public')
                    ]);

                }
            }

            // 4️⃣ Sync relations
            if (!empty($validated['categories'])) {
                $listing->categories()->sync($validated['categories']);
            }

            if (!empty($validated['features'])) {
                $listing->features()->sync($validated['features']);
            }

            if (!empty($validated['near_places'])) {
                $listing->nearPlaces()->sync($validated['near_places']);
            }

            return $listing;
        });

        return response()->json([
            'success' => true,
            'message' => __('api.listings.store.success'),
            'data' => new ListingResource($listing),
        ], 201);
    }

    /**
     * Display the specified resource.
     */

    /**
     * @requestMediaType application/json
     */
    public function update(UpdateRequest $request, Listing $listing)
    {
        $member = Auth::user()->member;
        if(!$member || $listing->member_id != $member->id){
            return response()->json([
                'success' => false,
                'message' => __('api.listings.update.unauthorized'),
            ], 403);
        }
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request, $listing) {

            $listing->update(
                collect($validated)->except([
                    'location',
                    'categories',
                    'features',
                    'near_places',
                    'images',
                    'main_image'
                ])->toArray()
            );


            if (isset($validated['location']) && $listing->location) {
                $listing->location->update([
                    'latitude' => $validated['location']['latitude'],
                    'longitude' => $validated['location']['longitude'],
                    'altitude' => $validated['location']['altitude'] ?? null,
                    'zip_code' => $validated['location']['zip_code'] ?? null,
                    'city_id' => $validated['location']['city_id'],
                ]);
            }

            if ($request->hasFile('main_image')) {

                $listing->main_image = $listing->updateMainImage(
                    $request->file('main_image')
                );
                $listing->save();
            }


            if ($request->hasFile('images')) {

                // Delete old gallery images
                foreach ($listing->images as $image) {
                    $image->deleteWithFile();
                }

                foreach ($request->file('images') as $file) {

                    $listing->images()->create([
                        'path' => $file->store('listings/gallery', 'public')
                    ]);
                }
            }


            if (isset($validated['categories'])) {
                $listing->categories()->sync($validated['categories']);
            }

            if (isset($validated['features'])) {
                $listing->features()->sync($validated['features']);
            }

            if (isset($validated['near_places'])) {
                $listing->nearPlaces()->sync($validated['near_places']);
            }


        });

        return response()->json([
            'success' => true,
            'message' => __('api.listings.update.success'),
            'data' => new ListingResource($listing),
        ]);
    }



    public function destroy(Listing $listing)
    {
        $member = Auth::user()->member;
        if(!$member || $listing->member_id != $member->id){
            return response()->json([
                'success' => false,
                'message' => __('api.listings.update.unauthorized'),
            ], 403);
        }
        DB::transaction(function () use ($listing) {

            if ($listing->main_image) {
                $listing->deleteMainImage();
            }


            foreach ($listing->images as $image) {
                $image->deleteWithFile();
            }


            if ($listing->location) {
                $listing->location->delete();
            }


            $listing->categories()->detach();
            $listing->features()->detach();
            $listing->nearPlaces()->detach();


            $listing->delete();

        });

        return response()->json([
            'success' => true,
            'message' => __('api.listings.destroy.success')
        ]);
    }
}

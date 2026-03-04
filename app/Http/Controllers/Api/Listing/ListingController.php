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
use Illuminate\Support\Facades\DB;
//use OpenApi\Attributes as OA;

class ListingController extends Controller
{


    public function index(Request $request)
    {
        $query = Listing::with([
            'rentDuration',
            'member',
            'features',
            'categories',
            'nearPlaces',
            'location.city.wilaya.country'
        ]);

        $query = (new ListingFilter($request, $query))->apply();

        $listings = $query->paginate($request->get('per_page', 4));

        return response()->json([
            'success' => true,
            'data' => new PaginateResource($listings)
        ]);
    }

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
    /**
     * @requestMediaType application/json
     */
    public function update(UpdateRequest $request, Listing $listing)
    {
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

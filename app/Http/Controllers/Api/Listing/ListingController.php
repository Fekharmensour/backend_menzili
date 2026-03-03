<?php

namespace App\Http\Controllers\Api\Listing;

use App\Filters\ListingFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Listing\ListingResource;
use App\Http\Resources\Api\Listing\PaginateResource;
use App\Models\Listing;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        //
    }
}

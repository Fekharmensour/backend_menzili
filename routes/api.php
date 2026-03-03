<?php

use App\Http\Resources\Api\TypeResource;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/get_data', function (Request $request) {
    $types = \App\Models\Type::all();
    return response()->json(TypeResource::collection($types));
});

Route::post('/listings/update' , function (Request $request) {
    $validated = $request->validate([
        'id' => 'required|exists:listings,id',
        'url' => 'required|url'
    ]);
    $listing = Listing::find($validated['id']);
    $listing->url = $validated['url'];
    $listing->save();
    return response()->json([
        'success' => true,
        'message' => trans('api.listings.update.success')
    ]);
});

Require __DIR__.'/ApiRouters/Auth.php';
Require __DIR__.'/ApiRouters/Listing.php';

<?php

use App\Http\Resources\Api\TypeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/get_data', function (Request $request) {
    $types = \App\Models\Type::all();
    return response()->json(TypeResource::collection($types));
});

Require __DIR__.'/ApiRouters/Auth.php';
Require __DIR__.'/ApiRouters/Listing.php';

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

Route::get('/pay', [\App\Http\Controllers\ChargilyPayController::class, 'redirect']);
Route::post('/webhook', [\App\Http\Controllers\ChargilyPayController::class, 'webhook']);
Route::get('/success', [\App\Http\Controllers\ChargilyPayController::class, 'success']);
Route::get('/failed', [\App\Http\Controllers\ChargilyPayController::class, 'failed']);



Require __DIR__.'/ApiRouters/Auth.php';
Require __DIR__.'/ApiRouters/Listing.php';
Require __DIR__.'/ApiRouters/Member.php';
Require __DIR__.'/ApiRouters/Profile.php';

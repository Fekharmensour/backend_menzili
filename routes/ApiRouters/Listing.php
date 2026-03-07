<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::prefix('listings')->group(function () {
    Route::resource('/', \App\Http\Controllers\Api\Listing\ListingController::class)
        ->parameters(['' => 'listing'])
        ->only(['index', 'show']);

    Route::resource('/', \App\Http\Controllers\Api\Listing\ListingController::class)
        ->parameters(['' => 'listing'])
        ->only(['store', 'update', 'destroy'])
        ->middleware('auth:sanctum');

    // Static routes
    Route::get('details', [\App\Http\Controllers\Api\Listing\DetailsController::class, 'index']);
    Route::get('wilayas', [\App\Http\Controllers\Api\Listing\DetailsController::class, 'wilayas']);
    Route::get('cities', [\App\Http\Controllers\Api\Listing\DetailsController::class, 'cities']);
});


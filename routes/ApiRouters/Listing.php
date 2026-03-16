<?php

use Illuminate\Support\Facades\Route;

Route::prefix('listings')->group(function () {
    Route::get('details', [\App\Http\Controllers\Api\Listing\DetailsController::class, 'index']);
    Route::get('wilayas', [\App\Http\Controllers\Api\Listing\DetailsController::class, 'wilayas']);
    Route::get('cities', [\App\Http\Controllers\Api\Listing\DetailsController::class, 'cities']);


    Route::get('/', [\App\Http\Controllers\Api\Listing\ListingController::class, 'index']);
    Route::get('{listing}', [\App\Http\Controllers\Api\Listing\ListingController::class, 'show']);


});


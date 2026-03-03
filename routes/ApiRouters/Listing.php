<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::resource('listings', \App\Http\Controllers\Api\Listing\ListingController::class)->only([
    'index'
]);
Route::get('listings/details', [\App\Http\Controllers\Api\Listing\DetailsController::class, 'index']);
Route::get('listings/wilayas', [\App\Http\Controllers\Api\Listing\DetailsController::class, 'wilayas']);
Route::get('listings/cities', [\App\Http\Controllers\Api\Listing\DetailsController::class, 'cities']);


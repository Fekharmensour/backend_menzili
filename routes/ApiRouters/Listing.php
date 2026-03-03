<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::resource('listings', \App\Http\Controllers\Api\Listing\ListingController::class)->only([
    'index'
]);



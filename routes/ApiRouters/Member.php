<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::prefix('members')->middleware('auth:sanctum')->group(function () {

    Route::resource('listings', \App\Http\Controllers\Api\Member\ListingController::class);

});


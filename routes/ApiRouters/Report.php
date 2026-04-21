<?php

use App\Http\Resources\Api\TypeResource;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth:sanctum', 'fill_name'])->group(function () {


    Route::post('/listings/{listing}/report', [\App\Http\Controllers\Api\Report\ListingController::class, 'reportListing']);


    Route::post('/members/{target}/report', [\App\Http\Controllers\Api\Report\MemberController::class, 'reportMember']);

});

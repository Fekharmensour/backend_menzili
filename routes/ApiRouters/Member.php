<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Member\PublicProfileController;

Route::get('/members/coin-packages', [\App\Http\Controllers\Api\Member\CoinPackageController::class, 'index']);

// Move dynamic routes below static ones to avoid conflicts
Route::prefix('members')->middleware(['auth:sanctum','fill_name'])->group(function () {
    Route::get('ads/plans', [\App\Http\Controllers\Api\Ad\AdController::class, 'plans']);
    Route::get('ads', [\App\Http\Controllers\Api\Ad\AdController::class, 'memberAds']);
    Route::get('recent-activity', [\App\Http\Controllers\Api\Member\MemberActivityController::class, 'index']);


    // Get packages & buy

    Route::post('/coin-packages/{package}/buy', [\App\Http\Controllers\Api\Member\CoinPackageController::class, 'buy']);
    // Baridimob receipt upload
    Route::post('/coin-packages/upload-receipt', [\App\Http\Controllers\Api\Member\CoinPackageController::class, 'uploadReceipt']);
    // Check purchase status
    Route::get('/coin-purchases/{purchase}/status', [\App\Http\Controllers\Api\Member\CoinPackageController::class, 'status']);



    // Support direct POST request for multipart form updates (Flutter/Next.js workaround)
    Route::get('listings/top-boosters', [\App\Http\Controllers\Api\BoostController::class, 'topBoosters']);
    Route::post('listings/{listing}', [\App\Http\Controllers\Api\Member\ListingController::class, 'update']);
    Route::resource('listings', \App\Http\Controllers\Api\Member\ListingController::class)->except('update');
    Route::post('listings/{listing}/toggle-status', [\App\Http\Controllers\Api\Member\ListingController::class, 'toggleStatus']);
    Route::post('listings/{listing}/boost', [\App\Http\Controllers\Api\BoostController::class, 'boost']);


});

Route::get('/members/{member}', [PublicProfileController::class, 'show'])->where('member', '[0-9]+');
Route::get('/members/{member}/listings', [PublicProfileController::class, 'listings'])->where('member', '[0-9]+');
Route::get('/members/{member}/reviews', [PublicProfileController::class, 'reviews'])->where('member', '[0-9]+');

Route::prefix('wallet')->middleware(['auth:sanctum','fill_name'])->group(function () {

    Route::get('/', [\App\Http\Controllers\Api\Member\WalletController::class, 'show']); // member wallet info
    Route::get('/transactions', [\App\Http\Controllers\Api\Member\WalletController::class, 'transactions']); // wallet transactions
//    Route::post('/coins', [\App\Http\Controllers\Api\Member\WalletController::class, 'addCoins']); // deposit coins

});

Route::apiResource('ads', \App\Http\Controllers\Api\Ad\AdController::class)
    ->only(['index', 'show']);

Route::middleware(['auth:sanctum', 'fill_name'])
    ->group(function () {
        Route::post('ads/{ad}',[\App\Http\Controllers\Api\Ad\AdController::class ,'update']);
        Route::apiResource('ads', \App\Http\Controllers\Api\Ad\AdController::class)
            ->except(['index', 'show','update']);
    });



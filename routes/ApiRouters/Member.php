<?php

use Illuminate\Support\Facades\Route;

Route::get('/members/coin-packages', [\App\Http\Controllers\Api\Member\CoinPackageController::class, 'index']);
Route::prefix('members')->middleware(['auth:sanctum','fill_name'])->group(function () {
    Route::get('ads/plans', [\App\Http\Controllers\Api\Ad\AdController::class, 'plans']);
    Route::get('ads', [\App\Http\Controllers\Api\Ad\AdController::class, 'memberAds']);


    // Get packages & buy

    Route::post('/coin-packages/{package}/buy', [\App\Http\Controllers\Api\Member\CoinPackageController::class, 'buy']);
    // Baridimob receipt upload
    Route::post('/coin-packages/upload-receipt', [\App\Http\Controllers\Api\Member\CoinPackageController::class, 'uploadReceipt']);
    // Check purchase status
    Route::get('/coin-purchases/{purchase}/status', [\App\Http\Controllers\Api\Member\CoinPackageController::class, 'status']);



    Route::resource('listings', \App\Http\Controllers\Api\Member\ListingController::class);
    Route::post('listings/{listing}/boost', [\App\Http\Controllers\Api\BoostController::class, 'boost']);

});

Route::prefix('wallet')->middleware(['auth:sanctum','fill_name'])->group(function () {

    Route::get('/', [\App\Http\Controllers\Api\Member\WalletController::class, 'show']); // member wallet info
    Route::get('/transactions', [\App\Http\Controllers\Api\Member\WalletController::class, 'transactions']); // wallet transactions
    Route::post('/coins', [\App\Http\Controllers\Api\Member\WalletController::class, 'addCoins']); // deposit coins

});

Route::apiResource('ads', \App\Http\Controllers\Api\Ad\AdController::class)
    ->only(['index', 'show']);

Route::middleware(['auth:sanctum', 'fill_name'])
    ->group(function () {
        Route::apiResource('ads', \App\Http\Controllers\Api\Ad\AdController::class)
            ->except(['index', 'show']);
    });



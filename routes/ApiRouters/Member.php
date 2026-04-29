<?php

use Illuminate\Support\Facades\Route;

Route::prefix('members')->middleware(['auth:sanctum','fill_name'])->group(function () {

    Route::resource('listings', \App\Http\Controllers\Api\Member\ListingController::class);

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

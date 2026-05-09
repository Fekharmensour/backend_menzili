<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth:sanctum' , 'fill_name'])->group(function () {
    Route::get('/coin-purchases', [\App\Http\Controllers\Api\Admin\CoinPurchaseController::class, 'index']);
    Route::post('/coin-purchases/{purchase}/approve', [\App\Http\Controllers\Api\Admin\CoinPurchaseController::class, 'approve']);
});

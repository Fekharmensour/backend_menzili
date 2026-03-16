<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum','fill_name'])->prefix('members/profile')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'show']);
    Route::put('/', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'update']);
    Route::post('/image', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'updateImage']);
    Route::put('/password', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'updatePassword']);
    Route::post('/verify-member', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'verifyMember']);
    Route::post('/verify-agent', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'verifyAgent']);
});


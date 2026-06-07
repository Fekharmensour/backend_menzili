<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login',     [AuthController::class, 'requestOtp'])->middleware('throttle:otp');

    Route::post('valid-otp', [AuthController::class, 'verifyOtp'])->middleware('throttle:6,1');
    Route::post('fcm-token', [AuthController::class, 'storeFcmTokenForCurrentUser'])->middleware('auth:sanctum');
    Route::post('fill-name', [AuthController::class, 'completeProfile'])->middleware('auth:sanctum');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');




    Route::prefix('password')->group(function () {
        Route::post('login',     [AuthController::class, 'login']);
        Route::post('request-otp', [\App\Http\Controllers\Api\Auth\PasswordResetController::class, 'requestResetOtp'])->middleware('throttle:otp');
        Route::post('verify-otp',  [\App\Http\Controllers\Api\Auth\PasswordResetController::class, 'verifyReset'])->middleware('throttle:6,1');

        Route::post('store',       [\App\Http\Controllers\Api\Auth\PasswordResetController::class, 'storeNewPassword'])
            ->middleware('auth:sanctum');
    });
});


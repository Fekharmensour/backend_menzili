<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login',     [AuthController::class, 'requestOtp']);

    Route::post('valid-otp', [AuthController::class, 'verifyOtp']);
    Route::post('fill-name', [AuthController::class, 'completeProfile'])->middleware('auth:sanctum');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');




    Route::prefix('password')->group(function () {
        Route::post('login',     [AuthController::class, 'login']);
        Route::post('request-otp', [\App\Http\Controllers\Api\Auth\PasswordResetController::class, 'requestResetOtp']);
        Route::post('verify-otp',  [\App\Http\Controllers\Api\Auth\PasswordResetController::class, 'verifyReset']);

        Route::post('store',       [\App\Http\Controllers\Api\Auth\PasswordResetController::class, 'storeNewPassword'])
            ->middleware('auth:sanctum');
    });
});



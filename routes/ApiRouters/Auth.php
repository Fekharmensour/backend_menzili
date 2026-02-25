<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('login',     [AuthController::class, 'requestOtp']);
    Route::post('valid-otp', [AuthController::class, 'verifyOtp']);
    Route::post('fill-name', [AuthController::class, 'completeProfile'])->middleware('auth:sanctum');
});



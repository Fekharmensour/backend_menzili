<?php

use App\Http\Controllers\Api\Ai\ChatController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chatbot', [ChatController::class, 'index']);
    Route::post('/chatbot', [ChatController::class, 'handle']);
});

<?php

use App\Http\Controllers\Api\Ai\ChatController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/conversations', [ChatController::class, 'index']);
    Route::post('/chat', [ChatController::class, 'handle']);
});

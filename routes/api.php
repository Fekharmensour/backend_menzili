<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/get_data', function (Request $request) {
    return __('auth.user_not_found');
});

Require __DIR__.'/ApiRouters/Auth.php';

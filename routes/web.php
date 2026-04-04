<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'en|ar|fr']], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/success', [\App\Http\Controllers\ChargilyPayController::class, 'success']);
    Route::get('/failed', [\App\Http\Controllers\ChargilyPayController::class, 'failed']);

});

<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'en|ar|fr']], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/docs', action: function () {
        return view('swagger-ui');
    })->name('api.docs');

});

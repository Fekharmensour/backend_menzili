<?php

use App\Http\Resources\Api\TypeResource;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {

    Route::get('/reports/listings', [\App\Http\Controllers\Api\Admin\ReportController::class, 'listingReports']);

    Route::get('/reports/members', [\App\Http\Controllers\Api\Admin\ReportController::class, 'memberReports']);

    Route::get('/reports', [\App\Http\Controllers\Api\Admin\ReportController::class, 'allReports']);

});

<?php

use App\Http\Controllers\WpSiteCheckController;
use App\Http\Controllers\WpSiteController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::get('/wp-sites', [WpSiteController::class, 'index']);
    Route::get('/wp-sites/{id}', [WpSiteController::class, 'show']);
    Route::post('/wp-sites', [WpSiteController::class, 'store']);
    Route::put('/wp-sites/{id}', [WpSiteController::class, 'update']);
    Route::delete('/wp-sites/{id}', [WpSiteController::class, 'destroy']);

    Route::get('/wp-sites/{id}/check-admin', [WpSiteCheckController::class, 'checkOne']);
//    Route::get('/wp-sites/check-admin', [WpSiteCheckController::class, 'checkAll']);
});


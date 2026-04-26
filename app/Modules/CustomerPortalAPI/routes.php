<?php

/**
 * @file: routes.php
 * @description: CustomerPortalAPI Module Routes
 * @author: Team Leader (Khalid)
 */

use Illuminate\Support\Facades\Route;
use App\Modules\CustomerPortalAPI\Controllers\TrackingController;
use App\Modules\CustomerPortalAPI\Controllers\FeedbackController;

Route::prefix('api/v1')->group(function () {
    Route::prefix('tracking')->group(function () {
        Route::post('/links', [TrackingController::class, 'generateLink']);
        Route::get('/{token}', [TrackingController::class, 'track']);
        Route::get('/{token}/timeline', [TrackingController::class, 'getTimeline']);
    });

    Route::prefix('feedback')->middleware('auth:sanctum')->group(function () {
        Route::post('/', [FeedbackController::class, 'store']);
        Route::post('/{id}/respond', [FeedbackController::class, 'respond'])->where('id', '[0-9]+');
        Route::get('/analytics', [FeedbackController::class, 'analytics']);
        Route::get('/rating', [FeedbackController::class, 'getRating']);
    });
});

<?php

/**
 * @file: routes.php
 * @description: NotificationEngine Module Routes
 * @author: Team Leader (Khalid)
 */

use Illuminate\Support\Facades\Route;
use App\Modules\NotificationEngine\Controllers\NotificationController;

Route::prefix('api/v1')->middleware('auth:sanctum')->group(function () {
    Route::prefix('notifications')->group(function () {
        Route::post('/send', [NotificationController::class, 'send']);
        Route::get('/stats', [NotificationController::class, 'stats']);
    });
});

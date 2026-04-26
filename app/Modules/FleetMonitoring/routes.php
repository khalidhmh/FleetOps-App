<?php

/**
 * @file: routes.php
 * @description: FleetMonitoring Module Routes
 * @author: Team Leader (Khalid)
 */

use Illuminate\Support\Facades\Route;
use App\Modules\FleetMonitoring\Controllers\FuelController;
use App\Modules\FleetMonitoring\Controllers\IncidentController;
use App\Modules\FleetMonitoring\Controllers\PerformanceController;

Route::prefix('api/v1')->middleware('auth:sanctum')->group(function () {
    Route::prefix('fuel')->group(function () {
        Route::post('/transactions', [FuelController::class, 'store']);
        Route::get('/efficiency/{vehicleId}', [FuelController::class, 'getEfficiency'])->where('vehicleId', '[0-9]+');
        Route::get('/anomalies/{vehicleId}', [FuelController::class, 'detectAnomalies'])->where('vehicleId', '[0-9]+');
    });

    Route::prefix('incidents')->group(function () {
        Route::post('/', [IncidentController::class, 'store']);
        Route::get('/{id}', [IncidentController::class, 'show'])->where('id', '[0-9]+');
        Route::post('/{id}/investigate', [IncidentController::class, 'investigate'])->where('id', '[0-9]+');
        Route::post('/{id}/close', [IncidentController::class, 'close'])->where('id', '[0-9]+');
        Route::get('/stats', [IncidentController::class, 'getStats']);
    });

    Route::prefix('performance')->group(function () {
        Route::get('/driver/{driverId}', [PerformanceController::class, 'getScore'])->where('driverId', '[0-9]+');
        Route::get('/rankings', [PerformanceController::class, 'getRankings']);
        Route::get('/top-performers', [PerformanceController::class, 'getTopPerformers']);
        Route::get('/at-risk', [PerformanceController::class, 'getAtRiskDrivers']);
    });
});

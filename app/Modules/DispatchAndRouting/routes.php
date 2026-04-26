<?php

/**
 * @file: routes.php
 * @description: DispatchAndRouting Module Routes - تعريف نقاط النهاية للتوزيع والتوجيه
 * @author: Team Leader (Khalid)
 */

use Illuminate\Support\Facades\Route;
use App\Modules\DispatchAndRouting\Controllers\RouteController;
use App\Modules\DispatchAndRouting\Controllers\ShiftController;

Route::prefix('api/v1')->middleware('auth:sanctum')->group(function () {
    // =============================
    // Route Management
    // =============================
    Route::prefix('routes')->group(function () {
        // CRUD الأساسية
        Route::get('/', [RouteController::class, 'index'])
            ->name('routes.index');
        Route::post('/', [RouteController::class, 'store'])
            ->name('routes.store');
        Route::get('/{id}', [RouteController::class, 'show'])
            ->name('routes.show')
            ->where('id', '[0-9]+');
        Route::put('/{id}', [RouteController::class, 'update'])
            ->name('routes.update')
            ->where('id', '[0-9]+');
        Route::delete('/{id}', [RouteController::class, 'destroy'])
            ->name('routes.destroy')
            ->where('id', '[0-9]+');

        // Specialized Routes
        Route::post('/{id}/start', [RouteController::class, 'startRoute'])
            ->name('routes.start')
            ->where('id', '[0-9]+');
        Route::post('/{id}/complete', [RouteController::class, 'completeRoute'])
            ->name('routes.complete')
            ->where('id', '[0-9]+');
        Route::post('/{id}/optimize', [RouteController::class, 'optimizeRoute'])
            ->name('routes.optimize')
            ->where('id', '[0-9]+');
        Route::get('/driver/{driverId}', [RouteController::class, 'driverRoutes'])
            ->name('routes.driver')
            ->where('driverId', '[0-9]+');
    });

    // =============================
    // Shift Management
    // =============================
    Route::prefix('shifts')->group(function () {
        // CRUD الأساسية
        Route::get('/', [ShiftController::class, 'index'])
            ->name('shifts.index');
        Route::post('/', [ShiftController::class, 'store'])
            ->name('shifts.store');
        Route::get('/{id}', [ShiftController::class, 'show'])
            ->name('shifts.show')
            ->where('id', '[0-9]+');
        Route::put('/{id}', [ShiftController::class, 'update'])
            ->name('shifts.update')
            ->where('id', '[0-9]+');

        // Specialized Routes
        Route::post('/{id}/start', [ShiftController::class, 'startShift'])
            ->name('shifts.start')
            ->where('id', '[0-9]+');
        Route::post('/{id}/end', [ShiftController::class, 'endShift'])
            ->name('shifts.end')
            ->where('id', '[0-9]+');
        Route::post('/{id}/break', [ShiftController::class, 'recordBreak'])
            ->name('shifts.break')
            ->where('id', '[0-9]+');
        Route::get('/{id}/summary', [ShiftController::class, 'getSummary'])
            ->name('shifts.summary')
            ->where('id', '[0-9]+');
    });
});

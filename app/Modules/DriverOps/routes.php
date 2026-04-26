<?php

/**
 * @file: routes.php
 * @description: DriverOps Module Routes - تعريف نقاط النهاية لعمليات السائقين
 * @author: Team Leader (Khalid)
 */

use Illuminate\Support\Facades\Route;
use App\Modules\DriverOps\Controllers\DeliveryController;
use App\Modules\DriverOps\Controllers\CashController;

Route::prefix('api/v1')->middleware('auth:sanctum')->group(function () {
    // =============================
    // Delivery Management
    // =============================
    Route::prefix('deliveries')->group(function () {
        Route::post('/', [DeliveryController::class, 'store'])
            ->name('deliveries.store');
        Route::post('/{id}/pod-photo', [DeliveryController::class, 'uploadPODPhoto'])
            ->name('deliveries.pod-photo')
            ->where('id', '[0-9]+');
        Route::post('/{id}/signature', [DeliveryController::class, 'uploadSignature'])
            ->name('deliveries.signature')
            ->where('id', '[0-9]+');
        Route::post('/{id}/reject', [DeliveryController::class, 'rejectDelivery'])
            ->name('deliveries.reject')
            ->where('id', '[0-9]+');
        Route::get('/stats', [DeliveryController::class, 'getStats'])
            ->name('deliveries.stats');
        Route::get('/driver/{driverId}', [DeliveryController::class, 'driverDeliveries'])
            ->name('deliveries.driver')
            ->where('driverId', '[0-9]+');
    });

    // =============================
    // Cash Management
    // =============================
    Route::prefix('cash')->group(function () {
        Route::post('/transactions', [CashController::class, 'store'])
            ->name('cash.store');
        Route::get('/balance/{driverId}', [CashController::class, 'getBalance'])
            ->name('cash.balance')
            ->where('driverId', '[0-9]+');
        Route::post('/reconcile', [CashController::class, 'reconcileDaily'])
            ->name('cash.reconcile');
        Route::get('/history/{driverId}', [CashController::class, 'getCashHistory'])
            ->name('cash.history')
            ->where('driverId', '[0-9]+');
        Route::post('/report-discrepancy', [CashController::class, 'reportDiscrepancy'])
            ->name('cash.discrepancy');
        Route::post('/payment-request', [CashController::class, 'requestPayment'])
            ->name('cash.payment-request');
    });
});

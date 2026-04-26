<?php

/**
 * @file: routes.php
 * @description: SystemAudit Module Routes
 * @author: Team Leader (Khalid)
 */

use Illuminate\Support\Facades\Route;
use App\Modules\SystemAudit\Controllers\AuditController;

Route::prefix('api/v1')->middleware('auth:sanctum')->group(function () {
    Route::prefix('audit')->group(function () {
        Route::get('/logs', [AuditController::class, 'getLogs']);
        Route::get('/report', [AuditController::class, 'generateReport']);
        Route::get('/entity/{type}/{id}/history', [AuditController::class, 'getEntityHistory'])
            ->where('id', '[0-9]+');
        Route::get('/anomalies', [AuditController::class, 'detectAnomalies']);
    });
});

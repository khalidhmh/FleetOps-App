<?php

/**
 * @file: routes.php
 * @description: Routes الخاصة بموديول Maintenance Tracker
 * يتم تحميل هذا الملف تلقائياً من ModuleServiceProvider
 * @author: Team Leader (Khalid)
 */

use Illuminate\Support\Facades\Route;
use App\Modules\MaintenanceTracker\Controllers\MaintenanceTrackerController;

/**
 * جميع الـ Routes مسبوقة بـ /api/maintenance
 */
Route::prefix('api/maintenance')
    ->middleware(['api'])
    ->group(function () {
        
        /**
         * عرض الإحصائيات
         */
        Route::get('/stats', [MaintenanceTrackerController::class, 'getStatistics'])
            ->name('maintenance.stats');

        /**
         * البحث المتقدم
         */
        Route::post('/search', [MaintenanceTrackerController::class, 'search'])
            ->name('maintenance.search');

        /**
         * الصيانات المتأخرة
         */
        Route::get('/overdue', [MaintenanceTrackerController::class, 'getOverdue'])
            ->name('maintenance.overdue');

        /**
         * الصيانات القادمة
         */
        Route::get('/upcoming', [MaintenanceTrackerController::class, 'getUpcoming'])
            ->name('maintenance.upcoming');

        /**
         * صيانات مركبة معينة
         */
        Route::get('/vehicle/{vehicleId}', [MaintenanceTrackerController::class, 'getByVehicle'])
            ->name('maintenance.by-vehicle')
            ->where('vehicleId', '[0-9]+');

        /**
         * الصيانات المعلقة لمركبة معينة
         */
        Route::get('/vehicle/{vehicleId}/pending', [MaintenanceTrackerController::class, 'getPendingByVehicle'])
            ->name('maintenance.pending-by-vehicle')
            ->where('vehicleId', '[0-9]+');

        /**
         * الـ CRUD الأساسي
         */
        Route::get('/', [MaintenanceTrackerController::class, 'index'])
            ->name('maintenance.index');

        Route::post('/', [MaintenanceTrackerController::class, 'store'])
            ->name('maintenance.store');

        Route::get('/{id}', [MaintenanceTrackerController::class, 'show'])
            ->name('maintenance.show')
            ->where('id', '[0-9]+');

        Route::put('/{id}', [MaintenanceTrackerController::class, 'update'])
            ->name('maintenance.update')
            ->where('id', '[0-9]+');

        Route::patch('/{id}', [MaintenanceTrackerController::class, 'update'])
            ->name('maintenance.update')
            ->where('id', '[0-9]+');

        Route::delete('/{id}', [MaintenanceTrackerController::class, 'destroy'])
            ->name('maintenance.destroy')
            ->where('id', '[0-9]+');

        /**
         * تحديث الحالة
         */
        Route::patch('/{id}/status', [MaintenanceTrackerController::class, 'updateStatus'])
            ->name('maintenance.update-status')
            ->where('id', '[0-9]+');

        /**
         * جدولة الصيانة التالية
         */
        Route::post('/{id}/schedule-next', [MaintenanceTrackerController::class, 'scheduleNext'])
            ->name('maintenance.schedule-next')
            ->where('id', '[0-9]+');

        /**
         * إتمام الصيانة
         */
        Route::post('/{id}/complete', [MaintenanceTrackerController::class, 'complete'])
            ->name('maintenance.complete')
            ->where('id', '[0-9]+');
    });

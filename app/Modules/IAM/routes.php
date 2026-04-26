<?php

/**
 * @file: routes.php
 * @description: IAM Module Routes - تعريف جميع نقاط نهاية المصادقة وإدارة المستخدمين
 * @author: Team Leader (Khalid)
 */

use Illuminate\Support\Facades\Route;
use App\Modules\IAM\Controllers\AuthController;
use App\Modules\IAM\Controllers\UserController;
use App\Modules\IAM\Controllers\RoleController;

Route::prefix('api/v1')->group(function () {
    // =============================
    // Authentication Routes (Public)
    // =============================
    Route::prefix('auth')->group(function () {
        // تسجيل الدخول
        Route::post('/login', [AuthController::class, 'login'])
            ->name('login')
            ->middleware('throttle:5,1');

        // طلب إعادة تعيين كلمة المرور
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])
            ->name('forgot-password')
            ->middleware('throttle:5,1');

        // إعادة تعيين كلمة المرور
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])
            ->name('reset-password')
            ->middleware('throttle:5,1');
    });

    // =============================
    // Protected Routes (Auth Required)
    // =============================
    Route::middleware('auth:sanctum')->group(function () {
        // تسجيل الخروج
        Route::post('/auth/logout', [AuthController::class, 'logout'])
            ->name('logout');

        // تحديث التوكن
        Route::post('/auth/refresh', [AuthController::class, 'refreshToken'])
            ->name('refresh-token');

        // تغيير كلمة المرور
        Route::post('/auth/change-password', [AuthController::class, 'changePassword'])
            ->name('change-password');

        // =============================
        // User Management Routes
        // =============================
        Route::prefix('users')->group(function () {
            // CRUD الأساسية
            Route::get('/', [UserController::class, 'index'])
                ->name('users.index');
            Route::post('/', [UserController::class, 'store'])
                ->name('users.store');
            Route::get('/{id}', [UserController::class, 'show'])
                ->name('users.show')
                ->where('id', '[0-9]+');
            Route::put('/{id}', [UserController::class, 'update'])
                ->name('users.update')
                ->where('id', '[0-9]+');
            Route::delete('/{id}', [UserController::class, 'destroy'])
                ->name('users.destroy')
                ->where('id', '[0-9]+');

            // Specialized Routes
            Route::get('/status/active', [UserController::class, 'active'])
                ->name('users.active');
            Route::get('/role/drivers', [UserController::class, 'drivers'])
                ->name('users.drivers');
            Route::get('/role/dispatchers', [UserController::class, 'dispatchers'])
                ->name('users.dispatchers');
            Route::get('/role/fleet-managers', [UserController::class, 'fleetManagers'])
                ->name('users.fleet-managers');
            Route::get('/role/mechanics', [UserController::class, 'mechanics'])
                ->name('users.mechanics');
        });

        // =============================
        // Role Management Routes
        // =============================
        Route::prefix('roles')->group(function () {
            // CRUD الأساسية
            Route::get('/', [RoleController::class, 'index'])
                ->name('roles.index');
            Route::post('/', [RoleController::class, 'store'])
                ->name('roles.store');
            Route::get('/{id}', [RoleController::class, 'show'])
                ->name('roles.show')
                ->where('id', '[0-9]+');
            Route::put('/{id}', [RoleController::class, 'update'])
                ->name('roles.update')
                ->where('id', '[0-9]+');
            Route::delete('/{id}', [RoleController::class, 'destroy'])
                ->name('roles.destroy')
                ->where('id', '[0-9]+');

            // Specialized Routes
            Route::get('/type/non-system', [RoleController::class, 'nonSystemRoles'])
                ->name('roles.non-system');
        });
    });
});

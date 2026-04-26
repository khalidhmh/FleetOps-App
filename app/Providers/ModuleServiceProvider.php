<?php

/**
 * @file: ModuleServiceProvider.php
 * @description: مسؤول عن تسجيل كل الموديولات والـ Repositories كـ Singletons
 * وتحميل الـ Routes والقائمة البيضاء (Service Locator Pattern)
 * @author: Team Leader (Khalid)
 * @version: 2.0
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * قائمة الموديولات
     * @var array
     */
    protected $modules = [
        'IAM',
        'MaintenanceTracker',
        'DispatchAndRouting',
        'DriverOps',
        'FleetMonitoring',
        'CustomerPortalAPI',
        'NotificationEngine',
        'SystemAudit'
    ];

    /**
     * تسجيل الـ Repositories كـ Singletons
     * Singleton pattern يضمن أن يكون هناك instance واحد فقط لكل Repository في Application Lifecycle
     * @return void
     */
    public function register()
    {
        // تسجيل Repositories للـ IAM Module - استخدام User model
        $this->app->singleton(
            \App\Modules\IAM\Repositories\IAMRepository::class,
            function ($app) {
                return new \App\Modules\IAM\Repositories\IAMRepository(
                    new \App\Modules\IAM\Models\User()
                );
            }
        );

        $this->app->singleton(
            \App\Modules\IAM\Repositories\RoleRepository::class,
            function ($app) {
                return new \App\Modules\IAM\Repositories\RoleRepository(
                    new \App\Modules\IAM\Models\Role()
                );
            }
        );

        $this->app->singleton(
            \App\Modules\IAM\Repositories\PermissionRepository::class,
            function ($app) {
                return new \App\Modules\IAM\Repositories\PermissionRepository(
                    new \App\Modules\IAM\Models\Permission()
                );
            }
        );

        // تسجيل Repositories للـ DispatchAndRouting Module
        $this->app->singleton(
            \App\Modules\DispatchAndRouting\Repositories\DispatchAndRoutingRepository::class,
            function ($app) {
                return new \App\Modules\DispatchAndRouting\Repositories\DispatchAndRoutingRepository(
                    new \App\Modules\DispatchAndRouting\Models\Route()
                );
            }
        );

        // تسجيل Repositories للـ DriverOps Module
        $this->app->singleton(
            \App\Modules\DriverOps\Repositories\DriverOpsRepository::class,
            function ($app) {
                return new \App\Modules\DriverOps\Repositories\DriverOpsRepository(
                    new \App\Modules\DriverOps\Models\DeliveryRecord()
                );
            }
        );

        // تسجيل Repositories للـ FleetMonitoring Module
        $this->app->singleton(
            \App\Modules\FleetMonitoring\Repositories\FleetMonitoringRepository::class,
            function ($app) {
                return new \App\Modules\FleetMonitoring\Repositories\FleetMonitoringRepository(
                    new \App\Modules\FleetMonitoring\Models\FuelTransaction()
                );
            }
        );

        // تسجيل Repositories للـ CustomerPortalAPI Module
        $this->app->singleton(
            \App\Modules\CustomerPortalAPI\Repositories\CustomerPortalAPIRepository::class,
            function ($app) {
                return new \App\Modules\CustomerPortalAPI\Repositories\CustomerPortalAPIRepository(
                    new \App\Modules\CustomerPortalAPI\Models\TrackingLink()
                );
            }
        );

        // تسجيل Repositories للـ NotificationEngine Module
        $this->app->singleton(
            \App\Modules\NotificationEngine\Repositories\NotificationEngineRepository::class,
            function ($app) {
                return new \App\Modules\NotificationEngine\Repositories\NotificationEngineRepository(
                    new \App\Modules\NotificationEngine\Models\NotificationLog()
                );
            }
        );

        // تسجيل Repositories للـ SystemAudit Module
        $this->app->singleton(
            \App\Modules\SystemAudit\Repositories\SystemAuditRepository::class,
            function ($app) {
                return new \App\Modules\SystemAudit\Repositories\SystemAuditRepository(
                    new \App\Modules\SystemAudit\Models\AuditLogEntry()
                );
            }
        );

        // تسجيل الـ Services
        $this->registerServices();
    }

    /**
     * تحميل الـ Routes والـ Views والـ Assets
     * @return void
     */
    public function boot(){
        // كود بيلف على كل الموديولات ويشغل ملفات الـ routes.php بتاعتها
        $moduleRoutes = glob(app_path('Modules/*/routes.php'));
        foreach ($moduleRoutes as $routeFile) {
            $this->loadRoutesFrom($routeFile);
        }
    }

    /**
     * تحميل الـ Routes من كل موديول
     * @return void
     */
    protected function loadRoutes()
    {
        foreach ($this->modules as $module) {
            $routesPath = base_path("app/Modules/{$module}/routes.php");

            if (file_exists($routesPath)) {
                Route::group([
                    'prefix' => 'api',
                ], function () use ($routesPath) {
                    require $routesPath;
                });
            }
        }
    }

    /**
     * تسجيل الـ Services
     * @return void
     */
    protected function registerServices()
    {
        // تسجيل MaintenanceTrackerService
        $this->app->singleton(
            \App\Modules\MaintenanceTracker\Services\MaintenanceTrackerService::class,
            function ($app) {
                return new \App\Modules\MaintenanceTracker\Services\MaintenanceTrackerService(
                    $app->make(\App\Modules\MaintenanceTracker\Repositories\MaintenanceTrackerRepository::class)
                );
            }
        );

        // تسجيل باقي الـ Services بنفس الطريقة
        // ...
    }

    /**
     * احصل على قائمة الموديولات المتاحة
     * @return array
     */
    public function getModules()
    {
        return $this->modules;
    }
}

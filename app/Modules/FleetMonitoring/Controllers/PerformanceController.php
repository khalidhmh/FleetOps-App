<?php

/**
 * @file: PerformanceController.php
 * @description: متحكم أداء السائق
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\FleetMonitoring\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\FleetMonitoring\Services\DriverPerformanceService;
use Illuminate\Http\JsonResponse;

class PerformanceController extends Controller
{
    protected DriverPerformanceService $performanceService;

    public function __construct(DriverPerformanceService $performanceService)
    {
        $this->performanceService = $performanceService;
    }

    /**
     * درجة أداء السائق
     * GET /api/v1/performance/driver/{driverId}
     */
    public function getScore(int $driverId): JsonResponse
    {
        // TODO: Implement get performance score
    }

    /**
     * ترتيب السائقين
     * GET /api/v1/performance/rankings
     */
    public function getRankings(): JsonResponse
    {
        // TODO: Implement get rankings
    }

    /**
     * أفضل السائقين
     * GET /api/v1/performance/top-performers
     */
    public function getTopPerformers(): JsonResponse
    {
        // TODO: Implement get top performers
    }

    /**
     * السائقون المحتاجون لتدريب
     * GET /api/v1/performance/at-risk
     */
    public function getAtRiskDrivers(): JsonResponse
    {
        // TODO: Implement get at-risk drivers
    }
}

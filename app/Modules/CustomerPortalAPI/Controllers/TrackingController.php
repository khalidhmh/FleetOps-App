<?php

/**
 * @file: TrackingController.php
 * @description: متحكم التتبع
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\CustomerPortalAPI\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CustomerPortalAPI\Services\TrackingService;
use Illuminate\Http\JsonResponse;

class TrackingController extends Controller
{
    protected TrackingService $trackingService;

    public function __construct(TrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * إنشاء رابط تتبع
     * POST /api/v1/tracking/links
     */
    public function generateLink(): JsonResponse
    {
        // TODO: Implement generate link
    }

    /**
     * تتبع الطلب
     * GET /api/v1/tracking/{token}
     */
    public function track(string $token): JsonResponse
    {
        // TODO: Implement track order
    }

    /**
     * الحصول على الجدول الزمني
     * GET /api/v1/tracking/{token}/timeline
     */
    public function getTimeline(string $token): JsonResponse
    {
        // TODO: Implement get timeline
    }
}

<?php

/**
 * @file: FleetMonitoringController.php
 * @description: المتحكم الذي يستقبل طلبات الـ API لموديول FleetMonitoring.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\FleetMonitoring\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\FleetMonitoring\Services\FleetMonitoringService;
class FleetMonitoringController extends Controller { 
    protected $service; public function __construct(FleetMonitoringService $service) {
         $this->service = $service; 
         } 
}

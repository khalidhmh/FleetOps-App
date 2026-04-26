<?php

/**
 * @file: FleetMonitoringService.php
 * @description: العقل المدبر لموديول FleetMonitoring حيث يكتب التيم الـ Business Logic.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\FleetMonitoring\Services;

use App\Modules\FleetMonitoring\Repositories\FleetMonitoringRepository;
class FleetMonitoringService { protected $repo; public function __construct(FleetMonitoringRepository $repo) { 
    $this->repo = $repo; 
    }
}

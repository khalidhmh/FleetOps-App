<?php

/**
 * @file: DriverOpsController.php
 * @description: المتحكم الذي يستقبل طلبات الـ API لموديول DriverOps.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\DriverOps\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DriverOps\Services\DriverOpsService;
class DriverOpsController extends Controller { protected $service; public function __construct(DriverOpsService $service) {
     $this->service = $service; 
     }
}

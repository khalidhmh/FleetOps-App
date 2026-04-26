<?php

/**
 * @file: DispatchAndRoutingController.php
 * @description: المتحكم الذي يستقبل طلبات الـ API لموديول DispatchAndRouting.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\DispatchAndRouting\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DispatchAndRouting\Services\DispatchAndRoutingService;
class DispatchAndRoutingController extends Controller {
     protected $service; public function __construct(DispatchAndRoutingService $service) {
         $this->service = $service; 
         }
    }

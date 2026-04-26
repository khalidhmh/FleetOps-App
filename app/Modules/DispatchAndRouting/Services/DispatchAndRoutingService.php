<?php

/**
 * @file: DispatchAndRoutingService.php
 * @description: العقل المدبر لموديول DispatchAndRouting حيث يكتب التيم الـ Business Logic.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\DispatchAndRouting\Services;

use App\Modules\DispatchAndRouting\Repositories\DispatchAndRoutingRepository;
class DispatchAndRoutingService { protected $repo; public function __construct(DispatchAndRoutingRepository $repo) {
     $this->repo = $repo; 
     }
}

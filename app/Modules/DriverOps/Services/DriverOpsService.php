<?php

/**
 * @file: DriverOpsService.php
 * @description: العقل المدبر لموديول DriverOps حيث يكتب التيم الـ Business Logic.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\DriverOps\Services;

use App\Modules\DriverOps\Repositories\DriverOpsRepository;
class DriverOpsService { protected $repo; public function __construct(DriverOpsRepository $repo) {
     $this->repo = $repo; 
     }
}

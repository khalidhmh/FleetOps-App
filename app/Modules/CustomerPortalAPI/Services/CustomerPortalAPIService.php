<?php

/**
 * @file: CustomerPortalAPIService.php
 * @description: العقل المدبر لموديول CustomerPortalAPI حيث يكتب التيم الـ Business Logic.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\CustomerPortalAPI\Services;

use App\Modules\CustomerPortalAPI\Repositories\CustomerPortalAPIRepository;
class CustomerPortalAPIService { protected $repo; public function __construct(CustomerPortalAPIRepository $repo) { 
    $this->repo = $repo;
     }
}

<?php

/**
 * @file: CustomerPortalAPIController.php
 * @description: المتحكم الذي يستقبل طلبات الـ API لموديول CustomerPortalAPI.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\CustomerPortalAPI\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CustomerPortalAPI\Services\CustomerPortalAPIService;
class CustomerPortalAPIController extends Controller {
     protected $service; public function __construct(CustomerPortalAPIService $service) { 
        $this->service = $service;
         } 
    }

<?php

/**
 * @file: IAMController.php
 * @description: المتحكم الذي يستقبل طلبات الـ API لموديول IAM.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\IAM\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\IAM\Services\IAMService;
class IAMController extends Controller { 
    protected $service; public function __construct(IAMService $service) { 
        $this->service = $service; 
        }
}

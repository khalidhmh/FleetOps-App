<?php

/**
 * @file: NotificationEngineController.php
 * @description: المتحكم الذي يستقبل طلبات الـ API لموديول NotificationEngine.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\NotificationEngine\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\NotificationEngine\Services\NotificationEngineService;
class NotificationEngineController extends Controller { 
    protected $service; public function __construct(NotificationEngineService $service) { 
        $this->service = $service; 
        }
}

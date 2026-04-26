<?php

/**
 * @file: SystemAuditController.php
 * @description: المتحكم الذي يستقبل طلبات الـ API لموديول SystemAudit.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\SystemAudit\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SystemAudit\Services\SystemAuditService;
class SystemAuditController extends Controller {
    protected $service; public function __construct(SystemAuditService $service) {
        $this->service = $service;
        }
}

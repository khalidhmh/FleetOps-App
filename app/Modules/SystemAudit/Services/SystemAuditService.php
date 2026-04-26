<?php

/**
 * @file: SystemAuditService.php
 * @description: العقل المدبر لموديول SystemAudit حيث يكتب التيم الـ Business Logic.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\SystemAudit\Services;

use App\Modules\SystemAudit\Repositories\SystemAuditRepository;
class SystemAuditService { protected $repo; public function __construct(SystemAuditRepository $repo) {
    $this->repo = $repo;
    }
}

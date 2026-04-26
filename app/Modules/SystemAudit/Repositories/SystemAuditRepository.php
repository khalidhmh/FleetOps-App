<?php

/**
 * @file: SystemAuditRepository.php
 * @description: مستودع البيانات لموديول SystemAudit - يتم استدعاؤه كـ Singleton.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\SystemAudit\Repositories;

use App\Modules\Shared\Repositories\BaseRepository;
use App\Modules\SystemAudit\Models\SystemAuditModel;
class SystemAuditRepository extends BaseRepository {
    public function __construct(SystemAuditModel $model) { 
        parent::__construct($model); 
        }
}

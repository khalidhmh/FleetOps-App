<?php

/**
 * @file: DriverOpsRepository.php
 * @description: مستودع البيانات لموديول DriverOps - يتم استدعاؤه كـ Singleton.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\DriverOps\Repositories;

use App\Modules\Shared\Repositories\BaseRepository;
use App\Modules\DriverOps\Models\DriverOpsModel;
class DriverOpsRepository extends BaseRepository { 
    public function __construct(DriverOpsModel $model) { 
        parent::__construct($model); 
        }
}

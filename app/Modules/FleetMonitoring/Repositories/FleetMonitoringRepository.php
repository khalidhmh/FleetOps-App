<?php

/**
 * @file: FleetMonitoringRepository.php
 * @description: مستودع البيانات لموديول FleetMonitoring - يتم استدعاؤه كـ Singleton.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\FleetMonitoring\Repositories;

use App\Modules\Shared\Repositories\BaseRepository;
use App\Modules\FleetMonitoring\Models\FleetMonitoringModel;
class FleetMonitoringRepository extends BaseRepository { 
    public function __construct(FleetMonitoringModel $model) { 
        parent::__construct($model);
         } 
    }

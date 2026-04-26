<?php

/**
 * @file: NotificationEngineRepository.php
 * @description: مستودع البيانات لموديول NotificationEngine - يتم استدعاؤه كـ Singleton.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\NotificationEngine\Repositories;

use App\Modules\Shared\Repositories\BaseRepository;
use App\Modules\NotificationEngine\Models\NotificationEngineModel;
class NotificationEngineRepository extends BaseRepository { 
    public function __construct(NotificationEngineModel $model) { 
        parent::__construct($model);
         }
}

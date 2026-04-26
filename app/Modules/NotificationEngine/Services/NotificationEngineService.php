<?php

/**
 * @file: NotificationEngineService.php
 * @description: العقل المدبر لموديول NotificationEngine حيث يكتب التيم الـ Business Logic.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\NotificationEngine\Services;

use App\Modules\NotificationEngine\Repositories\NotificationEngineRepository;
class NotificationEngineService { protected $repo; public function __construct(NotificationEngineRepository $repo) {
    $this->repo = $repo;
    }
}

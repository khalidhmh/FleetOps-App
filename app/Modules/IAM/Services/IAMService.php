<?php

/**
 * @file: IAMService.php
 * @description: العقل المدبر لموديول IAM حيث يكتب التيم الـ Business Logic.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\IAM\Services;

use App\Modules\IAM\Repositories\IAMRepository;
class IAMService { protected $repo; public function __construct(IAMRepository $repo) {
    $this->repo = $repo;
    }
}

<?php

/**
 * @file: IAMRepository.php
 * @description: مستودع البيانات لموديول IAM - يتم استدعاؤه كـ Singleton.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\IAM\Repositories;

use App\Modules\Shared\Repositories\BaseRepository;
use App\Modules\IAM\Models\IAMModel;
class IAMRepository extends BaseRepository {
     public function __construct(IAMModel $model) { parent::__construct($model); 
     }
}

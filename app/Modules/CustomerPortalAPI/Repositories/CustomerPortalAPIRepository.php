<?php

/**
 * @file: CustomerPortalAPIRepository.php
 * @description: مستودع البيانات لموديول CustomerPortalAPI - يتم استدعاؤه كـ Singleton.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\CustomerPortalAPI\Repositories;

use App\Modules\Shared\Repositories\BaseRepository;
use App\Modules\CustomerPortalAPI\Models\CustomerPortalAPIModel;
class CustomerPortalAPIRepository extends BaseRepository { 
    public function __construct(CustomerPortalAPIModel $model) {
         parent::__construct($model); 
         }
    }

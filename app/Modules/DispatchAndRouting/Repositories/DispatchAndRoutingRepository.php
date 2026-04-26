<?php

/**
 * @file: DispatchAndRoutingRepository.php
 * @description: مستودع البيانات لموديول DispatchAndRouting - يتم استدعاؤه كـ Singleton.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\DispatchAndRouting\Repositories;

use App\Modules\Shared\Repositories\BaseRepository;
use App\Modules\DispatchAndRouting\Models\DispatchAndRoutingModel;
class DispatchAndRoutingRepository extends BaseRepository { 
    public function __construct(DispatchAndRoutingModel $model) {
         parent::__construct($model);
          } 
    }

<?php

/**
 * @file: NotificationEngineRequest.php
 * @description: مسؤول عن الـ Validation لمدخلات موديول NotificationEngine.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\NotificationEngine\Requests;

use Illuminate\Foundation\Http\FormRequest;
class NotificationEngineRequest extends FormRequest { 
    public function rules() { return []; 
    }
}

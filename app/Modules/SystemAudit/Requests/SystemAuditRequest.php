<?php

/**
 * @file: SystemAuditRequest.php
 * @description: مسؤول عن الـ Validation لمدخلات موديول SystemAudit.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\SystemAudit\Requests;

use Illuminate\Foundation\Http\FormRequest;
class SystemAuditRequest extends FormRequest { 
    public function rules() { return []; 
    }
}

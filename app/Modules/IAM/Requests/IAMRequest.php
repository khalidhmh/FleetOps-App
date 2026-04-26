<?php

/**
 * @file: IAMRequest.php
 * @description: مسؤول عن الـ Validation لمدخلات موديول IAM.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\IAM\Requests;

use Illuminate\Foundation\Http\FormRequest;
class IAMRequest extends FormRequest { 
    public function rules() { 
        return []; 
        }
}

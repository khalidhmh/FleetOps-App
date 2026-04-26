<?php

/**
 * @file: CustomerPortalAPIRequest.php
 * @description: مسؤول عن الـ Validation لمدخلات موديول CustomerPortalAPI.
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\CustomerPortalAPI\Requests;

use Illuminate\Foundation\Http\FormRequest;
class CustomerPortalAPIRequest extends FormRequest { 
    public function rules() { return []; 
    } 
}

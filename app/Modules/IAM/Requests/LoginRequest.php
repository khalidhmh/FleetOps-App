<?php

/**
 * @file: LoginRequest.php
 * @description: طلب التحقق من بيانات تسجيل الدخول
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\IAM\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني يجب أن يكون صحيحاً',
            'email.max' => 'البريد الإلكتروني لا يزيد عن 255 حرف',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.string' => 'كلمة المرور يجب أن تكون نصاً',
            'password.min' => 'كلمة المرور لا تقل عن 8 أحرف',
            'password.max' => 'كلمة المرور لا تزيد عن 255 حرف',
        ];
    }
}

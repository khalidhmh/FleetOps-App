<?php

/**
 * @file: PasswordResetRequest.php
 * @description: طلب التحقق من بيانات إعادة تعيين كلمة المرور
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\IAM\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $action = $this->route()->getName();

        if ($action === 'forgot-password') {
            return [
                'email' => 'required|email|max:255|exists:users,email',
            ];
        }

        if ($action === 'reset-password') {
            return [
                'token' => 'required|string',
                'email' => 'required|email|max:255|exists:users,email',
                'password' => 'required|string|min:8|max:255|confirmed',
            ];
        }

        // change-password
        return [
            'old_password' => 'required|string|min:8|max:255',
            'password' => 'required|string|min:8|max:255|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني يجب أن يكون صحيحاً',
            'email.exists' => 'البريد الإلكتروني غير موجود',
            'token.required' => 'رمز التحقق مطلوب',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور لا تقل عن 8 أحرف',
            'password.max' => 'كلمة المرور لا تزيد عن 255 حرف',
            'password.confirmed' => 'تأكيد كلمة المرور لا يطابق',
            'old_password.required' => 'كلمة المرور القديمة مطلوبة',
            'old_password.min' => 'كلمة المرور القديمة لا تقل عن 8 أحرف',
        ];
    }
}

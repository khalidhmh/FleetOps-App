<?php

/**
 * @file: UserRequest.php
 * @description: طلب التحقق من بيانات المستخدم
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\IAM\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user') ?? null;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $userId,
            'password' => $userId ? 'nullable|string|min:8|max:255' : 'required|string|min:8|max:255',
            'role' => 'required|in:driver,dispatcher,fleet_manager,mechanic',
            'employee_id' => 'nullable|string|max:255|unique:users,employee_id,' . $userId,
            'license_type' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,suspended',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.string' => 'الاسم يجب أن يكون نصاً',
            'name.max' => 'الاسم لا يزيد عن 255 حرف',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني يجب أن يكون صحيحاً',
            'email.max' => 'البريد الإلكتروني لا يزيد عن 255 حرف',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',
            'phone.string' => 'رقم الهاتف يجب أن يكون نصاً',
            'phone.max' => 'رقم الهاتف لا يزيد عن 20 حرف',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.string' => 'كلمة المرور يجب أن تكون نصاً',
            'password.min' => 'كلمة المرور لا تقل عن 8 أحرف',
            'password.max' => 'كلمة المرور لا تزيد عن 255 حرف',
            'role.required' => 'الدور مطلوب',
            'role.in' => 'الدور يجب أن يكون أحد: driver, dispatcher, fleet_manager, mechanic',
            'employee_id.string' => 'رقم الموظف يجب أن يكون نصاً',
            'employee_id.max' => 'رقم الموظف لا يزيد عن 255 حرف',
            'employee_id.unique' => 'رقم الموظف مستخدم بالفعل',
            'license_type.string' => 'نوع الرخصة يجب أن يكون نصاً',
            'license_type.max' => 'نوع الرخصة لا يزيد عن 100 حرف',
            'status.required' => 'الحالة مطلوبة',
            'status.in' => 'الحالة يجب أن تكون أحد: active, inactive, suspended',
        ];
    }
}

<?php

/**
 * @file: RoleRequest.php
 * @description: طلب التحقق من بيانات الأدوار
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\IAM\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roleId = $this->route('role') ?? null;

        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $roleId,
            'slug' => 'required|string|max:255|unique:roles,slug,' . $roleId,
            'description' => 'nullable|string|max:1000',
            'is_system_role' => 'required|boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,permission_id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الدور مطلوب',
            'name.string' => 'اسم الدور يجب أن يكون نصاً',
            'name.max' => 'اسم الدور لا يزيد عن 255 حرف',
            'name.unique' => 'اسم الدور مستخدم بالفعل',
            'slug.required' => 'Slug الدور مطلوب',
            'slug.string' => 'Slug الدور يجب أن يكون نصاً',
            'slug.max' => 'Slug الدور لا يزيد عن 255 حرف',
            'slug.unique' => 'Slug الدور مستخدم بالفعل',
            'description.string' => 'الوصف يجب أن يكون نصاً',
            'description.max' => 'الوصف لا يزيد عن 1000 حرف',
            'is_system_role.required' => 'حقل النظام مطلوب',
            'is_system_role.boolean' => 'حقل النظام يجب أن يكون قيمة منطقية',
            'permissions.array' => 'الصلاحيات يجب أن تكون مصفوفة',
            'permissions.*.integer' => 'معرف الصلاحية يجب أن يكون رقماً',
            'permissions.*.exists' => 'الصلاحية المحددة غير موجودة',
        ];
    }
}

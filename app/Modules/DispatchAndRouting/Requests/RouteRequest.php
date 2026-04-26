<?php

/**
 * @file: RouteRequest.php
 * @description: طلب التحقق من بيانات المسار
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\DispatchAndRouting\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RouteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'driver_id' => 'required|integer|exists:users,user_id',
            'vehicle_id' => 'required|integer|exists:vehicles,vehicle_id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_location' => 'required|string|max:255',
            'end_location' => 'required|string|max:255',
            'distance_km' => 'nullable|numeric|min:0',
            'estimated_duration_minutes' => 'required|integer|min:1',
            'scheduled_date' => 'required|date',
            'status' => 'required|in:new,scheduled,in_progress,completed,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'driver_id.required' => 'معرف السائق مطلوب',
            'driver_id.integer' => 'معرف السائق يجب أن يكون رقماً',
            'driver_id.exists' => 'السائق المحدد غير موجود',
            'vehicle_id.required' => 'معرف المركبة مطلوب',
            'vehicle_id.integer' => 'معرف المركبة يجب أن يكون رقماً',
            'vehicle_id.exists' => 'المركبة المحددة غير موجودة',
            'name.required' => 'اسم المسار مطلوب',
            'name.string' => 'اسم المسار يجب أن يكون نصاً',
            'name.max' => 'اسم المسار لا يزيد عن 255 حرف',
            'description.string' => 'الوصف يجب أن يكون نصاً',
            'description.max' => 'الوصف لا يزيد عن 1000 حرف',
            'start_location.required' => 'موقع البداية مطلوب',
            'start_location.string' => 'موقع البداية يجب أن يكون نصاً',
            'start_location.max' => 'موقع البداية لا يزيد عن 255 حرف',
            'end_location.required' => 'موقع النهاية مطلوب',
            'end_location.string' => 'موقع النهاية يجب أن يكون نصاً',
            'end_location.max' => 'موقع النهاية لا يزيد عن 255 حرف',
            'distance_km.numeric' => 'المسافة يجب أن تكون رقماً',
            'distance_km.min' => 'المسافة يجب أن تكون موجبة',
            'estimated_duration_minutes.required' => 'المدة المقدرة مطلوبة',
            'estimated_duration_minutes.integer' => 'المدة المقدرة يجب أن تكون رقماً',
            'estimated_duration_minutes.min' => 'المدة المقدرة يجب أن تكون موجبة',
            'scheduled_date.required' => 'التاريخ المجدول مطلوب',
            'scheduled_date.date' => 'التاريخ المجدول يجب أن يكون تاريخاً صحيحاً',
            'status.required' => 'الحالة مطلوبة',
            'status.in' => 'الحالة يجب أن تكون أحد: new, scheduled, in_progress, completed, cancelled',
        ];
    }
}

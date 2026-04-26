<?php

/**
 * @file: ShiftRequest.php
 * @description: طلب التحقق من بيانات الوردية
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\DispatchAndRouting\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShiftRequest extends FormRequest
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
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'nullable|date_format:Y-m-d H:i:s|after:start_time',
            'break_start_time' => 'nullable|date_format:Y-m-d H:i:s|after:start_time',
            'break_end_time' => 'nullable|date_format:Y-m-d H:i:s|after:break_start_time',
            'status' => 'required|in:planned,active,completed,cancelled',
            'location_start_lat' => 'nullable|numeric|between:-90,90',
            'location_start_lng' => 'nullable|numeric|between:-180,180',
            'notes' => 'nullable|string|max:1000',
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
            'start_time.required' => 'وقت البداية مطلوب',
            'start_time.date_format' => 'وقت البداية يجب أن يكون بصيغة YYYY-MM-DD HH:MM:SS',
            'end_time.date_format' => 'وقت النهاية يجب أن يكون بصيغة YYYY-MM-DD HH:MM:SS',
            'end_time.after' => 'وقت النهاية يجب أن يكون بعد وقت البداية',
            'break_start_time.date_format' => 'وقت بداية الراحة يجب أن يكون بصيغة YYYY-MM-DD HH:MM:SS',
            'break_start_time.after' => 'وقت بداية الراحة يجب أن يكون بعد وقت البداية',
            'break_end_time.date_format' => 'وقت نهاية الراحة يجب أن يكون بصيغة YYYY-MM-DD HH:MM:SS',
            'break_end_time.after' => 'وقت نهاية الراحة يجب أن يكون بعد وقت بداية الراحة',
            'status.required' => 'الحالة مطلوبة',
            'status.in' => 'الحالة يجب أن تكون أحد: planned, active, completed, cancelled',
            'location_start_lat.numeric' => 'خط العرض يجب أن يكون رقماً',
            'location_start_lat.between' => 'خط العرض يجب أن يكون بين -90 و 90',
            'location_start_lng.numeric' => 'خط الطول يجب أن يكون رقماً',
            'location_start_lng.between' => 'خط الطول يجب أن يكون بين -180 و 180',
            'notes.string' => 'الملاحظات يجب أن تكون نصاً',
            'notes.max' => 'الملاحظات لا تزيد عن 1000 حرف',
        ];
    }
}

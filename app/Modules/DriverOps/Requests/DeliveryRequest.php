<?php

/**
 * @file: DeliveryRequest.php
 * @description: طلب التحقق من بيانات التوصيل
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\DriverOps\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|integer|exists:delivery_orders,order_id',
            'driver_id' => 'required|integer|exists:users,user_id',
            'delivery_lat' => 'required|numeric|between:-90,90',
            'delivery_lng' => 'required|numeric|between:-180,180',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'delivery_notes' => 'nullable|string|max:1000',
            'signature_required' => 'required|boolean',
            'pod_photo' => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => 'معرف الطلب مطلوب',
            'order_id.integer' => 'معرف الطلب يجب أن يكون رقماً',
            'order_id.exists' => 'الطلب المحدد غير موجود',
            'driver_id.required' => 'معرف السائق مطلوب',
            'driver_id.integer' => 'معرف السائق يجب أن يكون رقماً',
            'driver_id.exists' => 'السائق المحدد غير موجود',
            'delivery_lat.required' => 'خط العرض مطلوب',
            'delivery_lat.numeric' => 'خط العرض يجب أن يكون رقماً',
            'delivery_lat.between' => 'خط العرض يجب أن يكون بين -90 و 90',
            'delivery_lng.required' => 'خط الطول مطلوب',
            'delivery_lng.numeric' => 'خط الطول يجب أن يكون رقماً',
            'delivery_lng.between' => 'خط الطول يجب أن يكون بين -180 و 180',
            'recipient_name.required' => 'اسم المستلم مطلوب',
            'recipient_name.string' => 'اسم المستلم يجب أن يكون نصاً',
            'recipient_name.max' => 'اسم المستلم لا يزيد عن 255 حرف',
            'recipient_phone.required' => 'هاتف المستلم مطلوب',
            'recipient_phone.string' => 'هاتف المستلم يجب أن يكون نصاً',
            'recipient_phone.max' => 'هاتف المستلم لا يزيد عن 20 حرف',
            'delivery_notes.string' => 'ملاحظات التوصيل يجب أن تكون نصاً',
            'delivery_notes.max' => 'ملاحظات التوصيل لا تزيد عن 1000 حرف',
            'signature_required.required' => 'حقل التوقيع المطلوب غير محدد',
            'signature_required.boolean' => 'حقل التوقيع المطلوب يجب أن يكون قيمة منطقية',
            'pod_photo.file' => 'صورة الإثبات يجب أن تكون ملف',
            'pod_photo.mimes' => 'صورة الإثبات يجب أن تكون بصيغة JPEG أو PNG',
            'pod_photo.max' => 'صورة الإثبات لا تزيد عن 5 ميجابايت',
        ];
    }
}

<?php

/**
 * @file: MaintenanceTrackerRequest.php
 * @description: Form Request لـ Validation في Maintenance Tracker
 * يتولى التحقق من صحة البيانات الواردة
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\MaintenanceTracker\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceTrackerRequest extends FormRequest
{
    /**
     * تحديد ما إذا كان المستخدم مصرح بهذا الـ Request
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * قواعل التحقق
     * @return array
     */
    public function rules(): array
    {
        $maintenanceId = $this->route('id') ?? $this->input('maintenance_id');
        $method = $this->method();

        // قواعل مختلفة للـ Create و Update
        if ($method === 'POST') {
            return $this->createRules();
        } elseif ($method === 'PUT' || $method === 'PATCH') {
            return $this->updateRules();
        }

        return [];
    }

    /**
     * قواعل الإنشاء
     * @return array
     */
    private function createRules(): array
    {
        return [
            'vehicle_id' => [
                'required',
                'integer',
                'exists:vehicles,vehicle_id'
            ],
            'maintenance_type' => [
                'required',
                'string',
                'in:routine,repair,inspection,oil_change,tire_rotation,battery,brake,engine,transmission,electrical,suspension,cooling_system,other'
            ],
            'scheduled_date' => [
                'required',
                'date',
                'after:today'
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'cost' => [
                'nullable',
                'numeric',
                'min:0',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            'technician_id' => [
                'nullable',
                'integer',
                'exists:users,user_id'
            ],
            'created_by' => [
                'required',
                'integer',
                'exists:users,user_id'
            ]
        ];
    }

    /**
     * قواعل التحديث
     * @return array
     */
    private function updateRules(): array
    {
        return [
            'vehicle_id' => [
                'sometimes',
                'integer',
                'exists:vehicles,vehicle_id'
            ],
            'maintenance_type' => [
                'sometimes',
                'string',
                'in:routine,repair,inspection,oil_change,tire_rotation,battery,brake,engine,transmission,electrical,suspension,cooling_system,other'
            ],
            'scheduled_date' => [
                'sometimes',
                'date'
            ],
            'completion_date' => [
                'nullable',
                'date',
                'after:scheduled_date'
            ],
            'status' => [
                'sometimes',
                'string',
                'in:pending,scheduled,in-progress,completed,cancelled'
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'cost' => [
                'nullable',
                'numeric',
                'min:0',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            'technician_id' => [
                'nullable',
                'integer',
                'exists:users,user_id'
            ],
            'parts_replaced' => [
                'nullable',
                'json'
            ],
            'next_maintenance_date' => [
                'nullable',
                'date',
                'after:completion_date'
            ],
            'updated_by' => [
                'required',
                'integer',
                'exists:users,user_id'
            ]
        ];
    }

    /**
     * رسائل الـ Validation المخصصة
     * @return array
     */
    public function messages(): array
    {
        return [
            'vehicle_id.required' => 'معرف المركبة مطلوب',
            'vehicle_id.exists' => 'المركبة المحددة غير موجودة',
            'maintenance_type.required' => 'نوع الصيانة مطلوب',
            'maintenance_type.in' => 'نوع الصيانة غير صحيح',
            'scheduled_date.required' => 'تاريخ الصيانة المجدول مطلوب',
            'scheduled_date.after' => 'يجب أن يكون تاريخ الصيانة بعد اليوم',
            'completion_date.after' => 'تاريخ الإتمام يجب أن يكون بعد تاريخ الجدولة',
            'cost.numeric' => 'التكلفة يجب أن تكون رقمية',
            'cost.min' => 'التكلفة لا يمكن أن تكون سالبة',
            'cost.regex' => 'صيغة التكلفة غير صحيحة (يجب أن تكون رقم عشري)',
            'technician_id.exists' => 'الفني المحدد غير موجود',
            'created_by.required' => 'منشئ السجل مطلوب',
            'created_by.exists' => 'منشئ السجل غير موجود',
            'updated_by.required' => 'معدل السجل مطلوب',
            'updated_by.exists' => 'معدل السجل غير موجود',
            'status.in' => 'الحالة المحددة غير صحيحة',
            'parts_replaced.json' => 'البيانات المدخلة يجب أن تكون JSON صحيح'
        ];
    }

    /**
     * معالجة مسبقة للبيانات
     * @return void
     */
    protected function prepareForValidation()
    {
        // تنظيف البيانات قبل الـ Validation
        if ($this->has('cost')) {
            $this->merge([
                'cost' => $this->input('cost') ? (float) $this->input('cost') : null
            ]);
        }

        // تحويل النصوص إلى lowercase
        if ($this->has('maintenance_type')) {
            $this->merge([
                'maintenance_type' => strtolower($this->input('maintenance_type'))
            ]);
        }

        if ($this->has('status')) {
            $this->merge([
                'status' => strtolower($this->input('status'))
            ]);
        }
    }

    /**
     * معالجة بعد الـ Validation الناجح
     * @return void
     */
    public function passedValidation()
    {
        // يمكنك إضافة معالجات إضافية هنا بعد نجاح الـ Validation
    }
}

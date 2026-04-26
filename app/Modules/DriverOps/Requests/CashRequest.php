<?php

/**
 * @file: CashRequest.php
 * @description: طلب التحقق من بيانات المعاملات النقدية
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\DriverOps\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $action = $this->route()->getName();

        if ($action === 'cash.store') {
            return [
                'delivery_id' => 'required|integer|exists:delivery_records,delivery_id',
                'driver_id' => 'required|integer|exists:users,user_id',
                'amount_collected' => 'required|numeric|min:0.01',
                'amount_description' => 'nullable|string|max:255',
                'payment_method' => 'required|in:cash,card,transfer',
                'proof_image' => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            ];
        }

        if ($action === 'cash.reconcile') {
            return [
                'driver_id' => 'required|integer|exists:users,user_id',
                'reconciliation_date' => 'required|date',
            ];
        }

        if ($action === 'cash.discrepancy') {
            return [
                'transaction_id' => 'required|integer|exists:cash_transactions,transaction_id',
                'discrepancy_amount' => 'required|numeric',
                'discrepancy_reason' => 'required|string|max:1000',
                'evidence_photo' => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            ];
        }

        // payment-request
        return [
            'driver_id' => 'required|integer|exists:users,user_id',
            'payment_amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:bank_transfer,cash,check',
        ];
    }

    public function messages(): array
    {
        return [
            'delivery_id.required' => 'معرف التوصيل مطلوب',
            'delivery_id.integer' => 'معرف التوصيل يجب أن يكون رقماً',
            'delivery_id.exists' => 'التوصيل المحدد غير موجود',
            'driver_id.required' => 'معرف السائق مطلوب',
            'driver_id.integer' => 'معرف السائق يجب أن يكون رقماً',
            'driver_id.exists' => 'السائق المحدد غير موجود',
            'amount_collected.required' => 'المبلغ المجمع مطلوب',
            'amount_collected.numeric' => 'المبلغ المجمع يجب أن يكون رقماً',
            'amount_collected.min' => 'المبلغ المجمع يجب أن يكون موجباً',
            'payment_method.required' => 'طريقة الدفع مطلوبة',
            'payment_method.in' => 'طريقة الدفع يجب أن تكون أحد: cash, card, transfer',
            'proof_image.file' => 'صورة الإثبات يجب أن تكون ملف',
            'proof_image.mimes' => 'صورة الإثبات يجب أن تكون بصيغة JPEG أو PNG',
            'proof_image.max' => 'صورة الإثبات لا تزيد عن 5 ميجابايت',
        ];
    }
}

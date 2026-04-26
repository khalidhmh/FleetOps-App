<?php

/**
 * @file: DeliveryRecord.php
 * @description: نموذج سجل التوصيل - يتتبع تفاصيل كل عملية توصيل
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\DriverOps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DeliveryRecord extends Model
{
    protected $table = 'delivery_records';
    protected $primaryKey = 'delivery_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'driver_id',
        'route_id',
        'delivery_time',
        'delivery_lat',
        'delivery_lng',
        'recipient_name',
        'recipient_phone',
        'signature_required',
        'pod_photo_url',
        'signature_photo_url',
        'delivery_notes',
        'status',
        'rejection_reason',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'delivery_time' => 'datetime',
        'delivery_lat' => 'decimal:8',
        'delivery_lng' => 'decimal:8',
        'signature_required' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * الحصول على التوصيلات الناجحة
     */
    public function scopeSuccessful(Builder $query): Builder
    {
        return $query->where('status', 'delivered');
    }

    /**
     * الحصول على التوصيلات الفاشلة
     */
    public function scopeFailed(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }

    /**
     * الحصول على التوصيلات قيد الانتظار
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * الحصول على توصيلات سائق معين
     */
    public function scopeByDriver(Builder $query, int $driverId): Builder
    {
        return $query->where('driver_id', $driverId);
    }

    /**
     * الحصول على توصيلات تاريخ معين
     */
    public function scopeByDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('delivery_time', $date);
    }
}

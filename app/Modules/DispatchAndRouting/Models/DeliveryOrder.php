<?php

/**
 * @file: DeliveryOrder.php
 * @description: نموذج طلب التوصيل - يمثل طلبات التوصيل الفردية في المسار
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\DispatchAndRouting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class DeliveryOrder extends Model
{
    protected $table = 'delivery_orders';
    protected $primaryKey = 'order_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'route_id',
        'order_number',
        'customer_id',
        'pickup_location',
        'delivery_location',
        'delivery_address_lat',
        'delivery_address_lng',
        'status',
        'delivery_type',
        'estimated_delivery_time',
        'actual_delivery_time',
        'recipient_name',
        'recipient_phone',
        'items_count',
        'special_instructions',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'estimated_delivery_time' => 'datetime',
        'actual_delivery_time' => 'datetime',
        'delivery_address_lat' => 'decimal:8',
        'delivery_address_lng' => 'decimal:8',
        'items_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * العلاقة مع المسار
     */
    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class, 'route_id', 'route_id');
    }

    /**
     * الحصول على الطلبات المعلقة
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * الحصول على الطلبات قيد التوصيل
     */
    public function scopeInTransit(Builder $query): Builder
    {
        return $query->where('status', 'in_transit');
    }

    /**
     * الحصول على الطلبات المسلمة
     */
    public function scopeDelivered(Builder $query): Builder
    {
        return $query->where('status', 'delivered');
    }

    /**
     * الحصول على الطلبات المرفوضة
     */
    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }

    /**
     * الحصول على الطلبات حسب نوع التوصيل
     */
    public function scopeByDeliveryType(Builder $query, string $type): Builder
    {
        return $query->where('delivery_type', $type);
    }

    /**
     * الحصول على الطلبات حسب المسار
     */
    public function scopeByRoute(Builder $query, int $routeId): Builder
    {
        return $query->where('route_id', $routeId);
    }
}

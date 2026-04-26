<?php

/**
 * @file: Route.php
 * @description: نموذج المسار - يمثل مسارات التوصيل المحددة للسائقين
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\DispatchAndRouting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Route extends Model
{
    protected $table = 'routes';
    protected $primaryKey = 'route_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'driver_id',
        'vehicle_id',
        'name',
        'description',
        'start_location',
        'end_location',
        'distance_km',
        'estimated_duration_minutes',
        'actual_duration_minutes',
        'status',
        'scheduled_date',
        'completed_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'distance_km' => 'decimal:2',
        'estimated_duration_minutes' => 'integer',
        'actual_duration_minutes' => 'integer',
    ];

    /**
     * العلاقة مع طلبات التوصيل
     */
    public function deliveryOrders(): HasMany
    {
        return $this->hasMany(DeliveryOrder::class, 'route_id', 'route_id');
    }

    /**
     * الحصول على المسارات الجديدة
     */
    public function scopeNew(Builder $query): Builder
    {
        return $query->where('status', 'new');
    }

    /**
     * الحصول على المسارات المجدولة
     */
    public function scopeScheduled(Builder $query): Builder
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * الحصول على المسارات قيد التنفيذ
     */
    public function scopeInProgress(Builder $query): Builder
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * الحصول على المسارات المكتملة
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    /**
     * الحصول على المسارات الملغاة
     */
    public function scopeCancelled(Builder $query): Builder
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * الحصول على مسارات تاريخ معين
     */
    public function scopeByDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('scheduled_date', $date);
    }

    /**
     * الحصول على مسارات سائق معين
     */
    public function scopeByDriver(Builder $query, int $driverId): Builder
    {
        return $query->where('driver_id', $driverId);
    }
}

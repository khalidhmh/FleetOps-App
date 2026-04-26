<?php

/**
 * @file: Shift.php
 * @description: نموذج الورديات - يمثل ورديات العمل للسائقين
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\DispatchAndRouting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Shift extends Model
{
    protected $table = 'shifts';
    protected $primaryKey = 'shift_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'driver_id',
        'vehicle_id',
        'start_time',
        'end_time',
        'break_start_time',
        'break_end_time',
        'status',
        'location_start_lat',
        'location_start_lng',
        'location_end_lat',
        'location_end_lng',
        'total_distance_km',
        'total_orders',
        'completed_orders',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'break_start_time' => 'datetime',
        'break_end_time' => 'datetime',
        'location_start_lat' => 'decimal:8',
        'location_start_lng' => 'decimal:8',
        'location_end_lat' => 'decimal:8',
        'location_end_lng' => 'decimal:8',
        'total_distance_km' => 'decimal:2',
        'total_orders' => 'integer',
        'completed_orders' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * الحصول على الورديات المخطط لها
     */
    public function scopePlanned(Builder $query): Builder
    {
        return $query->where('status', 'planned');
    }

    /**
     * الحصول على الورديات الجارية
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * الحصول على الورديات المكتملة
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    /**
     * الحصول على الورديات الملغاة
     */
    public function scopeCancelled(Builder $query): Builder
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * الحصول على ورديات سائق معين
     */
    public function scopeByDriver(Builder $query, int $driverId): Builder
    {
        return $query->where('driver_id', $driverId);
    }

    /**
     * الحصول على ورديات تاريخ معين
     */
    public function scopeByDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('start_time', $date);
    }
}

<?php

/**
 * @file: FuelTransaction.php
 * @description: نموذج معاملة الوقود
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\FleetMonitoring\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class FuelTransaction extends Model
{
    protected $table = 'fuel_transactions';
    protected $primaryKey = 'fuel_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'fuel_amount_liters',
        'fuel_cost',
        'odometer_reading',
        'transaction_date',
        'fuel_station_location',
        'receipt_photo_url',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'fuel_amount_liters' => 'decimal:2',
        'fuel_cost' => 'decimal:2',
        'odometer_reading' => 'decimal:2',
        'transaction_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeByVehicle(Builder $query, int $vehicleId): Builder
    {
        return $query->where('vehicle_id', $vehicleId);
    }

    public function scopeByDriver(Builder $query, int $driverId): Builder
    {
        return $query->where('driver_id', $driverId);
    }

    public function scopeByDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('transaction_date', $date);
    }
}

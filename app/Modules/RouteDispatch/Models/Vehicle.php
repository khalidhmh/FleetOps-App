<?php

/**
 * @file: Vehicle.php
 * @description: نموذج Eloquent للمركبات - Route & Dispatch Service
 * @module: RouteDispatch
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\RouteDispatch\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicles';
    protected $primaryKey = 'vehicle_id';
    public $incrementing = true;

    protected $fillable = [
        'plate_number',
        'type',             // light | heavy | refrigerated | motorcycle
        'max_weight_kg',
        'max_volume_m3',
        'odometer_km',
        'status',           // available | in_service | out_of_service | in_repair
        'market_value',
        'fuel_type',        // petrol | diesel | electric
        'year',
        'color',
        'required_license_type',  // light | heavy
        'notes',
    ];

    protected $casts = [
        'max_weight_kg' => 'float',
        'max_volume_m3' => 'float',
        'odometer_km'   => 'float',
        'market_value'  => 'float',
        'year'          => 'integer',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'deleted_at'    => 'datetime',
    ];

    protected $attributes = [
        'status' => 'available',
    ];

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function routes()
    {
        return $this->hasMany(Route::class, 'vehicle_id', 'vehicle_id');
    }
}

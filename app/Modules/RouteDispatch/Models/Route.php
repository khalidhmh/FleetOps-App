<?php

/**
 * @file: Route.php
 * @description: نموذج Eloquent للمسارات - Route & Dispatch Service
 * @module: RouteDispatch
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\RouteDispatch\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'routes';
    protected $primaryKey = 'route_id';
    public $incrementing = true;

    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'status',       // planned | active | completed | cancelled
        'shift',        // morning | evening | night
        'total_distance_km',
        'total_stops',
        'estimated_duration_min',
        'version',
        'started_at',
        'completed_at',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'total_distance_km'      => 'float',
        'total_stops'            => 'integer',
        'estimated_duration_min' => 'integer',
        'version'                => 'integer',
        'started_at'             => 'datetime',
        'completed_at'           => 'datetime',
        'created_at'             => 'datetime',
        'updated_at'             => 'datetime',
        'deleted_at'             => 'datetime',
    ];

    protected $attributes = [
        'status'  => 'planned',
        'version' => 1,
    ];

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopePlanned($query)  { return $query->where('status', 'planned'); }
    public function scopeActive($query)   { return $query->where('status', 'active'); }
    public function scopeCompleted($query){ return $query->where('status', 'completed'); }

    public function scopeForDriver($query, int $driverId)
    {
        return $query->where('driver_id', $driverId);
    }

    public function scopeForVehicle($query, int $vehicleId)
    {
        return $query->where('vehicle_id', $vehicleId);
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function stops()
    {
        return $this->hasMany(RouteStop::class, 'route_id', 'route_id')->orderBy('sequence');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'vehicle_id');
    }
}

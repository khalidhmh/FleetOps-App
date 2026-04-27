<?php

/**
 * @file: RouteStop.php
 * @description: نموذج Eloquent لمحطات المسار - Route & Dispatch Service
 * @module: RouteDispatch
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\RouteDispatch\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RouteStop extends Model
{
    use HasFactory;

    protected $table = 'route_stops';
    protected $primaryKey = 'stop_id';
    public $incrementing = true;

    protected $fillable = [
        'route_id',
        'order_id',
        'sequence',
        'eta',
        'actual_arrival',
        'departure_at',
        'status',           // pending | arrived | completed | skipped
        'stop_duration_min',
        'distance_from_prev_km',
        'notes',
    ];

    protected $casts = [
        'sequence'              => 'integer',
        'stop_duration_min'     => 'integer',
        'distance_from_prev_km' => 'float',
        'eta'                   => 'datetime',
        'actual_arrival'        => 'datetime',
        'departure_at'          => 'datetime',
        'created_at'            => 'datetime',
        'updated_at'            => 'datetime',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id', 'route_id');
    }
}

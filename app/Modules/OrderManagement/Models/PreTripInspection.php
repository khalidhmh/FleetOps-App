<?php

/**
 * @file: PreTripInspection.php
 * @description: نموذج Eloquent للفحص ما قبل الرحلة - Order Management Service (fn12)
 * @module: OrderManagement
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\OrderManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreTripInspection extends Model
{
    use HasFactory;

    protected $table = 'pre_trip_inspections';
    protected $primaryKey = 'inspection_id';
    public $incrementing = true;

    protected $fillable = [
        'driver_id',
        'vehicle_id',
        'route_id',
        'tires_ok',
        'brakes_ok',
        'lights_ok',
        'fuel_level',   // full | 3/4 | 1/2 | 1/4 | empty
        'documents_ok',
        'cleanliness_ok',
        'engine_ok',
        'notes',
        'inspected_at',
        'passed',       // calculated: all checks passed
    ];

    protected $casts = [
        'tires_ok'       => 'boolean',
        'brakes_ok'      => 'boolean',
        'lights_ok'      => 'boolean',
        'documents_ok'   => 'boolean',
        'cleanliness_ok' => 'boolean',
        'engine_ok'      => 'boolean',
        'passed'         => 'boolean',
        'inspected_at'   => 'datetime',
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
    ];

    public function hasPassed(): bool
    {
        return $this->tires_ok
            && $this->brakes_ok
            && $this->lights_ok
            && $this->documents_ok
            && $this->engine_ok;
    }
}

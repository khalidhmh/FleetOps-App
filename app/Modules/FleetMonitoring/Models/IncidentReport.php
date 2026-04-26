<?php

/**
 * @file: IncidentReport.php
 * @description: نموذج تقرير الحادثة
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\FleetMonitoring\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class IncidentReport extends Model
{
    protected $table = 'incident_reports';
    protected $primaryKey = 'incident_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'incident_type',
        'incident_date',
        'incident_location',
        'incident_location_lat',
        'incident_location_lng',
        'description',
        'severity_level',
        'status',
        'evidence_photo_url',
        'investigation_notes',
        'resolution_date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'incident_date' => 'datetime',
        'incident_location_lat' => 'decimal:8',
        'incident_location_lng' => 'decimal:8',
        'resolution_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeByVehicle(Builder $query, int $vehicleId): Builder
    {
        return $query->where('vehicle_id', $vehicleId);
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', 'open');
    }

    public function scopeCritical(Builder $query): Builder
    {
        return $query->where('severity_level', 'critical');
    }
}

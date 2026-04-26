<?php

/**
 * @file: Order.php
 * @description: نموذج Eloquent للطلبات - Order Management Service
 * @module: OrderManagement
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\OrderManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $incrementing = true;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'delivery_address',
        'lat',
        'lng',
        'weight_kg',
        'volume_m3',
        'payment_type',     // prepaid | COD
        'cod_amount',
        'status',           // pending | in_transit | delivered | returned | failed
        'failure_reason',
        'failure_reason_code',
        'priority',         // normal | express
        'promised_window_start',
        'promised_window_end',
        'delivery_preference',
        'qr_code',
        'route_id',
        'driver_id',
        'import_batch_id',
        'retry_count',
        'notes',
    ];

    protected $casts = [
        'lat'                    => 'float',
        'lng'                    => 'float',
        'weight_kg'              => 'float',
        'volume_m3'              => 'float',
        'cod_amount'             => 'float',
        'retry_count'            => 'integer',
        'promised_window_start'  => 'datetime',
        'promised_window_end'    => 'datetime',
        'created_at'             => 'datetime',
        'updated_at'             => 'datetime',
        'deleted_at'             => 'datetime',
    ];

    // Valid status transitions (State Machine)
    // pending → in_transit → delivered
    //                      → returned
    //                      → failed

    protected $attributes = [
        'status'      => 'pending',
        'priority'    => 'normal',
        'retry_count' => 0,
    ];

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopePending($query)    { return $query->where('status', 'pending'); }
    public function scopeInTransit($query)  { return $query->where('status', 'in_transit'); }
    public function scopeDelivered($query)  { return $query->where('status', 'delivered'); }
    public function scopeExpress($query)    { return $query->where('priority', 'express'); }
    public function scopeForRoute($query, int $routeId) { return $query->where('route_id', $routeId); }
    public function scopeForDriver($query, int $driverId) { return $query->where('driver_id', $driverId); }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public function isCOD(): bool { return $this->payment_type === 'COD'; }
    public function isExpress(): bool { return $this->priority === 'express'; }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function proofOfDelivery()
    {
        return $this->hasOne(ProofOfDelivery::class, 'order_id', 'order_id');
    }
}

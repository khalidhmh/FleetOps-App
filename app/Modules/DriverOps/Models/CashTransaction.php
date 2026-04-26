<?php

/**
 * @file: CashTransaction.php
 * @description: نموذج معاملة نقدية - يتتبع العمليات النقدية (COD)
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\DriverOps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CashTransaction extends Model
{
    protected $table = 'cash_transactions';
    protected $primaryKey = 'transaction_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'delivery_id',
        'order_id',
        'driver_id',
        'amount_collected',
        'amount_description',
        'payment_method',
        'transaction_status',
        'reconciliation_status',
        'reconciliation_notes',
        'proof_image_url',
        'collected_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'amount_collected' => 'decimal:2',
        'collected_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * الحصول على المعاملات المجمعة
     */
    public function scopeCollected(Builder $query): Builder
    {
        return $query->where('transaction_status', 'collected');
    }

    /**
     * الحصول على المعاملات المعلقة
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('transaction_status', 'pending');
    }

    /**
     * الحصول على المعاملات المصالحة
     */
    public function scopeReconciled(Builder $query): Builder
    {
        return $query->where('reconciliation_status', 'reconciled');
    }

    /**
     * الحصول على المعاملات غير المصالحة
     */
    public function scopeUnreconciled(Builder $query): Builder
    {
        return $query->where('reconciliation_status', 'unreconciled');
    }

    /**
     * الحصول على معاملات سائق معين
     */
    public function scopeByDriver(Builder $query, int $driverId): Builder
    {
        return $query->where('driver_id', $driverId);
    }

    /**
     * الحصول على معاملات تاريخ معين
     */
    public function scopeByDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('collected_at', $date);
    }
}

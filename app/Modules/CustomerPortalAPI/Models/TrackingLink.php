<?php

/**
 * @file: TrackingLink.php
 * @description: نموذج رابط التتبع
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\CustomerPortalAPI\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TrackingLink extends Model
{
    protected $table = 'tracking_links';
    protected $primaryKey = 'link_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'tracking_token',
        'customer_email',
        'customer_phone',
        'expiry_date',
        'view_count',
        'last_viewed_at',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'last_viewed_at' => 'datetime',
        'view_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active')->where('expiry_date', '>', now());
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('expiry_date', '<', now());
    }
}

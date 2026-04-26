<?php

/**
 * @file: CustomerFeedback.php
 * @description: نموذج ملاحظات العميل
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\CustomerPortalAPI\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CustomerFeedback extends Model
{
    protected $table = 'customer_feedback';
    protected $primaryKey = 'feedback_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'customer_id',
        'rating',
        'comment',
        'delivery_experience',
        'driver_rating',
        'packaging_rating',
        'feedback_type',
        'status',
        'response',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'rating' => 'integer',
        'driver_rating' => 'integer',
        'packaging_rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopePositive(Builder $query): Builder
    {
        return $query->where('rating', '>=', 4);
    }

    public function scopeNegative(Builder $query): Builder
    {
        return $query->where('rating', '<', 3);
    }

    public function scopeUnanswered(Builder $query): Builder
    {
        return $query->whereNull('response');
    }
}

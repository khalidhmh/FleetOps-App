<?php

/**
 * @file: NotificationLog.php
 * @description: نموذج سجل الإخطارات
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\NotificationEngine\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class NotificationLog extends Model
{
    protected $table = 'notification_logs';
    protected $primaryKey = 'notification_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'recipient_id',
        'recipient_email',
        'recipient_phone',
        'notification_type',
        'notification_channel',
        'subject',
        'message',
        'status',
        'sent_at',
        'failed_reason',
        'retry_count',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'retry_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeDelivered(Builder $query): Builder
    {
        return $query->where('status', 'delivered');
    }

    public function scopeFailed(Builder $query): Builder
    {
        return $query->where('status', 'failed');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }
}

<?php

/**
 * @file: MaintenanceTrackerModel.php
 * @description: نموذج Eloquent لـ Maintenance Tracker
 * يمثل جدول الصيانة والفحوصات الدورية للمركبات
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\MaintenanceTracker\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenanceTrackerModel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * اسم الجدول المرتبط
     * @var string
     */
    protected $table = 'maintenance_trackers';




         protected $guarded = [];

    /**
     * المفتاح الأساسي
     * @var string
     */
    protected $primaryKey = 'maintenance_id';

    /**
     * نوع المفتاح الأساسي
     * @var string
     */
    protected $keyType = 'int';

    /**
     * هل يتم استخدام الزيادة التلقائية
     * @var bool
     */
    public $incrementing = true;

    /**
     * الحقول القابلة للتعديل بشكل جماعي
     * @var array
     */
    protected $fillable = [
        'vehicle_id',
        'maintenance_type',
        'scheduled_date',
        'completion_date',
        'status',
        'cost',
        'description',
        'technician_id',
        'parts_replaced',
        'next_maintenance_date',
        'created_by',
        'updated_by'
    ];

    /**
     * الحقول المخفية
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];

    /**
     * التحويل التلقائي للبيانات
     * @var array
     */
    protected $casts = [
        'scheduled_date' => 'datetime',
        'completion_date' => 'datetime',
        'next_maintenance_date' => 'datetime',
        'cost' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'parts_replaced' => 'json'
    ];

    /**
     * القيم الافتراضية
     * @var array
     */
    protected $attributes = [
        'status' => 'pending'
    ];

    /**
     * نطاقات الاستعلام
     */
    
    /**
     * جميع الصيانات المعلقة
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * جميع الصيانات المكتملة
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * الصيانات المجدولة
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * الصيانات المتأخرة
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'pending')
            ->where('scheduled_date', '<', now());
    }

    /**
     * الصيانات خلال فترة زمنية معينة
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('scheduled_date', [$startDate, $endDate]);
    }

    /**
     * العلاقات
     */

    /**
     * العلاقة مع المركبة
     * ملاحظة: هذا مثال، يجب أن يكون لديك جدول vehicles
     */
    public function vehicle()
    {
        return $this->belongsTo('App\Modules\FleetMonitoring\Models\VehicleModel', 'vehicle_id', 'vehicle_id');
    }

    /**
     * العلاقة مع الفني المسؤول
     */
    public function technician()
    {
        return $this->belongsTo('App\Modules\IAM\Models\UserModel', 'technician_id', 'user_id');
    }

    /**
     * الشخص الذي أنشأ السجل
     */
    public function creator()
    {
        return $this->belongsTo('App\Modules\IAM\Models\UserModel', 'created_by', 'user_id');
    }

    /**
     * الشخص الذي عدّل السجل آخر مرة
     */
    public function updater()
    {
        return $this->belongsTo('App\Modules\IAM\Models\UserModel', 'updated_by', 'user_id');
    }
}


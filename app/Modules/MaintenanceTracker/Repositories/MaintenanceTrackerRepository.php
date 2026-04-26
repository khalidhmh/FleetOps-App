<?php

/**
 * @file: MaintenanceTrackerRepository.php
 * @description: Repository الخاص بـ Maintenance Tracker
 * يتولى جميع عمليات الوصول للبيانات
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\MaintenanceTracker\Repositories;

use App\Modules\Shared\Repositories\BaseRepository;
use App\Modules\MaintenanceTracker\Models\MaintenanceTrackerModel;
use Illuminate\Database\Eloquent\Collection;

class MaintenanceTrackerRepository extends BaseRepository
{
    /**
     * MaintenanceTrackerRepository constructor.
     * @param MaintenanceTrackerModel $model
     */
    public function __construct(MaintenanceTrackerModel $model)
    {
        parent::__construct($model);
    }

    /**
     * الحصول على جميع الصيانات لمركبة معينة
     * @param int $vehicleId
     * @return Collection
     */
    public function getByVehicleId(int $vehicleId): Collection
    {
        return $this->model
            ->where('vehicle_id', $vehicleId)
            ->orderBy('scheduled_date', 'desc')
            ->get();
    }

    /**
     * الحصول على الصيانات المعلقة لمركبة معينة
     * @param int $vehicleId
     * @return Collection
     */
    public function getPendingByVehicleId(int $vehicleId): Collection
    {
        return $this->model
            ->where('vehicle_id', $vehicleId)
            ->pending()
            ->orderBy('scheduled_date', 'asc')
            ->get();
    }

    /**
     * الحصول على الصيانات المتأخرة
     * @return Collection
     */
    public function getOverdue(): Collection
    {
        return $this->model
            ->overdue()
            ->orderBy('scheduled_date', 'asc')
            ->with('vehicle', 'technician')
            ->get();
    }

    /**
     * الحصول على الصيانات المجدولة بعد تاريخ معين
     * @param \DateTime|string $date
     * @return Collection
     */
    public function getUpcoming($date = null): Collection
    {
        $date = $date ?? now();
        
        return $this->model
            ->where('status', '!=', 'completed')
            ->where('scheduled_date', '>=', $date)
            ->orderBy('scheduled_date', 'asc')
            ->with('vehicle', 'technician')
            ->get();
    }

    /**
     * الحصول على الصيانات خلال فترة زمنية معينة
     * @param string $startDate
     * @param string $endDate
     * @return Collection
     */
    public function getInDateRange(string $startDate, string $endDate): Collection
    {
        return $this->model
            ->inDateRange($startDate, $endDate)
            ->with('vehicle', 'technician')
            ->get();
    }

    /**
     * الحصول على الصيانات حسب الحالة
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection
    {
        return $this->model
            ->where('status', $status)
            ->orderBy('scheduled_date', 'desc')
            ->get();
    }

    /**
     * الحصول على الصيانات حسب نوعها
     * @param string $maintenanceType
     * @return Collection
     */
    public function getByType(string $maintenanceType): Collection
    {
        return $this->model
            ->where('maintenance_type', $maintenanceType)
            ->orderBy('scheduled_date', 'desc')
            ->get();
    }

    /**
     * الحصول على الصيانات للفني معين
     * @param int $technicianId
     * @return Collection
     */
    public function getByTechnician(int $technicianId): Collection
    {
        return $this->model
            ->where('technician_id', $technicianId)
            ->orderBy('scheduled_date', 'desc')
            ->get();
    }

    /**
     * إحصائيات الصيانة
     * @return array
     */
    public function getStatistics(): array
    {
        return [
            'total' => $this->model->count(),
            'pending' => $this->model->where('status', 'pending')->count(),
            'completed' => $this->model->where('status', 'completed')->count(),
            'scheduled' => $this->model->where('status', 'scheduled')->count(),
            'overdue' => $this->model->overdue()->count(),
            'total_cost' => $this->model->where('status', 'completed')->sum('cost') ?? 0,
        ];
    }

    /**
     * الحصول على متوسط تكلفة الصيانة حسب نوعها
     * @param string $maintenanceType
     * @return float
     */
    public function getAverageCostByType(string $maintenanceType): float
    {
        return $this->model
            ->where('maintenance_type', $maintenanceType)
            ->where('status', 'completed')
            ->avg('cost') ?? 0;
    }

    /**
     * البحث المتقدم في الصيانات
     * @param array $filters
     * @return Collection
     */
    public function advancedSearch(array $filters): Collection
    {
        $query = $this->model;

        if (isset($filters['vehicle_id'])) {
            $query = $query->where('vehicle_id', $filters['vehicle_id']);
        }

        if (isset($filters['status'])) {
            $query = $query->where('status', $filters['status']);
        }

        if (isset($filters['maintenance_type'])) {
            $query = $query->where('maintenance_type', $filters['maintenance_type']);
        }

        if (isset($filters['technician_id'])) {
            $query = $query->where('technician_id', $filters['technician_id']);
        }

        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query = $query->whereBetween('scheduled_date', [
                $filters['start_date'],
                $filters['end_date']
            ]);
        }

        if (isset($filters['min_cost']) && isset($filters['max_cost'])) {
            $query = $query->whereBetween('cost', [
                $filters['min_cost'],
                $filters['max_cost']
            ]);
        }

        return $query->with('vehicle', 'technician')->get();
    }

    /**
     * تحديث حالة الصيانة
     * @param int $maintenanceId
     * @param string $status
     * @param array $additionalData
     * @return bool
     */
    public function updateStatus(int $maintenanceId, string $status, array $additionalData = []): bool
    {
        $data = array_merge(['status' => $status], $additionalData);
        
        if ($status === 'completed') {
            $data['completion_date'] = now();
        }

        return $this->update($maintenanceId, $data);
    }
}

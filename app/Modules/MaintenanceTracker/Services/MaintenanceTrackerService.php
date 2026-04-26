<?php

/**
 * @file: MaintenanceTrackerService.php
 * @description: Service Layer الخاص بـ Maintenance Tracker
 * يحتوي على كل Business Logic الخاصة بالصيانة
 * يتصل مع Repository للوصول للبيانات
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\MaintenanceTracker\Services;

use App\Modules\MaintenanceTracker\Repositories\MaintenanceTrackerRepository;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class MaintenanceTrackerService
{
    /**
     * @var MaintenanceTrackerRepository
     */
    private $repository;

    /**
     * MaintenanceTrackerService constructor.
     * @param MaintenanceTrackerRepository $repository
     */
    public function __construct(MaintenanceTrackerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * الحصول على جميع الصيانات مع Pagination
     * @param int $perPage
     * @return \Illuminate\Pagination\Paginator
     */
    public function getAllMaintenances(int $perPage = 15)
    {
        return $this->repository->paginate($perPage);
    }

    /**
     * الحصول على صيانة معينة مع العلاقات
     * @param int $maintenanceId
     * @return object
     * @throws Exception
     */
    public function getMaintenanceById(int $maintenanceId)
    {
        $maintenance = $this->repository
            ->with(['vehicle', 'technician', 'creator', 'updater'])
            ->findByIdOrFail($maintenanceId);

        return $maintenance;
    }

    /**
     * إنشاء صيانة جديدة
     * @param array $data
     * @return object
     * @throws Exception
     */
    public function createMaintenance(array $data)
    {
        try {
            // التحقق من أن المركبة موجودة (يمكنك إضافة فحصوصات إضافية هنا)
            if (empty($data['vehicle_id'])) {
                throw new Exception('معرف المركبة مطلوب');
            }

            // إنشاء السجل
            $maintenance = $this->repository->create($data);

            return $maintenance;
        } catch (Exception $e) {
            throw new Exception('خطأ عند إنشاء الصيانة: ' . $e->getMessage());
        }
    }

    /**
     * تحديث صيانة معينة
     * @param int $maintenanceId
     * @param array $data
     * @return object
     * @throws Exception
     */
    public function updateMaintenance(int $maintenanceId, array $data)
    {
        try {
            // التحقق من وجود الصيانة
            $maintenance = $this->repository->findByIdOrFail($maintenanceId);

            // تحديث البيانات
            $this->repository->update($maintenanceId, $data);

            return $this->repository->findById($maintenanceId);
        } catch (Exception $e) {
            throw new Exception('خطأ عند تحديث الصيانة: ' . $e->getMessage());
        }
    }

    /**
     * تحديث حالة الصيانة
     * @param int $maintenanceId
     * @param string $status
     * @param array $additionalData
     * @return object
     * @throws Exception
     */
    public function updateMaintenanceStatus(int $maintenanceId, string $status, array $additionalData = [])
    {
        try {
            $validStatuses = ['pending', 'scheduled', 'in-progress', 'completed', 'cancelled'];

            if (!in_array($status, $validStatuses)) {
                throw new Exception('الحالة غير صحيحة. الحالات المسموحة: ' . implode(', ', $validStatuses));
            }

            // تحديث الحالة
            $this->repository->updateStatus($maintenanceId, $status, $additionalData);

            return $this->repository->findById($maintenanceId);
        } catch (Exception $e) {
            throw new Exception('خطأ عند تحديث حالة الصيانة: ' . $e->getMessage());
        }
    }

    /**
     * حذف صيانة معينة (Soft Delete)
     * @param int $maintenanceId
     * @return bool
     * @throws Exception
     */
    public function deleteMaintenance(int $maintenanceId): bool
    {
        try {
            return $this->repository->delete($maintenanceId);
        } catch (Exception $e) {
            throw new Exception('خطأ عند حذف الصيانة: ' . $e->getMessage());
        }
    }

    /**
     * الحصول على صيانات مركبة معينة
     * @param int $vehicleId
     * @return Collection
     */
    public function getMaintenancesByVehicle(int $vehicleId): Collection
    {
        return $this->repository->getByVehicleId($vehicleId);
    }

    /**
     * الحصول على الصيانات المعلقة لمركبة معينة
     * @param int $vehicleId
     * @return Collection
     */
    public function getPendingMaintenanceByVehicle(int $vehicleId): Collection
    {
        return $this->repository->getPendingByVehicleId($vehicleId);
    }

    /**
     * الحصول على الصيانات المتأخرة
     * @return Collection
     */
    public function getOverdueMaintenances(): Collection
    {
        return $this->repository->getOverdue();
    }

    /**
     * الحصول على الصيانات القادمة
     * @param string|null $date
     * @return Collection
     */
    public function getUpcomingMaintenances($date = null): Collection
    {
        return $this->repository->getUpcoming($date);
    }

    /**
     * الحصول على الصيانات خلال فترة زمنية
     * @param string $startDate
     * @param string $endDate
     * @return Collection
     */
    public function getMaintenancesInDateRange(string $startDate, string $endDate): Collection
    {
        return $this->repository->getInDateRange($startDate, $endDate);
    }

    /**
     * البحث المتقدم
     * @param array $filters
     * @return Collection
     */
    public function searchMaintenances(array $filters): Collection
    {
        return $this->repository->advancedSearch($filters);
    }

    /**
     * الحصول على الإحصائيات
     * @return array
     */
    public function getStatistics(): array
    {
        return $this->repository->getStatistics();
    }

    /**
     * الحصول على متوسط التكلفة حسب النوع
     * @param string $maintenanceType
     * @return float
     */
    public function getAverageCostByType(string $maintenanceType): float
    {
        return $this->repository->getAverageCostByType($maintenanceType);
    }

    /**
     * تحديد الصيانات التالية للمركبة
     * @param int $vehicleId
     * @param string $maintenanceType
     * @param \DateTime|string $nextDate
     * @return object
     * @throws Exception
     */
    public function scheduleNextMaintenance(int $vehicleId, string $maintenanceType, $nextDate)
    {
        try {
            $data = [
                'vehicle_id' => $vehicleId,
                'maintenance_type' => $maintenanceType,
                'scheduled_date' => $nextDate,
                'status' => 'scheduled'
            ];

            return $this->createMaintenance($data);
        } catch (Exception $e) {
            throw new Exception('خطأ عند جدولة الصيانة التالية: ' . $e->getMessage());
        }
    }

    /**
     * تسجيل أداء الصيانة
     * @param int $maintenanceId
     * @param array $data
     * @return object
     * @throws Exception
     */
    public function completeMaintenance(int $maintenanceId, array $data)
    {
        try {
            // التحقق من البيانات المطلوبة
            if (empty($data['completion_date'])) {
                $data['completion_date'] = now();
            }

            $data['status'] = 'completed';

            return $this->updateMaintenance($maintenanceId, $data);
        } catch (Exception $e) {
            throw new Exception('خطأ عند إتمام الصيانة: ' . $e->getMessage());
        }
    }
}

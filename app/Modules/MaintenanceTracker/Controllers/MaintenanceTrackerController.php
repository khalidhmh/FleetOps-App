<?php

/**
 * @file: MaintenanceTrackerController.php
 * @description: Controller الخاص بـ Maintenance Tracker - Thin Controller
 * مسؤوليته فقط استقبال الـ Requests وتفويض العمل للـ Service
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\MaintenanceTracker\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\MaintenanceTracker\Services\MaintenanceTrackerService;
use App\Modules\MaintenanceTracker\Requests\MaintenanceTrackerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MaintenanceTrackerController extends Controller
{
    /**
     * @var MaintenanceTrackerService
     */
    private $service;

    /**
     * MaintenanceTrackerController constructor.
     * @param MaintenanceTrackerService $service
     */
    public function __construct(MaintenanceTrackerService $service)
    {
        $this->service = $service;
    }

    /**
     * عرض قائمة جميع الصيانات
     * GET /maintenance
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', 15);
            $maintenances = $this->service->getAllMaintenances($perPage);

            return response()->json([
                'success' => true,
                'message' => 'تم استرجاع قائمة الصيانات بنجاح',
                'data' => $maintenances
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * عرض صيانة محددة
     * GET /maintenance/{id}
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $maintenance = $this->service->getMaintenanceById($id);

            return response()->json([
                'success' => true,
                'message' => 'تم استرجاع الصيانة بنجاح',
                'data' => $maintenance
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * إنشاء صيانة جديدة
     * POST /maintenance
     * @param MaintenanceTrackerRequest $request
     * @return JsonResponse
     */
    public function store(MaintenanceTrackerRequest $request): JsonResponse
    {
        try {
            $maintenance = $this->service->createMaintenance($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء الصيانة بنجاح',
                'data' => $maintenance
            ], 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    /**
     * تحديث صيانة معينة
     * PUT/PATCH /maintenance/{id}
     * @param int $id
     * @param MaintenanceTrackerRequest $request
     * @return JsonResponse
     */
    public function update(int $id, MaintenanceTrackerRequest $request): JsonResponse
    {
        try {
            $maintenance = $this->service->updateMaintenance($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الصيانة بنجاح',
                'data' => $maintenance
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    /**
     * حذف صيانة معينة
     * DELETE /maintenance/{id}
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->deleteMaintenance($id);

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الصيانة بنجاح'
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    /**
     * الحصول على صيانات مركبة محددة
     * GET /maintenance/vehicle/{vehicleId}
     * @param int $vehicleId
     * @return JsonResponse
     */
    public function getByVehicle(int $vehicleId): JsonResponse
    {
        try {
            $maintenances = $this->service->getMaintenancesByVehicle($vehicleId);

            return response()->json([
                'success' => true,
                'message' => 'تم استرجاع صيانات المركبة بنجاح',
                'data' => $maintenances
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * الحصول على الصيانات المعلقة لمركبة محددة
     * GET /maintenance/vehicle/{vehicleId}/pending
     * @param int $vehicleId
     * @return JsonResponse
     */
    public function getPendingByVehicle(int $vehicleId): JsonResponse
    {
        try {
            $maintenances = $this->service->getPendingMaintenanceByVehicle($vehicleId);

            return response()->json([
                'success' => true,
                'message' => 'تم استرجاع الصيانات المعلقة بنجاح',
                'data' => $maintenances
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * الحصول على الصيانات المتأخرة
     * GET /maintenance/overdue
     * @return JsonResponse
     */
    public function getOverdue(): JsonResponse
    {
        try {
            $maintenances = $this->service->getOverdueMaintenances();

            return response()->json([
                'success' => true,
                'message' => 'تم استرجاع الصيانات المتأخرة بنجاح',
                'count' => count($maintenances),
                'data' => $maintenances
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * الحصول على الصيانات القادمة
     * GET /maintenance/upcoming
     * @param Request $request
     * @return JsonResponse
     */
    public function getUpcoming(Request $request): JsonResponse
    {
        try {
            $date = $request->query('date');
            $maintenances = $this->service->getUpcomingMaintenances($date);

            return response()->json([
                'success' => true,
                'message' => 'تم استرجاع الصيانات القادمة بنجاح',
                'data' => $maintenances
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * البحث المتقدم في الصيانات
     * POST /maintenance/search
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $filters = $request->all();
            $maintenances = $this->service->searchMaintenances($filters);

            return response()->json([
                'success' => true,
                'message' => 'تم البحث بنجاح',
                'count' => count($maintenances),
                'data' => $maintenances
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * تحديث حالة الصيانة
     * PATCH /maintenance/{id}/status
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateStatus(int $id, Request $request): JsonResponse
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,scheduled,in-progress,completed,cancelled'
            ]);

            $maintenance = $this->service->updateMaintenanceStatus(
                $id,
                $request->input('status'),
                $request->except('status')
            );

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث حالة الصيانة بنجاح',
                'data' => $maintenance
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    /**
     * الحصول على الإحصائيات
     * GET /maintenance/stats
     * @return JsonResponse
     */
    public function getStatistics(): JsonResponse
    {
        try {
            $stats = $this->service->getStatistics();

            return response()->json([
                'success' => true,
                'message' => 'تم استرجاع الإحصائيات بنجاح',
                'data' => $stats
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * جدولة الصيانة التالية
     * POST /maintenance/{id}/schedule-next
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function scheduleNext(int $id, Request $request): JsonResponse
    {
        try {
            $request->validate([
                'maintenance_type' => 'required|string',
                'next_date' => 'required|date'
            ]);

            $maintenance = $this->service->scheduleNextMaintenance(
                $id,
                $request->input('maintenance_type'),
                $request->input('next_date')
            );

            return response()->json([
                'success' => true,
                'message' => 'تم جدولة الصيانة التالية بنجاح',
                'data' => $maintenance
            ], 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    /**
     * تسجيل أداء الصيانة
     * POST /maintenance/{id}/complete
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function complete(int $id, Request $request): JsonResponse
    {
        try {
            $request->validate([
                'cost' => 'nullable|numeric|min:0',
                'parts_replaced' => 'nullable|json',
                'description' => 'nullable|string'
            ]);

            $maintenance = $this->service->completeMaintenance($id, $request->all());

            return response()->json([
                'success' => true,
                'message' => 'تم إتمام الصيانة بنجاح',
                'data' => $maintenance
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    /**
     * مساعد لإرجاع استجابة خطأ
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    private function errorResponse(string $message, int $statusCode): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $statusCode);
    }
}

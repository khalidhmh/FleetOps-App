<?php

/**
 * @file: RoleController.php
 * @description: متحكم الأدوار - يدير عمليات CRUD للأدوار
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\IAM\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\IAM\Repositories\RoleRepository;
use App\Modules\IAM\Requests\RoleRequest;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    protected RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * الحصول على جميع الأدوار
     * GET /api/v1/roles
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // TODO: Implement get all roles
        // 1. Call roleRepository->getAll()
        // 2. Include permissions relationship
        // 3. Return roles as JSON
        // 4. Handle exceptions
    }

    /**
     * الحصول على دور معين
     * GET /api/v1/roles/{id}
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        // TODO: Implement get single role
        // 1. Call roleRepository->findById()
        // 2. Include permissions relationship
        // 3. Return role as JSON
        // 4. Return 404 if not found
    }

    /**
     * إنشاء دور جديد
     * POST /api/v1/roles
     * @param RoleRequest $request
     * @return JsonResponse
     */
    public function store(RoleRequest $request): JsonResponse
    {
        // TODO: Implement create role
        // 1. Get validated data from request
        // 2. Call roleRepository->create()
        // 3. Return created role with status 201
        // 4. Handle exceptions
    }

    /**
     * تحديث دور
     * PUT /api/v1/roles/{id}
     * @param int $id
     * @param RoleRequest $request
     * @return JsonResponse
     */
    public function update(int $id, RoleRequest $request): JsonResponse
    {
        // TODO: Implement update role
        // 1. Get validated data from request
        // 2. Call roleRepository->update()
        // 3. Return updated role as JSON
        // 4. Return 404 if not found
        // 5. Handle exceptions
    }

    /**
     * حذف دور
     * DELETE /api/v1/roles/{id}
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        // TODO: Implement delete role
        // 1. Check if role is system role (cannot delete)
        // 2. Call roleRepository->delete()
        // 3. Return success response
        // 4. Return 404 if not found
        // 5. Handle exceptions
    }

    /**
     * الحصول على الأدوار غير النظامية
     * GET /api/v1/roles/non-system
     * @return JsonResponse
     */
    public function nonSystemRoles(): JsonResponse
    {
        // TODO: Implement get non-system roles
        // 1. Call roleRepository->getNonSystemRoles()
        // 2. Return roles as JSON
        // 3. Handle exceptions
    }
}

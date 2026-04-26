<?php

/**
 * @file: UserService.php
 * @description: خدمة إدارة المستخدمين - CRUD والتصفية حسب الدور
 * @module: AuthIdentity
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\AuthIdentity\Services;

use App\Modules\AuthIdentity\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * جلب جميع المستخدمين مع Pagination
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllUsers(int $perPage = 15)
    {
        // TODO: Return paginated users
        // return $this->userRepository->paginate($perPage);
    }

    /**
     * جلب مستخدم واحد مع علاقاته
     * @param int $id
     * @return \App\Modules\AuthIdentity\Models\User
     * @throws Exception
     */
    public function getUserById(int $id)
    {
        // TODO: Return user with roles and permissions
        // $user = $this->userRepository->findByIdOrFail($id);
        // $user->load(['roles', 'permissions']);
        // return $user;
    }

    /**
     * إنشاء مستخدم جديد
     * @param array $data  (validated from UserRequest)
     * @return \App\Modules\AuthIdentity\Models\User
     * @throws Exception
     */
    public function createUser(array $data)
    {
        // TODO: Create new user
        // 1. Hash the password: $data['password'] = Hash::make($data['password'])
        // 2. Create user: return $this->userRepository->create($data)
    }

    /**
     * تحديث بيانات مستخدم
     * @param int $id
     * @param array $data  (validated from UserRequest)
     * @return \App\Modules\AuthIdentity\Models\User
     * @throws Exception
     */
    public function updateUser(int $id, array $data)
    {
        // TODO: Update user
        // 1. If password in data: $data['password'] = Hash::make($data['password'])
        // 2. Update: $this->userRepository->update($id, $data)
        // 3. Return updated user
    }

    /**
     * حذف مستخدم (Soft Delete)
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteUser(int $id): bool
    {
        // TODO: Soft delete user
        // 1. Check user exists: $this->userRepository->findByIdOrFail($id)
        // 2. Revoke all tokens before delete
        // 3. return $this->userRepository->delete($id)
    }

    /**
     * جلب المستخدمين حسب الحالة/الدور
     */
    public function getActiveUsers()
    {
        // TODO: return $this->userRepository->getActiveUsers();
    }

    public function getDrivers()
    {
        // TODO: return $this->userRepository->getDrivers();
    }

    public function getDispatchers()
    {
        // TODO: return $this->userRepository->getDispatchers();
    }

    public function getFleetManagers()
    {
        // TODO: return $this->userRepository->getFleetManagers();
    }

    public function getMechanics()
    {
        // TODO: return $this->userRepository->getMechanics();
    }
}

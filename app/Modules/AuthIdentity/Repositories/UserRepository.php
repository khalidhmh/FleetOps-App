<?php

/**
 * @file: UserRepository.php
 * @description: مستودع بيانات المستخدمين - Auth & Identity Service
 * @module: AuthIdentity
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\AuthIdentity\Repositories;

use App\Modules\Shared\Repositories\BaseRepository;
use App\Modules\AuthIdentity\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * البحث عن مستخدم بالإيميل
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        // TODO: Return user by email
        // return $this->model->where('email', $email)->first();
    }

    /**
     * الحصول على المستخدمين النشطين
     * @return Collection
     */
    public function getActiveUsers(): Collection
    {
        // TODO: Return all active users
        // return $this->model->active()->get();
    }

    /**
     * الحصول على السائقين النشطين
     * @return Collection
     */
    public function getDrivers(): Collection
    {
        // TODO: Return all active drivers
        // return $this->model->active()->driver()->get();
    }

    /**
     * الحصول على الموزعين
     * @return Collection
     */
    public function getDispatchers(): Collection
    {
        // TODO: Return all dispatchers
        // return $this->model->active()->dispatcher()->get();
    }

    /**
     * الحصول على مديري الأسطول
     * @return Collection
     */
    public function getFleetManagers(): Collection
    {
        // TODO: Return all fleet managers
        // return $this->model->active()->fleetManager()->get();
    }

    /**
     * الحصول على الميكانيكيين
     * @return Collection
     */
    public function getMechanics(): Collection
    {
        // TODO: Return all mechanics
        // return $this->model->active()->mechanic()->get();
    }

    /**
     * تحديث عدد محاولات الدخول الفاشلة
     * @param int $userId
     * @param int $attempts
     * @return bool
     */
    public function updateFailedAttempts(int $userId, int $attempts): bool
    {
        // TODO: Update failed_login_attempts for the user
        // return $this->update($userId, ['failed_login_attempts' => $attempts]);
    }

    /**
     * قفل حساب المستخدم
     * @param int $userId
     * @param \DateTime $until
     * @return bool
     */
    public function lockUser(int $userId, \DateTime $until): bool
    {
        // TODO: Set locked_until for the user
        // return $this->update($userId, ['locked_until' => $until, 'status' => 'locked']);
    }

    /**
     * تحديث آخر تسجيل دخول
     * @param int $userId
     * @return bool
     */
    public function updateLastLogin(int $userId): bool
    {
        // TODO: Update last_login_at to now
        // return $this->update($userId, ['last_login_at' => now(), 'failed_login_attempts' => 0]);
    }
}

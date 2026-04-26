<?php

/**
 * @file: RoleRepository.php
 * @description: Repository الخاص بـ Roles
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\IAM\Repositories;

use App\Modules\Shared\Repositories\BaseRepository;
use App\Modules\IAM\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository extends BaseRepository
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    /**
     * البحث عن دور بالـ Slug
     * @param string $slug
     * @return Role|null
     */
    public function findBySlug(string $slug): ?Role
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * الحصول على جميع الأدوار غير النظامية
     * @return Collection
     */
    public function getNonSystemRoles(): Collection
    {
        return $this->model->where('is_system_role', false)->get();
    }

    /**
     * الحصول على جميع الأدوار النظامية
     * @return Collection
     */
    public function getSystemRoles(): Collection
    {
        return $this->model->where('is_system_role', true)->get();
    }
}

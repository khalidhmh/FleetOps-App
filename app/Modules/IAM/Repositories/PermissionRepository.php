<?php

/**
 * @file: PermissionRepository.php
 * @description: Repository الخاص بـ Permissions
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\IAM\Repositories;

use App\Modules\Shared\Repositories\BaseRepository;
use App\Modules\IAM\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

class PermissionRepository extends BaseRepository
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    /**
     * البحث عن صلاحية بالـ Slug
     * @param string $slug
     * @return Permission|null
     */
    public function findBySlug(string $slug): ?Permission
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * الحصول على جميع الصلاحيات حسب المورد (Resource)
     * @param string $resource
     * @return Collection
     */
    public function getByResource(string $resource): Collection
    {
        return $this->model->where('resource', $resource)->get();
    }

    /**
     * الحصول على جميع الصلاحيات حسب الحدث (Action)
     * @param string $action
     * @return Collection
     */
    public function getByAction(string $action): Collection
    {
        return $this->model->where('action', $action)->get();
    }
}

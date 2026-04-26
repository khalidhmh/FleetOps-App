<?php

/**
 * @file: User.php
 * @description: نموذج Eloquent للمستخدمين (Users) - الهوية والمصادقة
 * @author: Team Leader (Khalid)
 */

namespace App\Modules\IAM\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'employee_id',
        'license_type',
        'status',
        'last_login_at',
        'created_by',
        'updated_by'
    ];

    protected $hidden = ['password', 'deleted_at'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'last_login_at' => 'datetime'
    ];

    protected $attributes = [
        'status' => 'active'
    ];

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    public function scopeDriver($query)
    {
        return $query->where('role', 'driver');
    }

    public function scopeDispatcher($query)
    {
        return $query->where('role', 'dispatcher');
    }

    public function scopeFleetManager($query)
    {
        return $query->where('role', 'fleet_manager');
    }

    public function scopeMechanic($query)
    {
        return $query->where('role', 'mechanic');
    }

    /**
     * Relationships
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id', 'permission_id');
    }
}

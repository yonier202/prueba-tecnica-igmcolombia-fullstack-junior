<?php

namespace App\Modules\Role\Services;

use App\Modules\Auth\Models\User;
use App\Modules\Role\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleService
{
    public function list()
    {
        return Role::with('permissions')->get();
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $permissions = $data['permissions'] ?? [];
            unset($data['permissions']);

            $role = Role::create($data);

            if (!empty($permissions)) {
                $role->syncPermissions($permissions);
            }

            return $role->load('permissions');
        });
    }

    public function update(Role $role, array $data)
    {
        return DB::transaction(function () use ($role, $data) {
            $permissions = $data['permissions'] ?? [];
            unset($data['permissions']);

            $role->update($data);

            if (!empty($permissions)) {
                $role->syncPermissions($permissions);
            }

            return $role->load('permissions');
        });
    }

    public function delete(Role $role)
    {
        return $role->delete();
    }

    public function getUserPermissions(int $userId)
    {
        $user = User::with('roles.permissions')->findOrFail($userId);
        $role = $user->roles->first();

        if (!$role) {
            return [
                'user_id' => $user->id,
                'role' => null,
                'permissions' => []
            ];
        }

        return [
            'user_id' => $user->id,
            'role_id' => $role->id,
            'role_name' => $role->name,
            'permissions' => $role->permissions->map(fn($permission) => [
                'id' => $permission->id,
                'name' => $permission->name,
            ])
        ];
    }
}

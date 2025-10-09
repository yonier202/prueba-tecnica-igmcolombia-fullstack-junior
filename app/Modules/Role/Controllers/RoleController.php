<?php

namespace App\Modules\Role\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Role\Models\Role;
use App\Modules\Role\Services\RoleService;
use App\Modules\Role\Requests\RoleRequest;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    protected RoleService $service;

    public function __construct(RoleService $service)
    {
        $this->middleware('can:administrador');
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->service->list());
    }

    public function store(RoleRequest $request): JsonResponse
    {
        $role = $this->service->create($request->validated());
        return response()->json([
            'message' => 'Rol creado y permisos asignados correctamente.',
            'role' => $role
        ], 201);
    }

    public function update(RoleRequest $request, Role $role): JsonResponse
    {
        $role = $this->service->update($role, $request->validated());
        return response()->json([
            'message' => 'Rol actualizado y permisos sincronizados correctamente.',
            'role' => $role
        ]);
    }

    public function getUserPermissions($userId): JsonResponse
    {
        $permissions = $this->service->getUserPermissions($userId);
        return response()->json($permissions);
    }
}

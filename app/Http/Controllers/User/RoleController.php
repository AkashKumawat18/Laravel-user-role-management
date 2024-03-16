<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Services\User\RoleService;
use App\Http\Requests\Role\CreateRoleRequest;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    /**
     * RoleController constructor
     * 
     * @param RoleService $roleService
     * 
     */
    public function __construct(
        protected RoleService $roleService,
    ) {
    }

    /**
     * Create Role
     * 
     * @param CreateRoleRequest $request
     * 
     * @return JsonResponse
     */
    public function create(CreateRoleRequest $request): JsonResponse
    {
        $this->roleService->create(data: $request->all());

        return response()->json(["Message" => "Role created successfully"]);
    }
}

//role -> create 

//question role create but keyyyy?
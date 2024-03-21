<?php

namespace App\Http\Controllers\user;

use App\Enums\PermissionEnum;
use App\Helpers\CoreHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\UpdateRoleRequest;
use App\Http\Services\User\RoleService;
use App\Http\Requests\Role\CreateRoleRequest;
use Exception;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\NoReturn;

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
     * @throws Exception
     */
     public function create(CreateRoleRequest $request): JsonResponse
    {
        CoreHelper::ensurePermission(PermissionEnum::P_CREATE_USER->value);

        $this->roleService->create(data: $request->all());

        return response()->json(["Message" => "Role created successfully"]);
    }

    /**
     * Update user
     *
     * @param int $id
     * @param UpdateRoleRequest $request
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function update(int $id, UpdateRoleRequest $request): JsonResponse
    {
        CoreHelper::ensurePermission(PermissionEnum::P_UPDATE_USER->value);

        $role = $this->roleService->getByIdOrFail($id);

        $this->roleService->update(role: $role, data: $request->all());

        return response()->json([

        ]);
    }

    /**
     * Delete a role
     *
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function delete($id):jsonResponse
    {
        CoreHelper::ensurePermission(PermissionEnum::P_DELETE_USER->value);

        $role = $this->roleService->getByIdOrFail($id);

        $role->delete();

        return response()->json([
            "users"=>"User has been deleted successfully ",
        ]);
    }

}


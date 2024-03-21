<?php

namespace App\Http\Services\User;

use App\Models\Role;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;


class RoleService
{
    /**
     * Get role using id(if not found throw exception)
     *
     * @param int $id
     *
     * @return ?Role
     */
    public function getByIdOrFail(int $id): ?Role
    {
        return Role::findOrFail($id);
    }


    /**
     * Create Role
     *
     * @param array $data
     *
     * @return Role
     */
    public function create(array $data): Role
    {
        return Role::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);
    }

    /**
     * update role
     *
     * @param Role $role
     * @param array $data
     * @throws \Exception
     */
    public function update(Role $role, array $data): void
    {
        if ($role->isSystemRole()) {
            throw new \Exception(__('System defined roles cannot be altered.'), 400);
        }

        $role->permissions()->sync($data['permission_ids']);
    }


}

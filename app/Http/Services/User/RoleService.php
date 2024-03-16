<?php

namespace App\Http\Services\User;

use App\Models\Role;


class RoleService
{
    /**
     * Create Role
     * 
     * @para
     */
    public function create(array $data): void
    {
        $role = Role::create([
            'name'=>$data['role'],
        ]);
    }
}
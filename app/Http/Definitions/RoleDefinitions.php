<?php

namespace App\Http\Definitions;

use App\Models\Role;
use App\Enums\RoleEnum;
use App\Enums\PermissionEnum;

class RoleDefinitions
{
    public array $roles = [
        RoleEnum::ADMIN => [
            'permissions' => [
                
            ],
            'readOnly' => true,
        ]
    ];


    public function get()
    {
        return array_merge(self::$roles, Role::all()->toArray());
    }
}
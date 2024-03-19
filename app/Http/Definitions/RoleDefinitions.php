<?php

namespace App\Http\Definitions;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;

class RoleDefinitions
{
    protected static array $roles = [
        RoleEnum::ADMIN->value => [
            'slug' => 'administrator',
            'name' => 'Administrator',
            'permissions' => [
                PermissionEnum::P_READ_USER->value,
                PermissionEnum::P_CREATE_USER->value,
                PermissionEnum::P_UPDATE_USER->value,
                PermissionEnum::P_DELETE_USER->value,
            ],
            'readOnly' => true,
        ]
    ];


    public static function get()
    {
        return array_merge(self::$roles);
    }
}

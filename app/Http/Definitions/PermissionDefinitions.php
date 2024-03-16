<?php

namespace App\Http\Definitions;

use App\Enums\PermissionEnum;

class PermissionDefinitions
{
    public static function get()
    {
        return [
            PermissionEnum::P_READ_USER->value => [
                'key' => PermissionEnum::P_READ_USER->value,
                'name' => 'Read User',
            ],
            PermissionEnum::P_CREATE_USER->value => [
                'key' => PermissionEnum::P_CREATE_USER->value,
                'name' => 'Create User',
            ],
            PermissionEnum::P_UPDATE_USER->value => [
                'key' => PermissionEnum::P_UPDATE_USER->value,
                'name' => 'Update User',
            ],
            PermissionEnum::P_DELETE_USER->value => [
                'key' => PermissionEnum::P_DELETE_USER->value,
                'name' => 'Delete User',
            ],
        ];
    }
}
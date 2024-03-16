<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case P_READ_USER = 'p-read-user';
    case P_CREATE_USER = 'p-create-user';
    case P_UPDATE_USER = 'p-update-user';
    case P_DELETE_USER = 'p-delete-user';
}
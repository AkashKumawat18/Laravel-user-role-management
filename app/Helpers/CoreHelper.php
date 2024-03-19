<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Auth;

class Helpers
{
    /**
     * Enuser whether logged in user has partcular permission or not
     * 
     * @param string $permission
     * 
     * @return bool
     * @throws Exception
     */
    public static function ensurePermission(string $permission)
    {
        $user = Auth::user();

        $userRole = $user->role;

        $hasPermission = $userRole->permissions()->where('key', $permission)->first();

        if ($hasPermission) {
            return true;
        }

        throw new Exception(__("You do not have permssion :permission", [
            'permission' => $permission,
        ]));
    }
}

<?php

namespace App\Helpers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class CoreHelper
{
    /**
     * Ensure whether logged-in user has particular permission or not
     *
     * @param string $permission
     *
     * @return bool
     * @throws Exception
     */
    public static function ensurePermission(string $permission): bool
    {
        /** @var User $user */
        $user = Auth::user();

        $userRole = $user->role()->first();
        if(empty($userRole)){
            throw new Exception(__("You do not have any role assigned"));
        }
        $hasPermission = $userRole->permissions()->where('key', $permission)->first();

        if ($hasPermission) {
            return true;
        }

        throw new Exception(__("You do not have permission :permission", [
            'permission' => $permission,
        ]));
    }
}

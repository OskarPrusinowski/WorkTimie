<?php

namespace App\Services\Permissions;

use App\Models\Users\User;

class PermissionsService
{
    public static function checkPermission(User $user, $permission)
    {
        $userPermissions = $user->role->permissions;
        foreach ($userPermissions as $userPermission) {
            if ($userPermission->name == $permission) {
                return true;
            }
        }
        return false;
    }
}

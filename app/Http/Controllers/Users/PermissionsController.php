<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\Users\UserService;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getPermissions($id)
    {
        $permissions = $this->userService->getUser($id)->role->permissions;
        return response()->json(['permissions' => $permissions]);
    }
}

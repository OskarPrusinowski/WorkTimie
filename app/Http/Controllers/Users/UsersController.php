<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\Users\UsersService;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public UsersService $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function list()
    {
        $users = $this->usersService->list();
        return response()->json(['users' => $users]);
    }
}

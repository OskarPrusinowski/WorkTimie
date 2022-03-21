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
        $this->middleware("permission:usersShow");
    }

    public function list(Request $request)
    {
        $users = $this->usersService->list($request->name);
        return response()->json(['users' => $users]);
    }

    public function listWithFiltr(Request $request)
    {
        $users = $this->usersService->listWithFiltr($request->date, $request->name);
        return response()->json(['users' => $users]);
    }
}

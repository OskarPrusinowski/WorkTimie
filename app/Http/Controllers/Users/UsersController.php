<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\Users\UsersService;
use Illuminate\Http\Request;
use App\Http\Requests\Users\FiltrUsers;
use App\Http\Requests\Users\FiltrWorkdaysUsers;

class UsersController extends Controller
{
    public UsersService $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
        $this->middleware("permission:usersShow");
    }

    public function list(FiltrUsers $request)
    {
        $users = $this->usersService->list($request->name, $request->departmentId);
        return response()->json(['users' => $users]);
    }

    public function listWithFiltr(FiltrWorkdaysUsers $request)
    {
        $users = $this->usersService->listWithFiltr($request->start, $request->stop, $request->name);
        return response()->json(['users' => $users]);
    }

    public function listLeaves(Request $request)
    {
        $users = $this->usersService->specialListLeaves($request->date, $request->name, $request->departmentId);
        return response()->json(['users' => $users]);
    }

    public function increaseCounterHolidays()
    {
        $this->usersService->increaseCounterHolidays();
    }
}

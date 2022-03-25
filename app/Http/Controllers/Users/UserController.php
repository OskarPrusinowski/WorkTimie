<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\Users\CreateUpdateUser;

class UserController extends Controller
{
    public UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware("permission:usersShow");
        $this->middleware("permission:usersManage");
    }

    public function show($id)
    {
        $user = $this->userService->getUser($id);
        return response()->json(['user' => $user]);
    }

    public function create(CreateUpdateUser $response)
    {
        $this->userService->createUser($response->get('user'));
    }

    public function update(CreateUpdateUser $request)
    {
        $newUser = $request->get('user');
        $this->userService->updateUser($newUser, $newUser['id']);
    }

    public function destroy($id)
    {
        $this->userService->deleteUser($id);
    }
}

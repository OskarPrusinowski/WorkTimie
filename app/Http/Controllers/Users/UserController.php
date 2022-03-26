<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\Users\UpdateUser;
use App\Http\Requests\Users\CreateUser;
use App\Events\UserCreatedEvent;

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

    public function create(CreateUser $response)
    {
        $user = $this->userService->createUser($response->get('user'));
        event(new UserCreatedEvent(1));
    }

    public function update(UpdateUser $request)
    {
        $newUser = $request->get('user');
        $this->userService->updateUser($newUser, $newUser['id']);
    }

    public function destroy($id)
    {
        $this->userService->deleteUser($id);
    }
}

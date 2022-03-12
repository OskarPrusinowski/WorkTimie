<?php

namespace App\Services\Users;

use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function getUser($id)
    {
        return $this->userModel->find($id);
    }

    public function createUser($user)
    {
        $user['date_start_employment'] = Carbon::create($user['date_start_employment']);
        $user['password'] = Hash::make($user['password']);
        $this->userModel::create($user);
    }

    public function deleteUser($id)
    {
        $this->userModel->destroy($id);
    }

    public function updateUser($newUser, $id)
    {
        $user = $this->getUser($id);
        if (array_key_exists('password', $newUser)) {
            $newUser = Hash::make($newUser['password']);
        }
        $user->update($newUser);
    }
}

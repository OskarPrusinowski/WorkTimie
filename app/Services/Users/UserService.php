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

    public function get($id)
    {
        return $this->userModel->with("group")->find($id);
    }

    public function create($user)
    {
        $user['current_counter_holidays'] = $user['counter_holidays'];
        $user['date_start_employment'] = Carbon::create($user['date_start_employment']);
        $user['password'] = Hash::make($user['password']);
        if ($user['group_id'] == 3) {
            $user['role_id'] = 3;
        } else {
            $user['role_id'] = 2;
        }
        return $this->userModel::create($user);
    }

    public function delete($id)
    {
        $this->userModel->destroy($id);
    }

    public function update($newUser, $id)
    {
        $user = $this->get($id);
        if (array_key_exists('password', $newUser)) {
            $newUser = Hash::make($newUser['password']);
        }
        $user->update($newUser);
    }
}

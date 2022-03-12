<?php

namespace App\Services\Users;

use App\Models\Users\User;

class UsersService
{
    public User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function list()
    {
        return $this->userModel->with("group")->get();
    }
}

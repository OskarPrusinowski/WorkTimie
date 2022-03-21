<?php

namespace App\Services\Users;

use App\Models\Users\User;
use Illuminate\Contracts\Database\Eloquent\Builder;

class UsersService
{
    public User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function list($name)
    {
        $name = $name ? $name : "";
        return $this->userModel->with("group")->userName($name)->get();
    }

    public function listWithFiltr($date, $userName)
    {
        $userName = $userName ? $userName : "";
        $users = $this->userModel->with("workdays")->userName($userName)->whereHas('workdays', function (Builder $query) use ($date) {
            $query->month($date);
        })->get();
        return $users;
    }

    public function listAdmin()
    {
        return $this->userModel->admin()->get();
    }
}

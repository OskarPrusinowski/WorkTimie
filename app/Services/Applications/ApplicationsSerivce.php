<?php

namespace App\Services\Applications;

use App\Models\Applications\Application;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ApplicationsSerivce
{
    public Application $applicationModel;

    public function __construct(Application $applicationModel)
    {
        $this->applicationModel = $applicationModel;
    }

    public function list($month, $status, $userId)
    {
        $status = $status ? $status : "";
        return $this->applicationModel->with("user")->month($month)->status($status)->userId($userId)->get();
    }
    public function listWithUser($month, $status, $userName)
    {
        $userName = $userName ? $userName : "";
        $status = $status ? $status : "";
        return $this->applicationModel->with("user")->month($month)->status($status)->whereHas('user', function (Builder $query) use ($userName) {
            $query->userName($userName);
        })->get();
    }

    public function listWaiting()
    {
        return $this->applicationModel->waiting()->get();
    }
}

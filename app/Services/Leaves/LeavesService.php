<?php

namespace App\Services\Leaves;

use App\Models\Leaves\Leave;
use Illuminate\Contracts\Database\Eloquent\Builder;

class LeavesService
{

    public Leave $leaveModel;

    public function __construct(Leave $leaveModel)
    {
        $this->leaveModel = $leaveModel;
    }

    public function listByUser($userId)
    {
        return $this->leaveModel->byUser($userId)->get();
    }

    public function listByDate($date, $userName)
    {
        $userName = $userName ? $userName : "";
        return $this->leaveModel->month($date)->with("user")
            ->whereHas('user', function (Builder $query) use ($userName) {
                $query->userName($userName);
            })->get();
    }

    public function list()
    {
        return $this->leaveModel->with("user")->get();
    }
}

<?php

namespace App\Services\Workdays;

use App\Models\Workdays\Workday;

class WorkdaysService
{
    public Workday $workdayModel;

    public function __construct(Workday $workdayModel)
    {
        $this->workdayModel = $workdayModel;
    }

    public function list($userId, $date)
    {
        return $this->workdayModel->filtrByUser($userId)->month($date)->get();
    }

    public function listAnother($userId)
    {
        return $this->workdayModel->with("user")->notUser(0)->today()->get();
    }
}

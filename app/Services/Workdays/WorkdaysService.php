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

    public function list($userId)
    {
        return $this->workdayModel->filtrByUser($userId)->get();
    }
}

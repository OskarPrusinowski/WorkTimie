<?php

namespace App\Services\Overtimes;

use App\Models\Overtimes\Overtime;

class OvertimesService
{

    public Overtime $overtimeModel;

    public function __construct(Overtime $overtimeModel)
    {
        $this->overtimeModel = $overtimeModel;
    }

    public function listToday($userId)
    {
        return $this->overtimeModel->today()->byUser($userId)->get();
    }
}

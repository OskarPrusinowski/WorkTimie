<?php

namespace App\Services\Overtimes;

use App\Models\Overtimes\Overtime;

class OvertimeService
{

    public Overtime $overtimeModel;

    public function __construct(Overtime $overtimeModel)
    {
        $this->overtimeModel = $overtimeModel;
    }

    public function show($id)
    {
        return $this->overtimeModel->find($id);
    }

    public function create($overtime)
    {
        $this->overtimeModel::create($overtime);
    }
}

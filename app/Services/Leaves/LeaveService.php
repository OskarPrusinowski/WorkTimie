<?php

namespace App\Services\Leaves;

use App\Models\Leaves\Leave;

class LeaveService
{

    public Leave $leaveModel;

    public function __construct(Leave $leaveModel)
    {
        $this->leaveModel = $leaveModel;
    }

    public function show($id)
    {
        return $this->leaveModel->find($id);
    }

    public function create($newLeave)
    {
        $this->leaveModel::create($newLeave);
    }
}

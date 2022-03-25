<?php

namespace App\Services\Departments;

use App\Models\Departments\Department;

class DepartmentsService
{

    public Department $departmentModel;

    public function __construct(Department $departmentModel)
    {
        $this->departmentModel = $departmentModel;
    }

    public function list()
    {
        return $this->departmentModel->get();
    }
}

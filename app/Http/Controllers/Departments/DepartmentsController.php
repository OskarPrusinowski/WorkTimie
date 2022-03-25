<?php

namespace App\Http\Controllers\Departments;

use App\Http\Controllers\Controller;
use App\Services\Departments\DepartmentsService;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public DepartmentsService $departmentsService;

    public function __construct(DepartmentsService $departmentsService)
    {
        $this->departmentsService = $departmentsService;
        $this->middleware("permission:departmentsShow");
    }

    public function list()
    {
        $departments = $this->departmentsService->list();
        return response()->json(['departments' => $departments]);
    }
}

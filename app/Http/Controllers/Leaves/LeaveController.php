<?php

namespace App\Http\Controllers\Leaves;

use App\Http\Controllers\Controller;
use App\Services\Leaves\LeaveService;
use Illuminate\Http\Request;
use App\Http\Requests\Leaves\CreateLeave;

class LeaveController extends Controller
{
    public LeaveService $leaveService;

    public function __construct(LeaveService $leaveService)
    {
        $this->leaveService = $leaveService;
        $this->middleware("permission:leavesShow");
        $this->middleware("permission:leavesMange");
    }

    public function create(CreateLeave $request)
    {
        $this->leaveService->create($request->get("leave"));
    }
}

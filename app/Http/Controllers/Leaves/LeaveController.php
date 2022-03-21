<?php

namespace App\Http\Controllers\Leaves;

use App\Http\Controllers\Controller;
use App\Services\Leaves\LeaveService;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public LeaveService $leaveService;

    public function __construct(LeaveService $leaveService)
    {
        $this->leaveService = $leaveService;
    }

    public function create(Request $request)
    {
        $this->leaveService->create($request->get("leave"));
    }
}

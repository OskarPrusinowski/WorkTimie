<?php

namespace App\Http\Controllers\Overtimes;

use App\Http\Controllers\Controller;
use App\Services\Overtimes\OvertimeService;
use Illuminate\Http\Request;
use App\Http\Requests\Overtimes\CreateOvertime;

class OvertimeController extends Controller
{
    public OvertimeService $overtimeService;

    public function __construct(OvertimeService $overtimeService)
    {
        $this->overtimeService = $overtimeService;
        $this->middleware("permission:overtimesShow");
        $this->middleware("permission:overtimesMange");
    }

    public function create(CreateOvertime $request)
    {
        $this->overtimeService->create($request->get("overtime"));
    }
}

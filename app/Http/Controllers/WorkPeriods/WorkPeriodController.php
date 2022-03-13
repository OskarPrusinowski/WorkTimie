<?php

namespace App\Http\Controllers\WorkPeriods;

use App\Http\Controllers\Controller;
use App\Services\WorkPeriods\WorkPeriodService;
use Illuminate\Http\Request;

class WorkPeriodController extends Controller
{
    public WorkPeriodService $workPeriodService;

    public function __construct(WorkPeriodService $workPeriodService)
    {
        $this->workPeriodService = $workPeriodService;
        $this->middleware("permission:workdaysShow");
    }

    public function start(Request $request, $workdayId)
    {
        $this->workPeriodService->start($request->get("type"), $workdayId);
    }

    public function stop(Request $request, $workPeriodId)
    {
        $this->workPeriodService->stop($request->get("workPeriod"), $workPeriodId);
    }

    public function getLastWorkPeriod($workdayId)
    {
        $workday = $this->workPeriodService->getLastWorkPeriod($workdayId);
        return response()->json(['workday' => $workday]);
    }
}

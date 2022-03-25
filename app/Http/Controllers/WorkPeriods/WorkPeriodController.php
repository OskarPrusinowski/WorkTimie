<?php

namespace App\Http\Controllers\WorkPeriods;

use App\Http\Controllers\Controller;
use App\Services\WorkPeriods\WorkPeriodService;
use Illuminate\Http\Request;
use App\Http\Requests\WorkPeriods\StartStopWorkPeriod;

class WorkPeriodController extends Controller
{
    public WorkPeriodService $workPeriodService;

    public function __construct(WorkPeriodService $workPeriodService)
    {
        $this->workPeriodService = $workPeriodService;
        $this->middleware("permission:workPeriodsShow");
        $this->middleware("permission:workPeriodsManage");
    }

    public function start(StartStopWorkPeriod $request)
    {
        $this->workPeriodService->start($request->get("workPeriod"));
    }

    public function stop(StartStopWorkPeriod $request, $workPeriodId)
    {
        $this->workPeriodService->stop($request->get("workPeriod"), $workPeriodId);
    }

    public function getLastWorkPeriod($workdayId)
    {
        $workday = $this->workPeriodService->getLastWorkPeriod($workdayId);
        return response()->json(['workday' => $workday]);
    }
}

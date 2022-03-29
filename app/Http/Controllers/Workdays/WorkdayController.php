<?php

namespace App\Http\Controllers\Workdays;

use App\Http\Controllers\Controller;
use App\Services\Workdays\WorkdayService;
use Illuminate\Http\Request;
use App\Http\Requests\WorkDays\StartWorkDay;
use App\Http\Requests\WorkDays\StopWorkDay;
use App\Http\Requests\WorkDays\AddWorkDay;
use App\Http\Requests\WorkDays\UpdateWorkDay;

class WorkdayController extends Controller
{
    public WorkdayService $workdayService;

    public function __construct(WorkdayService $workdayService)
    {
        $this->workdayService = $workdayService;
        $this->middleware("permission:workdaysShow");
        $this->middleware("permission:workdaysManage");
    }

    public function start(StartWorkDay $request)
    {
        $this->workdayService->start($request->userId, $request->defaultWorktime);
    }

    public function stop(StopWorkDay $request, $workdayId)
    {
        $this->workdayService->stop($request->get("workday"), $workdayId);
    }

    public function update(UpdateWorkDay $request, $workdayId)
    {
        $this->workdayService->update($request->get("workday"), $workdayId);
    }

    public function getByUser($userId)
    {
        $workday = $this->workdayService->getByUser($userId);
        return response()->json(['workday' => $workday]);
    }

    public function add(AddWorkDay $request, $userId)
    {
        $this->workdayService->add($userId, $request->minutes, $request->type);
    }
}

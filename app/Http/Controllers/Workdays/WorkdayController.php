<?php

namespace App\Http\Controllers\Workdays;

use App\Http\Controllers\Controller;
use App\Services\Workdays\WorkdayService;
use Illuminate\Http\Request;

class WorkdayController extends Controller
{
    public WorkdayService $workdayService;

    public function __construct(WorkdayService $workdayService)
    {
        $this->workdayService = $workdayService;
        $this->middleware("permission:workdaysShow");
        $this->middleware("permission:workdaysManage");
    }

    public function start(Request $request)
    {
        $this->workdayService->start($request->userId, $request->defaultWorktime);
    }

    public function stop(Request $request, $workdayId)
    {
        $this->workdayService->stop($request->get("workday"), $workdayId);
    }

    public function update(Request $request, $workdayId)
    {
        $this->workdayService->updateWorkday($request->get("workday"), $workdayId);
    }

    public function getByUser($userId)
    {
        $workday = $this->workdayService->getByUser($userId);
        return response()->json(['workday' => $workday]);
    }

    public function add(Request $request, $userId)
    {
        $this->workdayService->add($userId, $request->minutes, $request->type);
    }
}

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
    }

    public function start($userId)
    {
        $this->workdayService->start($userId);
    }

    public function stop(Request $request, $workdayId)
    {
        $this->workdayService->stop($request->get("workday"), $workdayId);
    }

    public function getByUser($userId)
    {
        $workday = $this->workdayService->getByUser($userId);
        return response()->json(['workday' => $workday]);
    }
}

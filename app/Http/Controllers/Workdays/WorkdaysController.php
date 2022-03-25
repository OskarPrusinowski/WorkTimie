<?php

namespace App\Http\Controllers\Workdays;

use App\Http\Controllers\Controller;
use App\Services\Workdays\WorkdaysService;
use Illuminate\Http\Request;
use App\Http\Requests\WorkDays\FiltrWorkDays;

class WorkdaysController extends Controller
{
    public WorkdaysService $workdaysService;

    public function __construct(WorkdaysService $workdaysService)
    {
        $this->workdaysService = $workdaysService;
        $this->middleware("permission:workdaysShow");
    }

    public function list(FiltrWorkDays $request, $userId)
    {
        $workdays = $this->workdaysService->list($userId, $request->date);
        return response()->json(['workdays' => $workdays]);
    }

    public function listAnother($userId)
    {
        $workdays = $this->workdaysService->listAnother($userId);
        return response()->json(['workdays' => $workdays]);
    }
}

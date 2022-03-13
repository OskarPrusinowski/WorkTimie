<?php

namespace App\Http\Controllers\Workdays;

use App\Http\Controllers\Controller;
use App\Services\Workdays\WorkdaysService;
use Illuminate\Http\Request;
use App\Models\Users\User;

class WorkdaysController extends Controller
{
    public WorkdaysService $workdaysService;

    public function __construct(WorkdaysService $workdaysService)
    {
        $this->workdaysService = $workdaysService;
        $this->middleware("permission:workdaysShow");
    }

    public function list(Request $request, $userId)
    {
        $workdays = $this->workdaysService->list($userId, $request->date);
        return response()->json(['workdays' => $workdays]);
    }
}

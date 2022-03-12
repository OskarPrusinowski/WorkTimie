<?php

namespace App\Http\Controllers\Workdays;

use App\Http\Controllers\Controller;
use App\Services\Workdays\WorkdaysService;
use Illuminate\Http\Request;

class WorkdaysController extends Controller
{
    public WorkdaysService $workdaysService;

    public function __construct(WorkdaysService $workdaysService)
    {
        $this->workdaysService = $workdaysService;
    }

    public function list($userId)
    {
        $workdays = $this->workdaysService->list($userId);
        return response()->json(['workdays' => $workdays]);
    }
}

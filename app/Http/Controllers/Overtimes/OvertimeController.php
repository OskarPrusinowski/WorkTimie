<?php

namespace App\Http\Controllers\Overtimes;

use App\Http\Controllers\Controller;
use App\Services\Overtimes\OvertimeService;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    public OvertimeService $overtimeService;

    public function __construct(OvertimeService $overtimeService)
    {
        $this->overtimeService = $overtimeService;
    }

    public function create(Request $request)
    {
        $this->overtimeService->create($request->get("overtime"));
    }
}

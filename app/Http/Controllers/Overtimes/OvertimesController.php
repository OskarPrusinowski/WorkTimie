<?php

namespace App\Http\Controllers\Overtimes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Overtimes\OvertimesService;

class OvertimesController extends Controller
{
    public OverTimesService $overTimesService;

    public function __construct(OverTimesService $overTimesService)
    {
        $this->overtimesService = $overTimesService;
    }

    public function listToday($userId)
    {
        $overtimes = $this->overtimesService->listToday($userId);
        return response()->json(["overtimes" => $overtimes]);
    }
}

<?php

namespace App\Http\Controllers\Leaves;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Leaves\LeavesService;

class LeavesController extends Controller
{
    public LeavesService $leavesService;

    public function __construct(LeavesService $leavesService)
    {
        $this->leavesService = $leavesService;
    }

    public function listByUser($userId)
    {
        $leaves = $this->leavesService->listByUser($userId);
        return response()->json(['leaves' => $leaves]);
    }

    public function listByDate(Request $request)
    {
        $leaves = $this->leavesService->listByDate($request->date, $request->userName);
        return response()->json(['leaves' => $leaves]);
    }

    public function list()
    {
        $leaves = $this->leavesService->list();
        return response()->json(['leaves' => $leaves]);
    }
}

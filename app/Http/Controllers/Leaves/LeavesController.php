<?php

namespace App\Http\Controllers\Leaves;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Leaves\LeavesService;
use App\Http\Requests\Leaves\FiltrLeaves;

class LeavesController extends Controller
{
    public LeavesService $leavesService;

    public function __construct(LeavesService $leavesService)
    {
        $this->leavesService = $leavesService;
        $this->middleware("permission:leavesShow");
    }

    public function listByUser($userId)
    {
        $leaves = $this->leavesService->listByUser($userId);
        return response()->json(['leaves' => $leaves]);
    }

    public function specialList(FiltrLeaves $request)
    {
        $leaves = $this->leavesService->specialList($request->date, $request->userName, $request->departmentId);
        return response()->json(['leaves' => $leaves]);
    }

    public function list()
    {
        $leaves = $this->leavesService->list();
        return response()->json(['leaves' => $leaves]);
    }
}

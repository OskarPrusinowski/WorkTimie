<?php

namespace App\Http\Controllers\Applications;

use App\Http\Controllers\Controller;
use App\Services\Applications\ApplicationsSerivce;
use Illuminate\Http\Request;
use App\Http\Requests\Applications\FiltrApplications;

class ApplicationsController extends Controller
{
    public ApplicationsSerivce $applicationsSerivce;

    public function __construct(ApplicationsSerivce $applicationsSerivce)
    {
        $this->applicationsSerivce = $applicationsSerivce;
        $this->middleware("permission:applicationsShow");
    }

    public function list(FiltrApplications $request)
    {
        $applications = $this->applicationsSerivce->list($request->month, $request->status, $request->userName);
        return response()->json(['applications' => $applications]);
    }

    public function countWaiting()
    {
        $applications = $this->applicationsSerivce->listWaiting();
        return response()->json(['counter' => count($applications)]);
    }
}

<?php

namespace App\Http\Controllers\Applications;

use App\Http\Controllers\Controller;
use App\Services\Applications\ApplicationsSerivce;
use Illuminate\Http\Request;
use App\Http\Requests\Applications\FiltrApplications;
use App\Models\Users\User;
use Illuminate\Support\Facades\Gate;

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
        if (Gate::allows('hasPermission', 'applicationsAdminManage')) {
            $applications = $this->applicationsSerivce->listWithUser($request->month, $request->status, $request->userName);
        } else {
            $applications = $this->applicationsSerivce->list($request->month, $request->status, $request->user()->id);
        }
        return response()->json(['applications' => $applications]);
    }

    public function countWaiting()
    {
        $applications = $this->applicationsSerivce->listWaiting();
        return response()->json(['counter' => count($applications)]);
    }
}

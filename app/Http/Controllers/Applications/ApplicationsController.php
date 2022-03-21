<?php

namespace App\Http\Controllers\Applications;

use App\Http\Controllers\Controller;
use App\Services\Applications\ApplicationsSerivce;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
{
    public ApplicationsSerivce $applicationsSerivce;

    public function __construct(ApplicationsSerivce $applicationsSerivce)
    {
        $this->applicationsSerivce = $applicationsSerivce;
    }

    public function list(Request $request)
    {
        $applications = $this->applicationsSerivce->list($request->month, $request->status, $request->userName);
        return response()->json(['applications' => $applications]);
    }
}

<?php

namespace App\Http\Controllers\Applications;

use App\Http\Controllers\Controller;
use App\Services\Applications\ApplicationSerivce;
use Illuminate\Http\Request;
use App\Http\Requests\Applications\CreateUpdateApplication;
use App\Http\Requests\Applications\ConsiderApplication;

class ApplicationController extends Controller
{
    public ApplicationSerivce $applicationSerivce;

    public function __construct(ApplicationSerivce $applicationSerivce)
    {
        $this->applicationSerivce = $applicationSerivce;
        $this->middleware("permission:applicationsShow");
        $this->middleware("permission:applicationsManage");
    }

    public function show($id)
    {
        $application = $this->applicationSerivce->get($id);
        return response()->json(['application' => $application]);
    }

    public function create(CreateUpdateApplication $request)
    {
        $this->applicationSerivce->create($request->get("application"));
    }

    public function update(CreateUpdateApplication $request, $id)
    {
        $this->applicationSerivce->update($id, $request->get("application"));
    }

    public function consider(ConsiderApplication $request, $id)
    {
        $this->applicationSerivce->consider($id, $request->acceptationId, $request->accepted, $request->acceptationComment);
    }
}

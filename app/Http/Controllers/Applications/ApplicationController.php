<?php

namespace App\Http\Controllers\Applications;

use App\Http\Controllers\Controller;
use App\Services\Applications\ApplicationSerivce;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public ApplicationSerivce $applicationSerivce;

    public function __construct(ApplicationSerivce $applicationSerivce)
    {
        $this->applicationSerivce = $applicationSerivce;
    }

    public function show($id)
    {
        $application = $this->applicationSerivce->show($id);
        return response()->json(['application' => $application]);
    }

    public function create(Request $request)
    {
        $this->applicationSerivce->create($request->get("application"));
    }

    public function update(Request $request, $id)
    {
        $this->applicationSerivce->update($id, $request->get("application"));
    }

    public function consider(Request $request, $id)
    {
        $this->applicationSerivce->consider($id, $request->acceptationId, $request->accepted);
    }
}

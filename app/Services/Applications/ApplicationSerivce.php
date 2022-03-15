<?php

namespace App\Services\Applications;

use App\Models\Applications\Application;
use Carbon\Carbon;
use App\Services\Users\UserService;

class ApplicationSerivce
{
    public Application $applicationModel;
    public UserService $userService;

    public function __construct(Application $applicationModel, UserService $userService)
    {
        $this->applicationModel = $applicationModel;
        $this->userService = $userService;
    }

    public function create($application)
    {
        $application['date'] = new Carbon();
        $application['status'] = "Oczekiwany";
        $this->applicationModel::create($application);
    }

    public function show($id)
    {
        return $this->applicationModel->find($id);
    }

    public function update($id, $newApplication)
    {
        $application = $this->show($id);
        $application->update($newApplication);
    }

    public function consider($id, $acceptationId, $accepted)
    {
        $user = $this->userService->getUser($acceptationId);
        $application = $this->show($id);
        $application->acceptation_Date = new Carbon();
        $accpeted = $accepted ? 1 : 0;
        $application->status = $accepted ? "Zaakceptowany" : "Odrzucony";
        $application->accepted = $accpeted;
        $application->save();
        $application->accepting()->save($user);
    }
}

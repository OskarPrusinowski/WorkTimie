<?php

namespace App\Services\Applications;

use App\Mail\ApplicationMail;
use App\Models\Applications\Application;
use Carbon\Carbon;
use App\Services\Users\UserService;
use App\Services\Users\UsersService;
use App\Services\Applications\ApplicationsCounterService;
use Illuminate\Support\Facades\Mail;

class ApplicationSerivce
{
    public Application $applicationModel;
    public UserService $userService;
    public UsersService $usersService;
    public ApplicationsCounterService $applicationsCounterService;

    public function __construct(Application $applicationModel, UserService $userService, UsersService $usersService, ApplicationsCounterService $applicationsCounterService)
    {
        $this->applicationModel = $applicationModel;
        $this->userService = $userService;
        $this->usersService = $usersService;
        $this->applicationsCounterService = $applicationsCounterService;
    }

    public function create($application)
    {
        $application['status'] = "Oczekiwany";
        $application['date'] = Carbon::now();
        $applicationCounter = $this->applicationsCounterService->show($application['type'], substr($application['date'], 0, 4));
        $applicationCounter->counter++;
        $application['number'] = substr($applicationCounter->type, 0, 1) . '/' . $applicationCounter->counter . '/' . $applicationCounter->year;
        $applicationCounter->save();
        $this->applicationModel::create($application);
        $this->sendNotification($application);
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

    public function consider($id, $acceptationId, $accepted, $acceptationComment)
    {
        $user = $this->userService->getUser($acceptationId);
        $application = $this->show($id);
        $application->acceptation_comment = $acceptationComment;
        $application->acceptation_Date = new Carbon();
        $application->status = $accepted ? "Zaakceptowany" : "Odrzucony";
        $application->accepted = $accepted;
        $application->save();
        $application->accepting()->save($user);
    }

    public function sendNotification($application)
    {
        $admins = $this->usersService->listAdmin();
        $user = $this->userService->getUser($application['user_id']);
        foreach ($admins as $admin) {

            Mail::to($admin->email)->send(new ApplicationMail($application, $user));
        }
    }
}

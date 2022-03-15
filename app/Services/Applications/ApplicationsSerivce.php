<?php

namespace App\Services\Applications;

use App\Models\Applications\Application;

class ApplicationsSerivce
{
    public Application $applicationModel;

    public function __construct(Application $applicationModel)
    {
        $this->applicationModel = $applicationModel;
    }

    public function list()
    {
        return $this->applicationModel->with("user")->get();
    }
}

<?php

namespace App\Services\Applications;

use App\Models\Applications\ApplicationsCounter;

class ApplicationsCounterService
{

    public ApplicationsCounter $applicationsCounterModel;

    public function __construct(ApplicationsCounter $applicationsCounterModel)
    {
        $this->applicationsCounterModel = $applicationsCounterModel;
    }

    public function show($type, $year)
    {
        return $this->applicationsCounterModel->type($type)->year($year)->first();
    }
}

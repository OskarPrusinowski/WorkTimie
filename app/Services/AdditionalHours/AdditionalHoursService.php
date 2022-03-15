<?php

namespace App\Services\AdditionalHours;

use App\Models\AdditionalHours\AdditionalHour;

class AdditionalHoursService
{

    public AdditionalHour $additionalHourModel;

    public function __construct(AdditionalHour $additionalHourModel)
    {
        $this->additionalHourModel = $additionalHourModel;
    }

    public function getAdditionalHoursByUser($userId)
    {
        return $this->additionalHourModel->byUser($userId)->today()->get();
    }
}

<?php

namespace App\Services\AdditionalHours;

use App\Models\AdditionalHours\AdditionalHour;

class AdditionalHourService
{

    public AdditionalHour $additionalHourModel;

    public function __construct(AdditionalHour $additionalHourModel)
    {
        $this->additionalHourModel = $additionalHourModel;
    }

    public function createAdditionalHour($additionalHour)
    {
        $this->additionalHourModel::create($additionalHour);
    }

    public function getAdditionalHour($id)
    {
        return $this->additionalHourModel->find($id);
    }

    public function getAdditionalHourByUser($userId)
    {
        return $this->additionalHourModel->byUser($userId)->today()->first();
    }
}

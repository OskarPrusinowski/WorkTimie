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

    public function create($additionalHour)
    {
        $this->additionalHourModel::create($additionalHour);
    }

    public function get($id)
    {
        return $this->additionalHourModel->find($id);
    }

    public function getByUser($userId)
    {
        return $this->additionalHourModel->byUser($userId)->today()->first();
    }
}

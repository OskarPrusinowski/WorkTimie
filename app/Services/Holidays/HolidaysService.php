<?php

namespace App\Services\Holidays;

use App\Models\Holidays\Holiday;

class HolidaysService
{

    public Holiday $holidayModel;

    public function __construct(Holiday $holidayModel)
    {
        $this->holidayModel = $holidayModel;
    }

    public function list($date)
    {
        return $this->holidayModel->month($date)->get();
    }
}

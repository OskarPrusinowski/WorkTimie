<?php

namespace App\Services\Holidays;

use App\Models\Holidays\Holiday;
use Carbon\Carbon;

class HolidayService
{
    public Holiday $holidayModel;

    protected $weekMap = [
        0 => 'Niedziela',
        1 => 'Poniedziałek',
        2 => 'Wtorek',
        3 => 'Środa',
        4 => 'Czwartek',
        5 => 'Piątek',
        6 => 'Sobota',
    ];

    public function __construct(Holiday $holidayModel)
    {
        $this->holidayModel = $holidayModel;
    }

    public function create($holiday)
    {
        $holiday['day'] = $this->weekMap[(new Carbon($holiday['date']))->dayOfWeek];
        $this->holidayModel::create($holiday);
    }

    public function delete($id)
    {
        $this->holidayModel->destroy($id);
    }
}

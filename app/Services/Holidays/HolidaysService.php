<?php

namespace App\Services\Holidays;

use App\Models\Holidays\Holiday;
use Carbon\Carbon;

class HolidaysService
{

    public Holiday $holidayModel;

    public function __construct(Holiday $holidayModel)
    {
        $this->holidayModel = $holidayModel;
    }

    public function list($date)
    {
        return $this->holidayModel->year($date)->ascDate()->get();
    }

    public function makeFreeSaturdays($date)
    {
        $starudayDay = (Carbon::createFromFormat("Y", $date))->startOfYear();
        $nextYear = (Carbon::createFromFormat("Y", $date))->startOfYear()->addYear();
        while ($starudayDay->dayOfWeek != 6) {
            $starudayDay->addDay();
        }
        $data = [];
        while ($starudayDay->lt($nextYear)) {
            $data[] = ['name' => "Wolna sobota", "day" => "Sobota", "date" => new Carbon($starudayDay)];
            $starudayDay->addDays(7);
        }
        $this->holidayModel->insert($data);
    }

    public function deleteFreeSaturdays($date)
    {
        $this->holidayModel->year($date)->where("name", "Wolna sobota")->delete();
    }

    public function freeSaturdays($date, $freeStarudays)
    {
        if ($freeStarudays == "true") {
            $this->makeFreeSaturdays($date);
        } else {
            $this->deleteFreeSaturdays($date);
        }
    }
}

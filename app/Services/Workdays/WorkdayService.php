<?php

namespace App\Services\Workdays;

use App\Models\Workdays\Workday;
use Carbon\Carbon;
use App\Services\Overtimes\OvertimesService;
use App\Services\AdditionalHours\AdditionalHoursService;

class WorkdayService
{

    public Workday $workdayModel;
    public OvertimesService $overtimesService;
    public AdditionalHoursService $additionalHoursService;

    protected $weekMap = [
        0 => 'Niedziela',
        1 => 'Poniedziałek',
        2 => 'Wtorek',
        3 => 'Środa',
        4 => 'Czwartek',
        5 => 'Piątek',
        6 => 'Sobota',
    ];

    public function __construct(Workday $workdayModel, OvertimesService $overtimesService, AdditionalHoursService $additionalHoursService)
    {
        $this->workdayModel = $workdayModel;
        $this->overtimesService = $overtimesService;
        $this->additionalHoursService = $additionalHoursService;
    }


    public function get($id)
    {
        $workday = $this->workdayModel->with("workPeriods")->find($id);
        return $this->workdayModel->with("workPeriods")->find($id);
    }

    public function update($newWorkday, $workdayId)
    {
        $workday = $this->get($workdayId);
        $workday->update($newWorkday);
    }

    public function stop($workday, $workdayId)
    {
        $workday['stop'] = Carbon::now()->addHours(2);
        $workPeriods = $this->get($workdayId)->workPeriods;
        $break = 0;
        foreach ($workPeriods as $workPeriod) {
            $break += $workPeriod->minutes;
        }
        $workday['breaktime'] = $break;
        $workday['worktime'] = Carbon::create($workday['start'])->diffInMinutes($workday['stop']) - $break;
        $this->update($workday, $workdayId);
    }

    public function create($workday)
    {
        $workday['additional_hours'] = 0;
        $workday['overtime'] = 0;

        $this->workdayModel->create($workday);
    }

    public function start($userId, $defaultWorktime)
    {
        $workday = $this->getByUser($userId);
        $workday->default_worktime = $defaultWorktime;
        $workday->start = Carbon::now()->addHours(2);
        $additionalHours = $this->additionalHoursService->listToday($workday['user_id']);
        $overtimes = $this->overtimesService->listToday($workday['user_id']);
        foreach ($additionalHours as $additionalHour) {
            $workday->additional_hours += $additionalHour->minutes;
        }
        foreach ($overtimes as $overtime) {
            $workday->overtime += $overtime->minutes;
        }
        $workday->save();
    }

    public function getByUser($userId)
    {
        $workday = $this->workdayModel->with("workPeriods")->filtrByUser($userId)->lastStarted()->first();
        if (!$workday) {
            $workday = $this->workdayModel->with("workPeriods")->filtrByUser($userId)->today()->first();
        }
        return $workday;
    }

    public function add($userId, $minutes, $type)
    {
        $workday = $this->getByUser($userId);
        if ($workday) {
            if ($type == 'Nadgodziny') {
                $workday->overtime += $minutes;
            } else {
                $workday->additional_hours += $minutes;
            }
            $workday->save();
        }
    }
}

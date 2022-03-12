<?php

namespace App\Services\WorkPeriods;

use App\Models\WorkPeriods\WorkPeriod;
use Carbon\Carbon;

class WorkPeriodService
{
    public WorkPeriod $workPeriodModel;

    public function __construct(WorkPeriod $workPeriodModel)
    {
        $this->workPeriodModel = $workPeriodModel;
    }

    public function getWorkPeriod($id)
    {
        return $this->workPeriodModel->find($id);
    }

    public function createWorkPeriod($workPeriod)
    {
        $this->workPeriodModel->create($workPeriod);
    }

    public function start($type, $workdayId)
    {
        $weekPeriod = ['type' => $type, 'start' => Carbon::now()->addHour(), 'weekday_id' => $workdayId];
        $this->createWorkPeriod($weekPeriod);
    }

    public function updateWorkPeriod($newWorkPeriod, $workPeriodId)
    {
        $workPeriod = $this->getWorkPeriod($workPeriodId);
        $workPeriod->update($newWorkPeriod);
    }

    public function stop($newWorkPeriod, $workdayId)
    {
        $newWorkPeriod['stop'] = Carbon::now()->addHour();
        $this->updateWorkPeriod($newWorkPeriod, $workdayId);
    }

    public function getLastWorkPeriod($workdayId)
    {
        return $this->workdayModel->filtrByWorkday($workdayId)->orderBy('day', 'desc')->limit(1)->get();
    }
}

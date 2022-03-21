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

    public function start($workPeriod)
    {
        $workPeriod['start'] = Carbon::now()->addHour();
        $this->createWorkPeriod($workPeriod);
    }

    public function updateWorkPeriod($newWorkPeriod, $workPeriodId)
    {
        $workPeriod = $this->getWorkPeriod($workPeriodId);
        $workPeriod->update($newWorkPeriod);
    }

    public function stop($newWorkPeriod, $workdayId)
    {
        $newWorkPeriod['stop'] = Carbon::now()->addHour();
        $newWorkPeriod['minutes'] = Carbon::create($newWorkPeriod['start'])->diffInMinutes(Carbon::now()->addHour());
        $this->updateWorkPeriod($newWorkPeriod, $workdayId);
    }

    public function getLastWorkPeriod($workdayId)
    {
        return $this->workdayModel->filtrByWorkday($workdayId)->orderBy('day', 'desc')->limit(1)->get();
    }
}

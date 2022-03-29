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

    public function get($id)
    {
        return $this->workPeriodModel->find($id);
    }

    public function create($workPeriod)
    {
        $this->workPeriodModel->create($workPeriod);
    }

    public function start($workPeriod)
    {
        $workPeriod['start'] = Carbon::now()->addHours(2);
        $this->create($workPeriod);
    }

    public function update($newWorkPeriod, $workPeriodId)
    {
        $workPeriod = $this->get($workPeriodId);
        $workPeriod->update($newWorkPeriod);
    }

    public function stop($newWorkPeriod, $workdayId)
    {
        $newWorkPeriod['stop'] = Carbon::now()->addHours(2);
        $newWorkPeriod['minutes'] = Carbon::create($newWorkPeriod['start'])->diffInMinutes(Carbon::now()->addHours(2));
        $this->update($newWorkPeriod, $workdayId);
    }

    public function getLast($workdayId)
    {
        return $this->workdayModel->filtrByWorkday($workdayId)->orderBy('day', 'desc')->limit(1)->get();
    }
}

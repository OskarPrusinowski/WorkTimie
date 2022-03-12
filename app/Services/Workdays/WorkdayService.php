<?php

namespace App\Services\Workdays;

use App\Models\Workdays\Workday;
use Carbon\Carbon;

class WorkdayService
{

    public Workday $workdayModel;

    protected $weekMap = [
        0 => 'Niedziela',
        1 => 'Poniedziałek',
        2 => 'Wtorek',
        3 => 'Środa',
        4 => 'Czwartek',
        5 => 'Piątek',
        6 => 'Sobota',
    ];

    public function __construct(Workday $workdayModel)
    {
        $this->workdayModel = $workdayModel;
    }

    public function createWorkday($workday)
    {
        $this->workdayModel->create($workday);
    }

    public function start($userId)
    {
        $data = ['day' => $this->weekMap[Carbon::now()->dayOfWeek], 'date' => Carbon::now()->addHour(), 'start' => Carbon::now()->addHour(), 'user_id' => $userId];
        $this->createWorkday($data);
    }

    public function getWorkday($id)
    {
        return $this->workdayModel->find($id);
    }

    public function updateWorkday($newWorkday, $workdayId)
    {
        $workday = $this->getWorkday($workdayId);
        $workday->update($newWorkday);
    }

    public function stop($workday, $workdayId)
    {
        $workday['stop'] = Carbon::now()->addHour();
        $this->updateWorkday($workday, $workdayId);
    }

    public function getByUser($userId)
    {
        return $this->workdayModel->filtrByUser($userId)->today()->limit(1)->get();
    }
}

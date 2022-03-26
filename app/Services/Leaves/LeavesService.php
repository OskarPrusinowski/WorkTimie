<?php

namespace App\Services\Leaves;

use App\Models\Leaves\Leave;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Carbon\Carbon;

class LeavesService
{

    public Leave $leaveModel;

    public function __construct(Leave $leaveModel)
    {
        $this->leaveModel = $leaveModel;
    }

    public function listByUser($userId)
    {
        return $this->leaveModel->byUser($userId)->get();
    }

    public function listByDate($date, $userName, $departmentId)
    {
        $userName = $userName ? $userName : "";
        if ($departmentId == 0) {
            return $this->leaveModel->with("user.department")
                ->whereHas('user', function (Builder $query) use ($userName) {
                    $query->userName($userName);
                })->get()->groupBy('user_id');
        }
        return $this->leaveModel->with("user.department")
            ->whereHas('user', function (Builder $query) use ($userName, $departmentId) {
                $query->userName($userName)->filtrDepartment($departmentId);
            })->get()->groupBy('user_id');
    }

    public function specialList($date, $userName, $departmentId)
    {
        $leaves = $this->listByDate($date, $userName, $departmentId);
        $allDays = $this->getAllDaysOfMonth($date);
        $specialList = [$allDays];
        $actualUserId = 0;
        $userDates = [];
        foreach ($leaves as $leave) {
            if ($leave[0]->user->id != $actualUserId) {
                $actualUserId = $leave[0]->user->id;
                if (count($userDates) != 0) {

                    $specialList[] = $userDates;
                }
                $userDates = [$leave[0]->user->name . " " . $leave[0]->user->surname, $leave[0]->user->department->name];
                foreach ($allDays as $day) {
                    $userDates[] = 0;
                }
            }
            if ($leave[0]->start) {
                $dateStart = (new Carbon($leave[0]->start));
                while ($dateStart <= $leave[0]->end) {
                    $userDates[$dateStart->day + 1]++;
                    $dateStart->addDay();
                }
                $userDates[$dateStart->day + 1]++;
            }
        }
        $specialList[] = $userDates;
        return $specialList;
    }

    public function list()
    {
        return $this->leaveModel->with("user")->get();
    }

    public function getAllDaysOfMonth($date)
    {
        $start = Carbon::parse($date)->startOfMonth();
        $end = Carbon::parse($date)->endOfMonth();
        $dates = [];
        while ($start->lte($end)) {
            $dates[] = $start->copy();
            $start->addDay();
        }
        return $dates;
    }
}

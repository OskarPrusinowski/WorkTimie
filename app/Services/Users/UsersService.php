<?php

namespace App\Services\Users;

use App\Models\Users\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Carbon\Carbon;

class UsersService
{
    public User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function list($name, $departmentId)
    {
        $name = $name ? $name : "";
        if ($departmentId != 0) {
            return $this->userModel->with("group")->with("department")->userName($name)->filtrDepartment($departmentId)->get();
        }
        return $this->userModel->with("group")->with("department")->userName($name)->get();
    }

    public function listWithFiltr($start, $stop, $name)
    {
        $name = $name ? $name : "";
        $users = $this->userModel->with("workdays")->userName($name)->whereHas('workdays', function (Builder $query) use ($start, $stop) {
            $query->between($start, $stop);
        })->get();
        return $users;
    }

    public function listAdmin()
    {
        return $this->userModel->admin()->get();
    }

    public function listLeaves($date, $userName, $departmentId)
    {
        $userName = $userName ? $userName : "";
        if ($departmentId == 0) {
            $users = $this->userModel->with("leaves")->with("department")->userName($userName)->whereHas('leaves', function (Builder $query) use ($date) {
                $query->month($date)->orderBy("start");
            })->get();
        } else {
            $users = $this->userModel->with("leaves")->with("department")->userName($userName)->filtrDepartment($departmentId)->whereHas('leaves', function (Builder $query) use ($date) {
                $query->month($date)->orderBy("start");
            })->get();
        }
        return $users;
    }

    public function specialListLeaves($date, $userName, $departmentId)
    {
        $users = $this->listLeaves($date, $userName, $departmentId);
        $days = $this->getAllDaysOfMonth($date);
        $data = [$days];
        $counterDates = count($days);
        foreach ($users as $user) {
            $userData = [$user->name . " " . $user->surname, $user->department->name];
            for ($i = 0; $i < $counterDates; $i++) {
                $userData[] = 0;
            }
            $leaves = $user->leaves;
            foreach ($leaves as $leave) {
                $end = (new Carbon($leave->end))->addDay();
                $dateStart = Carbon::parse($leave->start);
                while ($dateStart <= $end) {
                    dump($dateStart);
                    dump($end);
                    $userData[(int)($dateStart->format('d')) + 1] = 1;
                    $dateStart->addDay();
                }
            }
            $data[] = $userData;
        }
        return $data;
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

    public function listAll()
    {
        return $this->userModel->get();
    }

    public function listCannMakeHolidaysUp()
    {
        return $this->userModel->whereHas('group', function (Builder $query) {
            $query->where('can_make_holidays_up', 1);
        })->get();
    }

    public function increaseCounterHolidays()
    {
        $users = $this->listCannMakeHolidaysUp();
        foreach ($users as $user) {
            $user->current_counter_holidays++;
            $user->save();
        }
    }
}

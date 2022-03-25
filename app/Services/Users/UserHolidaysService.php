<?php

namespace App\Services\Users;

use App\Models\Users\User;
use App\Services\Holidays\HolidaysService;
use App\Services\Users\UserService;
use Carbon\Carbon;

class UserHolidaysService
{

    public UserService $userService;
    public HolidaysService $holidaysService;

    public function __construct(UserService $userService, HolidaysService $holidaysService)
    {
        $this->userService = $userService;
        $this->holidaysService = $holidaysService;
    }

    public function updateHolidaysCounter($userId)
    {
        $user = $this->userService->getUser($userId);
        $holidays = $this->holidaysService->list(Carbon::now()->year);
        $leave = $user->leaves->last();
        foreach ($holidays as $holiday) {
            if ($holiday->date > $leave->start && $holiday->date < $leave->end) {
                $user->current_counter_holidays++;
            }
        }
        $date = new Carbon($leave->start);
        for ($date; $date < $leave->end; $date->addDay()) {
            if ($date->dayOfWeek == 0 || $date->dayOfWeek == 6) {
                $user->current_counter_holidays++;
            }
        }
        $user->current_counter_holidays -= (new Carbon($leave->end))->diff((new Carbon($leave->start)))->days + 1;
        $user->save();
    }
}

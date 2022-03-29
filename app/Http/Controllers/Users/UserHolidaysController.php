<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\Users\UserHolidaysService;
use Illuminate\Http\Request;

class UserHolidaysController extends Controller
{
    public UserHolidaysService $userHolidaysService;

    public function __construct(UserHolidaysService $userHolidaysService)
    {
        $this->userHolidaysService = $userHolidaysService;
        $this->middleware("permission:holidaysShow");
        $this->middleware("permission:holidaysManage");
    }

    public function updateHolidaysCounter($userId)
    {
        $this->userHolidaysService->updateHolidaysCounter($userId);
    }
}

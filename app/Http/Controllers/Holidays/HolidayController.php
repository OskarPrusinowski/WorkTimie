<?php

namespace App\Http\Controllers\Holidays;

use App\Http\Controllers\Controller;
use App\Services\Holidays\HolidayService;
use Illuminate\Http\Request;
use App\Http\Requests\Holidays\CreateHoliday;

class HolidayController extends Controller
{
    public HolidayService $holidayService;

    public function __construct(HolidayService $holidayService)
    {
        $this->holidayService = $holidayService;
        $this->middleware("permission:holidaysShow");
        $this->middleware("permission:holidaysManage");
    }

    public function create(CreateHoliday $request)
    {
        $this->holidayService->createHoliday($request->get("holiday"));
    }

    public function destroy($id)
    {
        $this->holidayService->deleteHoliday($id);
    }
}

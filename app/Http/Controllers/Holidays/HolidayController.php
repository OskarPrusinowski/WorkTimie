<?php

namespace App\Http\Controllers\Holidays;

use App\Http\Controllers\Controller;
use App\Services\Holidays\HolidayService;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public HolidayService $holidayService;

    public function __construct(HolidayService $holidayService)
    {
        $this->holidayService = $holidayService;
        $this->middleware("permission:holidaysShow");
        $this->middleware("permission:holidaysManage");
    }

    public function create(Request $request)
    {
        $this->holidayService->createHoliday($request->get("holiday"));
    }

    public function destroy($id)
    {
        $this->holidayService->deleteHoliday($id);
    }
}

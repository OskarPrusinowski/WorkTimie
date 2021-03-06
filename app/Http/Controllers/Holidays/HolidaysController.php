<?php

namespace App\Http\Controllers\Holidays;

use App\Http\Controllers\Controller;
use App\Services\Holidays\HolidaysService;
use Illuminate\Http\Request;
use App\Http\Requests\Holidays\FiltrHolidays;

class HolidaysController extends Controller
{
    public HolidaysService $holidaysService;

    public function __construct(HolidaysService $holidaysService)
    {
        $this->holidaysService = $holidaysService;
        $this->middleware("permission:holidaysManage");
    }

    public function list(FiltrHolidays $request)
    {
        $holidays = $this->holidaysService->list($request->date);
        return response()->json(['holidays' => $holidays]);
    }

    public function freeSaturday(Request $request)
    {
        $this->holidaysService->freeSaturdays($request->date, $request->freeSaturday);
    }
}

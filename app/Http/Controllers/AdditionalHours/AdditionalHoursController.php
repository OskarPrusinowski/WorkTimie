<?php

namespace App\Http\Controllers\AdditionalHours;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdditionalHours\AdditionalHoursService;

class AdditionalHoursController extends Controller
{
    public AdditionalHoursService $additionalHoursService;

    public function __construct(AdditionalHoursService $additionalHoursService)
    {
        $this->additionalHoursService = $additionalHoursService;
        $this->middleware("permission:additionalHoursShow");
    }

    public function listByUser($userId)
    {
        $additionalHour = $this->additionalHoursService->listToday($userId);
        return response()->json(['additionalHours' => $additionalHour]);
    }
}

<?php

namespace App\Http\Controllers\AdditionalHours;

use App\Http\Controllers\Controller;
use App\Services\AdditionalHours\AdditionalHourService;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Http\Requests\AdditionalHours\CreateAdditionalHour;

class AdditionalHourController extends Controller
{
    public AdditionalHourService $additionalHourService;

    public function __construct(AdditionalHourService $additionalHourService)
    {
        $this->additionalHourService = $additionalHourService;
        $this->middleware("permission:additionalHoursShow");
        $this->middleware("permission:additionalHoursMange");
    }

    public function create(CreateAdditionalHour $request)
    {
        $this->additionalHourService->createAdditionalHour($request->get("additionalHour"));
    }

    public function show($id)
    {
        $additionalHour = $this->additionalHourService->getAdditionalHour($id);
        return response()->json(['additionalHour' => $additionalHour]);
    }

    public function showByUser($userId)
    {
        $additionalHour = $this->additionalHourService->getAdditionalHourByUser($userId);
        return response()->json(['additionalHour' => $additionalHour]);
    }
}

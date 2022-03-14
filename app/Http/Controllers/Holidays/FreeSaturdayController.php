<?php

namespace App\Http\Controllers\Holidays;

use App\Http\Controllers\Controller;
use App\Services\Holidays\FreeSaturdayService;
use Illuminate\Http\Request;

class FreeSaturdayController extends Controller
{
    public FreeSaturdayService $freeSaturdayService;

    public function __construct(FreeSaturdayService $freeSaturdayService)
    {
        $this->freeSaturdayService = $freeSaturdayService;
    }

    public function change($id)
    {
        $this->freeSaturdayService->changeFreeStaruday($id);
    }
}

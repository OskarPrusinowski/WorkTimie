<?php

namespace App\Http\Controllers\Holidays;

use App\Http\Controllers\Controller;
use App\Services\Holidays\FreeSaturdaysService;
use Illuminate\Http\Request;

class FreeSaturdaysController extends Controller
{
    public FreeSaturdaysService $freeSaturdaysService;

    public function __construct(FreeSaturdaysService $freeSaturdaysService)
    {
        $this->freeSaturdaysService = $freeSaturdaysService;
    }

    public function list()
    {
        $freeSaturdays = $this->freeSaturdaysService->list();
        return response()->json(['freeSaturdays' => $freeSaturdays]);
    }
}

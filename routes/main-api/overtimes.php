<?php

use App\Http\Controllers\Overtimes\OvertimeController;
use App\Http\Controllers\Overtimes\OvertimesController;
use Illuminate\Support\Facades\Route;


Route::post('/create', [OvertimeController::class, "create"]);
Route::get("/listToday/{userId}", [OvertimesController::class, "listToday"]);

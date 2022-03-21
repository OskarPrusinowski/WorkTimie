<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WorkPeriods\WorkPeriodController;

Route::post('/start', [WorkPeriodController::class, 'start']);
Route::put('/stop/{workdayId}', [WorkPeriodController::class, 'stop']);
Route::get('/getLastWorkPeriod/{workdayId}', [WorkPeriodController::class, 'getLastWorkPeriod']);

<?php

use App\Http\Controllers\Workdays\WorkdayController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Workdays\WorkdaysController;

Route::get('/list/{userId}', [WorkdaysController::class, 'list']);

Route::post('start/{userId}', [WorkdayController::class, 'start']);
Route::put('stop/{workdayId}', [WorkdayController::class, 'stop']);
Route::put('update/{workdayId}', [WorkdayController::class, 'update']);
Route::get('getByUser/{userId}', [WorkdayController::class, 'getByUser']);

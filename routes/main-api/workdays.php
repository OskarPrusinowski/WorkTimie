<?php

use App\Http\Controllers\Workdays\WorkdayController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Workdays\WorkdaysController;

Route::get('/list/{userId}', [WorkdaysController::class, 'list']);
Route::get('listAnother/{userId}', [WorkdaysController::class, 'listAnother']);

Route::put('start', [WorkdayController::class, 'start']);
Route::put('stop/{workdayId}', [WorkdayController::class, 'stop']);
Route::put('update/{workdayId}', [WorkdayController::class, 'update']);
Route::get('getByUser/{userId}', [WorkdayController::class, 'getByUser']);
Route::put('add/{userId}', [WorkdayController::class, 'add']);

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Holidays\HolidaysController;
use App\Http\Controllers\Holidays\HolidayController;

use App\Http\Controllers\Holidays\FreeSaturdaysController;
use App\Http\Controllers\Holidays\FreeSaturdayController;

Route::get('/list', [HolidaysController::class, 'list']);
Route::post('/freeSaturdays', [HolidaysController::class, 'freeSaturday']);

Route::post('/create', [HolidayController::class, 'create']);
Route::delete('/delete/{id}', [HolidayController::class, 'destroy']);


Route::get('/freeSaturdays/list', [FreeSaturdaysController::class, 'list']);

Route::put('/freeSaturdays/change/{id}', [FreeSaturdayController::class, 'change']);

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Holidays\HolidaysController;
use App\Http\Controllers\Holidays\HolidayController;


Route::get('/list', [HolidaysController::class, 'list']);
Route::post('/freeSaturdays', [HolidaysController::class, 'freeSaturday']);

Route::post('/create', [HolidayController::class, 'create']);
Route::delete('/delete/{id}', [HolidayController::class, 'destroy']);

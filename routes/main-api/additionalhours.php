<?php

use App\Http\Controllers\AdditionalHours\AdditionalHourController;
use App\Http\Controllers\AdditionalHours\AdditionalHoursController;
use Illuminate\Support\Facades\Route;

Route::post('/create', [AdditionalHourController::class, 'create']);
Route::get('/show/{id}', [AdditionalHourController::class, 'show']);
Route::get('/listToday/{userid}', [AdditionalHoursController::class, 'listToday']);

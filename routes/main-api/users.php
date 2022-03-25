<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\UserHolidaysController;

Route::get('/list', [UsersController::class, 'list']);
Route::get('/listWithFiltr', [UsersController::class, 'listWithFiltr']);
Route::get("listLeaves", [UsersController::class, 'listLeaves']);
Route::put("increaseCounterHolidays", [UsersController::class, 'increaseCounterHolidays']);

Route::get('/show/{id}', [UserController::class, 'show']);
Route::delete('/delete/{id}', [UserController::class, 'destroy']);
Route::put('/update/{id}', [UserController::class, 'update']);
Route::post('/create', [UserController::class, 'create']);

Route::put('updateHolidaysCounter/{userId}', [UserHolidaysController::class, 'updateHolidaysCounter']);

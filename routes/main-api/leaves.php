<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Leaves\LeaveController;
use App\Http\Controllers\Leaves\LeavesController;

Route::get('listByUser/{userId}', [LeavesController::class, 'listByUser']);
Route::get('listByDate', [LeavesController::class, 'listByDate']);
Route::get('list', [LeavesController::class, 'list']);

Route::post('create', [LeaveController::class, 'create']);

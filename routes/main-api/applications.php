<?php

use App\Http\Controllers\Applications\ApplicationsController;
use App\Http\Controllers\Applications\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/list', [ApplicationsController::class, 'list']);


Route::get('/show/{id}', [ApplicationController::class, 'show']);
Route::post('/create', [ApplicationController::class, 'create']);
Route::put('/update/{id}', [ApplicationController::class, 'update']);
Route::put('/consider/{id}', [ApplicationController::class, 'consider']);

<?php

use App\Http\Controllers\Groups\GroupController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Groups\GroupsController;

Route::get('/list', [GroupsController::class, 'list']);

Route::get('/show/{id}', [GroupController::class, 'show']);

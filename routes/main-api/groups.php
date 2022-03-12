<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Groups\GroupsController;

Route::get('/list', [GroupsController::class, 'list']);

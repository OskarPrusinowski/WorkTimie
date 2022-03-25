<?php

use App\Http\Controllers\Departments\DepartmentsController;
use Illuminate\Support\Facades\Route;


Route::get('list', [DepartmentsController::class, 'list']);

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Users\UserController;

Route::get('/list', [UsersController::class, 'list']);

Route::get('/show/{id}', [UserController::class, 'show']);
Route::delete('/delete/{id}', [UserController::class, 'destroy']);
Route::put('/update/{id}', [UserController::class, 'update']);
Route::post('/create', [UserController::class, 'create']);

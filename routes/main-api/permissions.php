<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\PermissionsController;


Route::get('/{id}', [PermissionsController::class, 'getPermissions']);

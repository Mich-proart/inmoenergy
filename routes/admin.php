<?php

use App\Http\Controllers\Admin\FormalityController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::resource('/roles', RoleController::class)->names('admin.roles');

Route::resource('/formality', FormalityController::class)->names('admin.formality');
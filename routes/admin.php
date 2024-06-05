<?php

use App\Http\Controllers\Admin\Formality\CreateFormalityController;
use App\Http\Controllers\Admin\Formality\InProgressFormalityController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::resource('/roles', RoleController::class)->names('admin.roles');

Route::prefix('formality')->group(function () {
    Route::get('/create', [CreateFormalityController::class, 'index'])->name('admin.formality.create');
    Route::get('/inprogress', [InProgressFormalityController::class, 'index'])->name('admin.formality.inprogress');

});
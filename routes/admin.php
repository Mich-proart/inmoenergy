<?php

use App\Http\Controllers\Admin\Formality\ClosedFormalityController;
use App\Http\Controllers\Admin\Formality\CreateFormalityController;
use App\Http\Controllers\Admin\Formality\InProgressFormalityController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Formality\FormalityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::resource('/roles', RoleController::class)->names('admin.roles');
Route::group(['prefix' => 'api'], function () {
    Route::resource('/formality', FormalityController::class)->names('api.formality')->except(['create']);
});

Route::prefix('formality')->group(function () {
    Route::get('/create', [CreateFormalityController::class, 'index'])->name('admin.formality.create');
    Route::get('/inprogress', [InProgressFormalityController::class, 'index'])->name('admin.formality.inprogress');
    Route::get('/closed', [ClosedFormalityController::class, 'index'])->name('admin.formality.closed');
    Route::get('/assigned', function () {
        return view('admin.formality.assigned');
    })->name('admin.formality.assigned');
    Route::get('/completed', function () {
        return view('admin.formality.completed');
    })->name('admin.formality.completed');

});
<?php

use App\Http\Controllers\Admin\Formality\FormalityAdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Formality\FormalityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::resource('/roles', RoleController::class)->names('admin.roles');
Route::group(['prefix' => 'api'], function () {
    Route::get('/formality/pending', [FormalityController::class, 'getPending'])->name('api.formality.activation.pending');
    Route::resource('/formality', FormalityController::class)->names('api.formality')->except(['create']);
});

Route::prefix('formality')->group(function () {
    Route::get('/create', [FormalityAdminController::class, 'create'])->name('admin.formality.create');
    Route::get('/{id}/edit', [FormalityAdminController::class, 'edit'])->name('admin.formality.edit');
    Route::get('/{id}/view', [FormalityAdminController::class, 'get'])->name('admin.formality.get');
    Route::get('/{id}/modify', [FormalityAdminController::class, 'modify'])->name('admin.formality.modify');
    Route::get('/inprogress', function () {
        return view('admin.formality.inprogress');
    })->name('admin.formality.inprogress');
    Route::get('/closed', function () {
        return view('admin.formality.closed');
    })->name('admin.formality.closed');
    Route::get('/assigned', function () {
        return view('admin.formality.assigned');
    })->name('admin.formality.assigned');
    Route::get('/completed', function () {
        return view('admin.formality.completed');
    })->name('admin.formality.completed');
    Route::get('/pending', function () {
        return view('admin.formality.pending');
    })->name('admin.formality.pending');
    Route::get('/assignment', function () {
        return view('admin.formality.assignment');
    })->name('admin.formality.assignment');

});
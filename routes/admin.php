<?php

use App\Http\Controllers\Admin\Formality\FormalityAdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\User\UserAdminController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Formality\FormalityController;
use App\Http\Controllers\User\UserConntroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::resource('/roles', RoleController::class)->names('admin.roles');
Route::group(['prefix' => 'api'], function () {
    Route::get('/formality/pending', [FormalityController::class, 'getPending'])->name('api.formality.activation.pending');
    Route::resource('/formality', FormalityController::class)->names('api.formality')->except(['create']);
    Route::get('/user', [UserConntroller::class, 'index'])->name('api.user.query');
    Route::get('/company', [CompanyController::class, 'index'])->name('api.company.query');
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
    Route::get('/total', function () {
        return view('admin.formality.totalInProgress');
    })->name('admin.formality.totalInProgress');

});

Route::prefix('users')->group(function () {
    Route::get('/', function () {
        return view('admin.user.users');
    })->name('admin.users');
    Route::get('/client', function () {
        return view('admin.user.clients');
    })->name('admin.clients');
    Route::get('/create', [UserConntroller::class, 'create'])->name('admin.users.create');
    Route::get('/{id}/edit/', [UserAdminController::class, 'edit'])->name('admin.users.edit');
});
Route::prefix('company')->group(function () {
    Route::get('/', function () {
        return view('admin.company.manager');
    })->name('admin.company.manager');
});
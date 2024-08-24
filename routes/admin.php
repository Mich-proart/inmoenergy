<?php
use App\Http\Controllers\Admin\Company\CompanyAdminController;
use App\Http\Controllers\Admin\Config\ComponentAdminController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Configuration\ComponentController;
use App\Http\Controllers\User\UserConntroller;
use App\Http\Controllers\Admin\User\UserAdminController;
/*
use App\Http\Controllers\Admin\Formality\FormalityAdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Formality\FormalityController;
*/
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;

Route::get('/', [HomeController::class, 'index']);

//Route::resource('/roles', RoleController::class)->names('admin.roles');
Route::group(['prefix' => 'api'], function () {
    /*
    Route::get('/formality/pending', [FormalityController::class, 'getPending'])->name('api.formality.activation.pending');
    Route::get('/formality/info', [FormalityController::class, 'infoFormality'])->name('api.formality.info');
    Route::resource('/formality', FormalityController::class)->names('api.formality')->except(['create']);
    */
    Route::get('/user', [UserConntroller::class, 'index'])->name('api.user.query');
    Route::get('/company', [CompanyController::class, 'index'])->name('api.company.query');
    Route::get('/product', [ProductController::class, 'index'])->name('api.product.query');
    Route::get('/component', [ComponentController::class, 'index'])->name('api.component.query');
    Route::get('/component/options', [ComponentController::class, 'options'])->name('api.component.options.query');
    Route::get('/component/business', [ComponentController::class, 'business'])->name('api.component.business.query');
    Route::get('/component/offices', [ComponentController::class, 'offices'])->name('api.component.offices.query');
});
/*
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

*/
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
    Route::get('/{id}/details', [CompanyAdminController::class, 'details'])->name('admin.company.manager.details');
});
Route::prefix('product')->group(function () {
    Route::get('/', function () {
        return view('admin.product.manager');
    })->name('admin.product.manager');
    Route::get('/{id}/details', [CompanyAdminController::class, 'details'])->name('admin.company.manager.details');
});
Route::prefix('config')->group(function () {
    Route::prefix('component')->group(function () {
        Route::get('/', function () {
            return view('admin.config.component');
        })->name('admin.config.component');
        Route::get('/{id}/details', [ComponentAdminController::class, 'details'])->name('admin.component.details');
        Route::get('/business', function () {
            return view('admin.config.businessGroup');
        })->name('admin.config.businessGroup');
        Route::get('/{id}/offices', [ComponentAdminController::class, 'buinessDetails'])->name('admin.config.offices');
        Route::get('/documents', [ComponentAdminController::class, 'docsManager'])->name('admin.config.documents');
        Route::get('/documents/{id}/download', [ComponentAdminController::class, 'donwload'])->name('admin.documents.download');
    });
});

Route::prefix('documents')->group(function () {
    Route::get('/auth', [ComponentAdminController::class, 'docsAuth'])->name('admin.document.authorization');
    Route::get('/change', [ComponentAdminController::class, 'docsChange'])->name('admin.document.changeTitle');
});

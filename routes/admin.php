<?php
use App\Http\Controllers\Admin\Company\CompanyAdminController;
use App\Http\Controllers\Admin\Config\ComponentAdminController;
use App\Http\Controllers\Admin\Formality\FormalityApiController;
use App\Http\Controllers\Admin\Role\RoleAdminController;
use App\Http\Controllers\Admin\Role\RoleApiController;
use App\Http\Controllers\Admin\Ticket\TicketAdminController;
use App\Http\Controllers\Admin\Ticket\TicketApiController;
use App\Http\Controllers\Admin\Tool\ToolAdminController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Configuration\ComponentController;
use App\Http\Controllers\User\UserConntroller;
use App\Http\Controllers\Admin\User\UserAdminController;
use App\Http\Controllers\Admin\Formality\FormalityAdminController;



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');


Route::group(['prefix' => 'api'], function () {
    Route::get('/formality/inprogress', [FormalityApiController::class, 'getInProgress'])->name('api.formality.inprogress');
    Route::get('/formality/closed', [FormalityApiController::class, 'getClosed'])->name('api.formality.closed');
    Route::get('/formality/assigned', [FormalityApiController::class, 'getAssigned'])->name('api.formality.assigned');
    Route::get('/formality/completed', [FormalityApiController::class, 'getCompleted'])->name('api.formality.completed');
    Route::get('/formality/pending', [FormalityApiController::class, 'getPending'])->name('api.formality.pending');
    Route::get('/formality/assignment', [FormalityApiController::class, 'getAssignment'])->name('api.formality.assignment');
    Route::get('/formality/total/inprogress', [FormalityApiController::class, 'getTotalInprogress'])->name('api.formality.totalInprogress');
    Route::get('/formality/total/closed', [FormalityApiController::class, 'getTotalClosed'])->name('api.formality.totalClosed');


    Route::get('/ticket/pending', [TicketApiController::class, 'getPending'])->name('api.ticket.pending');
    Route::get('/ticket/resolved', [TicketApiController::class, 'getResolved'])->name('api.ticket.resolved');
    Route::get('/ticket/assigned', [TicketApiController::class, 'getAssigned'])->name('api.ticket.assigned');


    Route::get('/user', [UserConntroller::class, 'index'])->name('api.user.query');
    Route::get('/company', [CompanyController::class, 'index'])->name('api.company.query');
    Route::get('/product', [ProductController::class, 'index'])->name('api.product.query');
    Route::get('/component', [ComponentController::class, 'index'])->name('api.component.query');
    Route::get('/component/options', [ComponentController::class, 'options'])->name('api.component.options.query');
    Route::get('/component/business', [ComponentController::class, 'business'])->name('api.component.business.query');
    Route::get('/component/offices', [ComponentController::class, 'offices'])->name('api.component.offices.query');

    Route::get('/role', [RoleApiController::class, 'getRoles'])->name('api.role.query');

});
Route::prefix('formality')->group(function () {
    Route::get('/create', [FormalityAdminController::class, 'create'])->name('admin.formality.create');
    Route::get('/{id}/edit', [FormalityAdminController::class, 'edit'])->name('admin.formality.edit');
    Route::get('/{id}/view', [FormalityAdminController::class, 'get'])->name('admin.formality.get');
    Route::get('/inprogress', [FormalityAdminController::class, 'getInProgress'])->name('admin.formality.inprogress');
    Route::get('/closed', [FormalityAdminController::class, 'getClosed'])->name('admin.formality.closed');
    Route::get('/assigned', [FormalityAdminController::class, 'getAssigned'])->name('admin.formality.assigned');
    Route::get('/{id}/modify', [FormalityAdminController::class, 'modify'])->name('admin.formality.modify');
    Route::get('/completed', [FormalityAdminController::class, 'getCompleted'])->name('admin.formality.completed');
    Route::get('/{id}/completed', [FormalityAdminController::class, 'viewCompleted'])->name('admin.formality.get.completed');
    Route::get('/pending', [FormalityAdminController::class, 'getPending'])->name('admin.formality.pending');
    Route::get('/assignment', [FormalityAdminController::class, 'getAssignment'])->name('admin.formality.assignment');
    Route::get('/total', [FormalityAdminController::class, 'getTotalInProgress'])->name('admin.formality.totalInProgress');
    Route::get('/extract', [FormalityAdminController::class, 'getExtract'])->name('admin.formality.extract');
    Route::get('/data', [FormalityAdminController::class, 'getData'])->name('admin.formality.data');
    Route::get('/total/closed', [FormalityAdminController::class, 'getTotalClosed'])->name('admin.formality.total.closed');
    Route::get('/assignment/renovation', [FormalityAdminController::class, 'getAssignmentRenovation'])->name('admin.formality.assignment.renovation');
    Route::get('/export/csv', [FormalityAdminController::class, 'exportCSV'])->name('admin.formality.exportCSV');
    Route::get('/export/excel', [FormalityAdminController::class, 'exportExcel'])->name('admin.formality.exportExcel');
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserAdminController::class, 'getManageUsers'])->name('admin.users');
    Route::get('/client', [UserAdminController::class, 'getManageClients'])->name('admin.clients');
    Route::get('/create', [UserAdminController::class, 'create'])->name('admin.users.create');
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


Route::prefix('roles')->group(function () {
    Route::get('/', [RoleAdminController::class, 'index'])->name('admin.roles.index');
    Route::get('/{id}/edit', [RoleAdminController::class, 'edit'])->name('admin.roles.edit');
});

Route::prefix('tickets')->group(function () {
    Route::get('/create', [TicketAdminController::class, 'create'])->name('admin.ticket.create');
    Route::get('/pending', [TicketAdminController::class, 'getPending'])->name('admin.ticket.pending');
    Route::get('/assigned', [TicketAdminController::class, 'getAssigned'])->name('admin.ticket.assigned');
    Route::get('/assignment', [TicketAdminController::class, 'getAssignment'])->name('admin.ticket.assignment');
    Route::get('/closed', [TicketAdminController::class, 'getClosed'])->name('');
    Route::get('/resolved', [TicketAdminController::class, 'getResolved'])->name('admin.ticket.resolved');
    Route::get('/total/closed', [TicketAdminController::class, 'getTotalClosed'])->name('admin.ticket.total.closed');
    Route::get('/total/pending', [TicketAdminController::class, 'getTotalPending'])->name('admin.ticket.total.pending');
});

Route::prefix('tool')->group(function () {
    Route::get('/statistics/client', [ToolAdminController::class, 'getStatisticsClient'])->name('admin.tool.statistics.client');
    Route::get('/statistics/worker', [ToolAdminController::class, 'getStatisticsWorker'])->name('admin.tool.statistics.worker');
});

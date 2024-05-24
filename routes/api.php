<?php

use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Role\RoleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get("/role", [RoleController::class, 'index']);
});


// TODO: Move this to a the bellow router group
Route::get("/address", [AddressController::class, 'getProvinces']);
Route::get("/address/street", [AddressController::class, 'getStreetTypes']);
Route::get("/address/{provinceId}", [AddressController::class, 'getLocations']);

Route::post("/test", [TestController::class, 'index']);
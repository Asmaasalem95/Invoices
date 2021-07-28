<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->group(function ()
{
    Route::post('login', [\Modules\User\Http\Controllers\LoginController::class,'login'])->name('login');
    Route::middleware(['auth:sanctum','can:isAdmin'])->group(function () {
        Route::resource('companies', \Modules\Company\Http\Controllers\CompanyController::class)->only('store', 'index');
        Route::resource('invoices', \Modules\Invoice\Http\Controllers\InvoiceController::class)->only('store','index');

    });
});

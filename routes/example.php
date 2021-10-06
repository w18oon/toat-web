<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Example\Ajax\UserController as AjaxUserController;
use App\Http\Controllers\Example\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {
    Route::get('users', [AjaxUserController::class, 'index'])->name('users.index');
});


Route::prefix('users')->name('users.')->group(function () {
    Route::get('/export-excel', [UserController::class, 'exportExcel'])->name('export-excel');
    Route::get('/export-pdf', [UserController::class, 'exportPdf'])->name('export-pdf');
    Route::get('/{user}/interface', [UserController::class, 'interface'])->name('interface');
    Route::get('/interface-error', [UserController::class, 'interfaceError'])->name('interface-error');
});

Route::resource('users', UserController::class);
Route::get('vue', function () {
    return view('example.vue');
})->name('vue');

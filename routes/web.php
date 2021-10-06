<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;


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



// Route::namespace('Example')->prefix('example')->name('example.')->group(function () {
//     Route::namespace('Ajax')->prefix('ajax')->name('ajax.')->group(function () {
//         Route::get('users', [UserController::class, 'index'])->name('users.index');
//     });
// });







Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('home.index');
        return view('welcome');
    });

    Route::resource('menus', MenuController::class)->only([
        'index', 'create', 'store', 'edit', 'update'
    ]);
    Route::get('users/{user}/permissions', [UserController::class, 'permissions'])->name('users.permissions');
    Route::post('users/{user}/assign-permission', [UserController::class, 'assignPermission'])->name('users.assign-permission');
    Route::resource('users', UserController::class)->only([
        'index', 'create', 'store', 'edit', 'update'
    ]);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});



Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Auth::routes();

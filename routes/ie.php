<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IE\Settings\LocationController;
use App\Http\Controllers\IE\Settings\CategoriesController;
use App\Http\Controllers\IE\Settings\SubCategoryController;
use App\Http\Controllers\IE\Settings\SubCategoryInfoController;
use App\Http\Controllers\IE\Settings\PolicyController;
use App\Http\Controllers\IE\Settings\PolicyRateController;
use App\Http\Controllers\IE\Ajax\IconController;

use App\Http\Controllers\IE\ReimbursementController;

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
    Route::get('icon/', [IconController::class, 'index'])->name("icon.index");
});


    /////////////////////
    //// REIMBURSEMENT
    Route::prefix('reimbursements')->name('reimbursements.')->group(function () {
        Route::get('/pending', [ReimbursementController::class, 'indexPending'])->name('index-pending');
        Route::resource('/', ReimbursementController::class)->only([
            'index', 'create','update','show'
        ])->parameters(['' => 'reimbursement']);

        Route::post('store', [ReimbursementController::class, 'store'])->name('store');
        Route::post('export', [ReimbursementController::class, 'export'])->name('export');
    });

    //////////////
    //// SETTING
    Route::prefix('settings')->name('settings.')->group(function () {

        Route::post('locations/inactive', [LocationController::class, 'inactive'])->name("locations.inactive");
        Route::resource('locations', LocationController::class)->only([
            'index', 'create', 'store', 'edit', 'update'
        ]);

        // REIM Categories
        Route::resource('categories', CategoriesController::class)->only([
            'index', 'create', 'store', 'edit', 'update'
        ]);
        Route::post('categories/{category}/remove', [CategoriesController::class, 'remove'])->name("categories.remove");


        Route::group(['prefix'=>'categories/{category}'], function () {
            // Sub-Categories
            Route::get('sub_categories/input_sub_account_code/', [SubCategoryController::class, 'inputSubAccountCode'])->name("input_sub_account_code");
            Route::resource('sub-categories', SubCategoryController::class);
            Route::group(['prefix'=>'sub-categories/{sub_category}'], function () {

                // Sub-Categories Info.
                Route::group(['as'=>'sub-categories.'], function () {
                    Route::resource('infos', SubCategoryInfoController::class);
                    Route::get('/input_form_type/{input_form_type}', [SubCategoryInfoController::class, 'inputFormType'])
                                ->name("input_form_type");
                    Route::group(['prefix'=>'infos/{info}', 'as'=>'infos.'], function () {
                        // Sub-Categories Info. Inactive
                        Route::post('/inactive', [SubCategoryInfoController::class, 'inactive'])
                                    ->name("inactive");
                    });
                });

                // Policy
                Route::resource('policies', PolicyController::class,
                    ['only' => ['index', 'create', 'store']]);
                Route::group(['prefix'=>'policies/{policy}', 'as'=>'policies.'], function () {
                    // Policy Inactive
                    Route::post('/inactive', [PolicyController::class, 'inactive'])
                                ->name("inactive");

                    Route::resource('rates', PolicyRateController::class);
                    Route::group(['prefix'=>'rates/{rate}', 'as'=>'rates.'], function () {
                        // Policy Rate Inactive
                        Route::post('/inactive', [PolicyRateController::class, 'inactive'])
                                    ->name("inactive");
                    });

                });

            });
        });
        // Route::post('categories/{category}/remove', 'CategoriesController@remove')->name("categories.remove");
    });




        // Route::resource('locations', 'LocationController',['only'=>['index', 'create', 'store', 'edit', 'update']]);
        // Route::post('locations/inactive', 'LocationController@inactive')
        //                             ->name("locations.inactive");

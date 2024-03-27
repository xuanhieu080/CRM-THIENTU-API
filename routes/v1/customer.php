<?php

use App\V1\API\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

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

//Route::group(['prefix' => 'customers'], function () {
    Route::delete('customers', [CustomerController::class, 'deleteIds']);
    Route::get('customers/my-contacts', [CustomerController::class, 'myContact']);
    Route::get('customers/unassigned-contacts', [CustomerController::class, 'unassignedContact']);
    Route::resource('customers', CustomerController::class);
//});



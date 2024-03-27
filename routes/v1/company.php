<?php

use App\V1\API\Controllers\CompanyController;
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
Route::get('companies/my-contacts', [CompanyController::class, 'myContact']);

Route::resource('companies', CompanyController::class);
//});



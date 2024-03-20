<?php

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
Route::group(['prefix' => 'v1'], function () {
    require __DIR__ . '/auth.php';
    Route::group(['middleware' => 'auth:sanctum'], function () {
        require __DIR__ . '/customer.php';
        require __DIR__ . '/service.php';
        require __DIR__ . '/contact_funnel.php';
        require __DIR__ . '/contact_source.php';
        require __DIR__ . '/deal_stage.php';
        require __DIR__ . '/lead_status.php';
    });
});

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
    Route::get('services', [\App\V1\API\Controllers\ServiceController::class, 'index']);
    Route::post('customers/register', [\App\V1\API\Controllers\CustomerController::class, 'register']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        require __DIR__ . '/customer.php';
        require __DIR__ . '/service.php';
        require __DIR__ . '/contact_funnel.php';
        require __DIR__ . '/contact_source.php';
        require __DIR__ . '/deal_stage.php';
        require __DIR__ . '/lead_status.php';
        require __DIR__ . '/user.php';
        require __DIR__ . '/industry.php';
        require __DIR__ . '/company.php';
    });
});

<?php

use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Session\Middleware\StartSession;

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

Route::controller(UserController::class)->middleware('api')->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/varify/user', 'varify_user')->name('varify.user');
    Route::delete('{id}/logout', 'logout');
});

Route::controller(PaymentController::class)->group(function () {
    Route::post('pay', 'pay')->name('payment');
    // Route::get('success', 'success');
    // Route::get('error', 'error');
});

Route::middleware('auth:api')->group(function () {
    Route::post('user/update/{id}', [UserController::class, 'update']);
});

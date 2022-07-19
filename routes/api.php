<?php

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
    // Route::get('/users/{id?}', 'index');
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
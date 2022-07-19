<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
*/

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::post('pay', 'pay')->name('payment');
    // Route::get('success', 'success');
    // Route::get('error', 'error');
});


/*
|--------------------------------------------------------------------------
| Backend
|--------------------------------------------------------------------------
*/

Route::controller(DashboardController::class)->prefix('admin')->group(function () {
    Route::get('/login', 'login')->name('login')->middleware('logout');
    Route::post('/entry', 'entry')->name('entry');
    Route::get('/exit', 'exit')->name('exit');
    Route::get('/dashboard', 'dashboard')->name('dashboard')->middleware('login');
});

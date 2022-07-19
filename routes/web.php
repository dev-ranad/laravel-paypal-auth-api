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
});


/*
|--------------------------------------------------------------------------
| Backend
|--------------------------------------------------------------------------
*/

Route::controller(DashboardController::class)->prefix('admin')->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
});

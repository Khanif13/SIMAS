<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomingLetterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:admin,sekretaris'])->group(function () {
        Route::resource('incoming-letters', IncomingLetterController::class);
    });
});

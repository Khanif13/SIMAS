<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DispositionController; // <-- Jangan lupa import ini
use App\Http\Controllers\IncomingLetterController;
use App\Http\Controllers\OutgoingLetterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// RUTE PUBLIK (Akses halaman login)
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| RUTE TERLINDUNGI (Harus Login Terlebih Dahulu)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export', [DashboardController::class, 'export'])->name('dashboard.export');

    Route::get('/dispositions', [DispositionController::class, 'index'])->name('dispositions.index');
    Route::put('/dispositions/{id}/feedback', [DispositionController::class, 'submitFeedback'])->name('dispositions.feedback');

    Route::resource('users', UserController::class)->except(['create', 'show']);

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/export', [ActivityLogController::class, 'export'])->name('activity-logs.export');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    /*
    |--------------------------------------------------------------------------
    | RUTE KHUSUS (Hanya untuk Superadmin dan Admin)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:superadmin,admin'])->group(function () {
        Route::resource('incoming-letters', IncomingLetterController::class);
        Route::resource('outgoing-letters', OutgoingLetterController::class);

        Route::post('/incoming-letters/{id}/dispositions', [DispositionController::class, 'store'])->name('dispositions.store');
    });

});

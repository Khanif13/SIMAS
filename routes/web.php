<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| TEMPORARY UI TESTING ROUTES (DUMMY DATA MODE)
|--------------------------------------------------------------------------
*/

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Surat Masuk Routes
Route::get('/incoming-letters', function () {
    return view('incoming-letters.index');
});
Route::get('/incoming-letters/create', function () {
    return view('incoming-letters.create');
});

// Surat Keluar Route
Route::get('/outgoing-letters', function () {
    return view('outgoing-letters.index');
});

// Disposisi Route
Route::get('/dispositions/show', function () {
    return view('dispositions.show');
});

/*
|--------------------------------------------------------------------------
| BACKEND ROUTES (Commented out until controllers are built)
|--------------------------------------------------------------------------
*/

// use App\Http\Controllers\DashboardController;
// use App\Http\Controllers\IncomingLetterController;

// Route::get('/', function () {
//     return view('auth.login');
// });

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//
//     Route::middleware(['role:admin,sekretaris'])->group(function () {
//         Route::resource('incoming-letters', IncomingLetterController::class);
//     });
// });

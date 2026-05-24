<?php

use App\Http\Controllers\IncomingLetterController;
use App\Http\Controllers\OutgoingLetterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard Route (Sementara masih view langsung)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| FITUR UTAMA SIMAS (Backend Routes)
|--------------------------------------------------------------------------
*/

// Route::resource otomatis membuat rute bernama (index, create, store, show, edit, update, destroy)
Route::resource('incoming-letters', IncomingLetterController::class);
Route::resource('outgoing-letters', OutgoingLetterController::class);


/*
|--------------------------------------------------------------------------
| FITUR MENDATANG
|--------------------------------------------------------------------------
*/

// Disposisi Route (Masih view langsung karena controllernya belum dibuat penuh)
Route::get('/dispositions/show', function () {
    return view('dispositions.show');
})->name('dispositions.show');

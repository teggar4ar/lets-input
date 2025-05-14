<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');    // Penduduk routes
    Route::resource('penduduk', PendudukController::class);
    Route::get('/penduduk/family-member/{kkNumber}', [PendudukController::class, 'addFamilyMember'])->name('penduduk.add-family-member');
    Route::post('/penduduk/family-member', [PendudukController::class, 'storeFamilyMember'])->name('penduduk.store-family-member');

    // Export routes
    Route::get('/export/penduduk', [ExportController::class, 'exportPenduduk'])->name('penduduk.export');
});

require __DIR__ . '/auth.php';

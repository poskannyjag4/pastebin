<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PasteController;


Route::get('/', [PasteController::class, 'index']);





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::controller(PasteController::class)->name('paste.')->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/', 'store')->name('store');
    Route::get('/{hashId}', 'show')->name('show');
});

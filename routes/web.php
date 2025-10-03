<?php

use App\Http\Controllers\PasteController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PasteController::class, 'index']);


Route::controller(PasteController::class)->name('paste.')->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/', 'store')->name('store');
    Route::get('/{hashId}', 'show')->name('show');
});

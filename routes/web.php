<?php

use App\Http\Controllers\PasteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PasteController::class, 'index']);

require __DIR__.'/auth.php';
Route::prefix('p')->controller(PasteController::class)->name('paste.')->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/', 'store')->name('store');
    Route::get('/my-pastes', 'showUserPastes')->name('my-pastes');
    Route::get('/s/{uuid}', 'share')->name('share');
    Route::get('/{hashId}', 'show')->name('show');
});
Route::prefix('p')->controller(\App\Http\Controllers\ComplaintController::class)->name('complaint.')->group(function () {
    Route::get('/s/{uuid}/complaint', 'show')->name('showUuid');
    Route::get('/{hashId}/complaint', 'show')->name('showHashId');
    Route::post('/s/{uuid}/complaint', 'store')->name('storeUuid');
    Route::post('/{hashId}/complaint', 'store')->name('storeHashId');
});

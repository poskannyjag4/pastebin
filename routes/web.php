<?php

use App\Http\Controllers\PasteController;
use Illuminate\Support\Facades\Route;


Route::get('/', 'App\Http\Controllers\PasteController@index');
Route::post('/', 'App\Http\Controllers\PasteController@store');
Route::get('/{hashId}', 'App\Http\Controllers\PasteController@show');

Route::controller(PasteController::class)->name('paste.')->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/', 'store')->name('store');
    Route::get('/{hashId}', 'show')->name('show');
});

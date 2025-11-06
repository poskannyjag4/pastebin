<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login.show');
    Route::post('/login', 'login')->name('login');
    Route::get('/register', 'showRegisterForm')->name('register.show');
    Route::post('/register', 'register')->name('register');
});
Route::middleware('auth')->controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/token', 'getToken')->name('auth.token');
});
Route::get('/auth/{provider}/redirect', [AuthController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [AuthController::class, 'callback'])->name('socialite.callback');

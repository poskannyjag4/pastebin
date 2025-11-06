<?php

declare(strict_types=1);

use App\Orchid\Screens\ComplaintListScreen;
use App\Orchid\Screens\PasteListScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\UserListScreen;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/profile', PlatformScreen::class)->name('platform.profile');
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

Route::screen('/user-list', UserListScreen::class)->name('platform.user_list');
Route::screen('/pastes', PasteListScreen::class)->name('platform.pastes');
Route::screen('/complaints', ComplaintListScreen::class)->name('platform.complaints');

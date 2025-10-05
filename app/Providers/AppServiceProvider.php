<?php

namespace App\Providers;

use App\Models\Paste;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        \Gate::define('ViewPrivatePaste', function (User $user, Paste $paste) {
            return $user->id === $paste->user_id;
        });
    }
}

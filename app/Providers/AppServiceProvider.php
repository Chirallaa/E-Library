<?php

namespace App\Providers;

use Illuminate\pagination\paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // View Composer to share $profile with 'part.topbar' view
        View::composer('part.topbar', function ($view) {
            $view->with('profile', Auth::user()->profile); // Sesuaikan dengan cara Anda mendapatkan profil pengguna
        });
    }
}

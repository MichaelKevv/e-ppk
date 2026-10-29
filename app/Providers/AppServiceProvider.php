<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Support\Facades\View::composer(['admin.*', 'admin.includes.*'], function ($view) {
            if (\Illuminate\Support\Facades\Auth::check()) {
                $user = \Illuminate\Support\Facades\Auth::user();
                $urgentKasusList = \App\Models\Pengaduan::with('sekolah')
                    ->forUser($user)
                    ->darurat()
                    ->latest()
                    ->take(5)
                    ->get();
                $urgentKasusCount = \App\Models\Pengaduan::forUser($user)
                    ->darurat()
                    ->count();

                $view->with('urgentKasusList', $urgentKasusList)
                     ->with('urgentKasusCount', $urgentKasusCount);
            }
        });
    }
}

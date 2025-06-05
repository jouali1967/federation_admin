<?php

namespace App\Providers;
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\NavLinkComposer;

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
        Schema::defaultStringLength(191);
        Livewire::setUpdateRoute(function ($handle) {
          return Route::post('/newproject/public/livewire/update', $handle);
        });

        View::composer('components.layouts.app', NavLinkComposer::class);
    }
}

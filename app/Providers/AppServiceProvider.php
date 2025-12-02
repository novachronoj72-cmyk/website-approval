<?php

namespace App\Providers;

use App\Enums\UserRole;
use Illuminate\Support\Facades\View;
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
        // Share Enum UserRole ke semua view
        // Ini agar kita bisa menggunakannya di layout Blade
        View::share('UserRole', UserRole::class);
    }
}
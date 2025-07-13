<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
   public function boot(): void
{
    Inertia::share([
        'menuCategories' => function () {
            return Category::menuItems()->take(7)->get();
        }
    ]);
}
}

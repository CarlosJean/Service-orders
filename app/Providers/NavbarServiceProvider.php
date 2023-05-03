<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\MenuRepository as GlobalMenuRepository;

class NavbarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
        view()->composer('partials.navbar', function($view){
            $view->with('roleMenus', GlobalMenuRepository::submenusByRole());
        });
    }
}

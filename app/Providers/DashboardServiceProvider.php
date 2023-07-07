<?php

namespace App\Providers;

use App\View\Composers\ApprovedItemsManagementComposer;
use App\View\Composers\ApprovedServiceOrdersComposer;
use App\View\Composers\PendingItemsManagementComposer;
use App\View\Composers\PendingServiceOrdersComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades;

class DashboardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {        
        Facades\View::composer('dashboards.pending_service_orders', PendingServiceOrdersComposer::class);
        Facades\View::composer('dashboards.approved_service_orders', ApprovedServiceOrdersComposer::class);
        Facades\View::composer('dashboards.pending_items_management', PendingItemsManagementComposer::class);
        Facades\View::composer('dashboards.approved_items_management', ApprovedItemsManagementComposer::class);
    }
}

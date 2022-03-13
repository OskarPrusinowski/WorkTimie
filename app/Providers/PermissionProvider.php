<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Permissions\PermissionsService;

class PermissionProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PermissionsService::class, function ($app) {
            return new PermissionsService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

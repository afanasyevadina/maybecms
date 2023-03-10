<?php

namespace Altenic\MaybeCms;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class MaybeCmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        require_once __DIR__ . '/helpers.php';

        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'maybecms');

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/maybecms'),
        ], 'maybecms-views');

        $this->publishes([
            __DIR__ . '/config/maybecms.php' => config_path('maybecms.php'),
        ], 'maybecms-config');

        $this->publishes([
            __DIR__.'/public' => public_path('vendor/maybecms'),
        ], 'maybecms-public');

        Gate::define('admin', function ($user) {
            return $user->roles()->where('slug', 'admin')->exists();
        });
    }
}

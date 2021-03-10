<?php

namespace CuongDev\Larab;

use Illuminate\Support\ServiceProvider;

class LarabServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/database/seeders');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'larab');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }

}

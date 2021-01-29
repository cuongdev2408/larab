<?php

namespace CuongDev\Larab;

use Illuminate\Support\Facades\Route;
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
        $this->registerRoutes();

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }

    protected function registerRoutes()
    {
        Route::group(['prefix' => 'api', 'middleware' => 'api'], function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        });

        Route::group(['prefix' => '', 'middleware' => 'web'], function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        });
    }

}

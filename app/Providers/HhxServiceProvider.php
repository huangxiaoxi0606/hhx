<?php

namespace App\Providers;

use App\Handlers\HhxHandler;
use Illuminate\Support\ServiceProvider;

class HhxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->singleton('hhx', function ($app) {
//            return new HhxHandler();
//        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

}

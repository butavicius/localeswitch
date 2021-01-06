<?php

namespace SimonBoot\LocaleSwitch\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use SimonBoot\LocaleSwitch\Middleware\LocaleSwitchMiddleware;

class LocaleSwitchServiceProvider extends ServiceProvider
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
          $router = $this->app->make(Router::class);
          $router->pushMiddlewareToGroup('web', LocaleSwitchMiddleware::class);
        //
    }
}

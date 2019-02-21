<?php

namespace Chameleon;

use Illuminate\Support\ServiceProvider;

/**
 * Class MilliKartServiceProvider
 * @package Chameleon
 */
class MilliKartServiceProvider extends ServiceProvider
{
    /**
     * Boot
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/millikart.php' => config_path('millikart.php'),
        ]);
    }

    /**
     * Register
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/millikart.php',
            'millikart'
        );

        $this->app->singleton(MilliKart::class, function () {
            return new MilliKart($this->app['config']->get('millikart'));
        });
        $this->app->alias(MilliKart::class, 'millikart');
    }
}

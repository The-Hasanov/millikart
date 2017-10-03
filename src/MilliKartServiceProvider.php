<?php
namespace Chameleon;


use Illuminate\Support\ServiceProvider;

class MilliKartServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/millikart.php' => config_path('millikart.php'),
        ]);
    }


    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/millikart.php', 'millikart'
        );

        $this->app->singleton('millikart',function(){

            return new MilliKart($this->app['config']->get('millikart'));
        });

    }

}
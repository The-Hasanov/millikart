<?php

namespace Chameleon\Millikart;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class MillikartServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->configFilePath() => $this->app->configPath('millikart.php')
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            $this->configFilePath(),
            'millikart'
        );
        $this->app->singleton(Millikart::class, static function ($app) {
            $config = $app['config']->get('millikart');

            Millikart::beforeBuild(static function (Builder $builder) use ($config) {
                $builder->merchant($config['merchant'])
                    ->language($config['language']);
            });

            return new Millikart(new MillikartApi(new Client(), $config['gateway']));
        });
        $this->app->alias(Millikart::class, 'millikart');
    }

    private function configFilePath()
    {
        return __DIR__ . '/../config/millikart.php';
    }

}
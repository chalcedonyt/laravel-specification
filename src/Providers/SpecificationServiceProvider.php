<?php

namespace Chalcedonyt\Specification\Providers;
use Chalcedonyt\Specification\Commands\SpecificationGeneratorCommand;
use Illuminate\Support\ServiceProvider;

class SpecificationServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $source_config = __DIR__ . '/../config/specification.php';
        $this->publishes([$source_config => '../config/specification.php'], 'config');
        $this->loadViewsFrom(__DIR__ . '/../views', 'specification');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $source_config = __DIR__ . '/../config/specification.php';
        $this->mergeConfigFrom($source_config, 'specification');

        // register our command here

        $this->app['command.specification.generate'] = $this->app->share(
            function ($app) {
                return new SpecificationGeneratorCommand($app['config'], $app['view'], $app['files']);
            }
        );
        $this->commands('command.specification.generate');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['specification', 'command.specification.generate'];
    }
}

<?php

namespace WinAung\LaravelEntityGenerator;

use Illuminate\Support\ServiceProvider;
use WinAung\LaravelEntityGenerator\Console\Commands\MakeEntity;

class LaravelEntityGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeEntity::class,
            ]);

            $this->publishes([
                __DIR__.'/../config/laravel-entity-generator.php' => config_path('laravel-entity-generator.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-entity-generator.php', 'laravel-entity-generator'
        );
    }
}

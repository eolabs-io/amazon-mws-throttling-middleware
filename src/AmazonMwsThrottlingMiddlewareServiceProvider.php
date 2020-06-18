<?php

namespace EolabsIo\AmazonMwsThrottlingMiddleware;

use EolabsIo\AmazonMwsThrottlingMiddleware\AmazonMwsThrottlingMiddleware;
use Illuminate\Support\ServiceProvider;

class AmazonMwsThrottlingMiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'amazon-mws-throttling-middleware');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'amazon-mws-throttling-middleware');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('amazon-mws-throttling-middleware.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/amazon-mws-throttling-middleware'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/amazon-mws-throttling-middleware'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/amazon-mws-throttling-middleware'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'amazon-mws-throttling-middleware');

        // Register the main class to use with the facade
        $this->app->singleton('amazon-mws-throttling-middleware', function () {
            return new AmazonMwsThrottlingMiddleware;
        });
    }
}

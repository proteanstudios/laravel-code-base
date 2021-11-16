<?php

namespace Pros\CodeBase;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Pros\CodeBase\Console\Commands\RemoseMakeCommand;
use Pros\CodeBase\Console\Commands\RepositoryMakeCommand;
use Pros\CodeBase\Console\Commands\ServiceMakeCommand;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCommands();
        $this->configurePublishing();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->singleton(ProsCodeBase::class, function ($app) {
        //     return new Connection(config('riak'));
        // });
    }

    /**
     * Register the console commands for the package.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RemoseMakeCommand::class,
                RepositoryMakeCommand::class,
                ServiceMakeCommand::class,
            ]);
        }
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config' => $this->app->basePath('config'),
            ], ['pros-base', 'config']);
        }
    }
}

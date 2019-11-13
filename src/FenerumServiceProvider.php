<?php

declare(strict_types=1);

namespace Fenerum;

use Illuminate\Support\ServiceProvider;

class FenerumServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/fenerum.php' => config_path('fenerum.php'),
            ], 'config');
        }
    }
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/fenerum.php', 'fenerum');
    }
}

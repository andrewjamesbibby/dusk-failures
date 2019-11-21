<?php

namespace Bibby\DuskFailures;

use Illuminate\Support\ServiceProvider;

class DuskFailuresServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/Config/dusk-failures.php', 'dusk-failures');
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands('\Bibby\DuskFailures\Console\DuskFailuresCommand');
        $this->loadViewsFrom(__DIR__.'/Views', 'dusk-failures');

        $this->publishes([
            __DIR__.'/Config/dusk-failures.php' => config_path('dusk-failures.php'),
            __DIR__.'/Views' => resource_path('views/vendor/dusk-failures'),
        ]);
    }
}

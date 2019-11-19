<?php

namespace Bibby\DuskFailures;

use Illuminate\Support\ServiceProvider;

class DuskFailuresServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands('\Bibby\DuskFailures\Console\DuskFailuresCommand');
        $this->loadViewsFrom(__DIR__.'/Views', 'DuskFailures');

        $this->publishes([
            __DIR__.'/Config/dusk-failures.php' => config_path('dusk-failures.php'),
            __DIR__.'/Views' => resource_path('views/vendor/dusk-failures'),
        ]);
    }
}

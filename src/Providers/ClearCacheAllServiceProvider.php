<?php

namespace ClearCacheAll\Providers;

class ClearCacheAllServiceProvider implements Provider
{
    protected function providers()
    {
        return [
            AutomateClearCacheServiceProvider::class,
            ManualClearCacheServiceProvider::class,
        ];
    }

    public function register()
    {
        foreach ($this->providers() as $service) {
            (new $service)->register();
        }
    }

    public function boot()
    {
        //
    }
}

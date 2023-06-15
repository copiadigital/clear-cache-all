<?php

namespace ClearCacheAll\Providers;

use ClearCacheAll\Caches\ClearAllCaches;

class AutomateClearCacheServiceProvider implements Provider
{
    public function __construct()
    {
        add_action('post_updated', [$this, 'clear_cache_after_save_post']);
    }

    public function register()
    {
        //
    }

    public function clear_cache_after_save_post() {
        $clear_all_caches = new ClearAllCaches();
        $clear_all_caches->clear_all_caches_not_view();
    }
}

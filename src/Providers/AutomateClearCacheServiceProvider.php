<?php

namespace ClearCacheAll\Providers;

use ClearCacheAll\Caches\ClearAllCaches;

class AutomateClearCacheServiceProvider implements Provider
{

    private $caches;

    public function __construct()
    {
        $this->caches = new ClearAllCaches();
        add_action('post_updated', [$this, 'clear_cache_after_save_post']);
        add_action('acf/save_post', [$this, 'clear_cache_after_save_options']);
    }

    public function register()
    {
        //
    }

    public function clear_cache_after_save_post() {
        $this->caches->clear_specific_post_page_cache();
    }

    public function clear_cache_after_save_options($post_id) {
        if ( function_exists('acf_get_options_page') && $post_id === 'options' ) {
            $this->caches->clear_all_caches_not_view();
        }
    }
}

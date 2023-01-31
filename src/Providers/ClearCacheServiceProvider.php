<?php

namespace ClearCacheAll\Providers;

class ClearCacheServiceProvider implements Provider
{
    public function register()
    {
        function clear_cache_after_save_post( $post_id ) {
            if (function_exists('shell_exec')) {
                // clear w3 total cache
                if ( defined( 'W3TC' ) ) {
                    shell_exec('php ' . CLEAR_CACHE_ALL_PLUGIN_DIR . 'wp-cli.phar w3-total-cache flush all --allow-root');
                }
                // clear view blade cache
                if (function_exists('view')) {
                    shell_exec('php ' . CLEAR_CACHE_ALL_PLUGIN_DIR . 'wp-cli.phar acorn view:clear --allow-root');
                }
                // clear wordpress cache
                shell_exec('php ' . CLEAR_CACHE_ALL_PLUGIN_DIR . 'wp-cli.phar cache flush --allow-root');
            }
        }
        add_action( 'post_updated', __NAMESPACE__ . '\\clear_cache_after_save_post' );
        
    }
}
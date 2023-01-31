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
                    $view_clear_cli = shell_exec('php ' . CLEAR_CACHE_ALL_PLUGIN_DIR . 'wp-cli.phar acorn view:clear --allow-root');
                } else {
                    delete_views_cache();
                }
                // clear wordpress cache
                shell_exec('php ' . CLEAR_CACHE_ALL_PLUGIN_DIR . 'wp-cli.phar cache flush --allow-root');
            }
        }
        add_action( 'post_updated', __NAMESPACE__ . '\\clear_cache_after_save_post' );

        function delete_views_cache() {
            $files = glob(get_stylesheet_directory() . '/storage/framework/views/*');
            // Deleting all the files in the /storage/framework/views
            foreach($files as $file) {
                if(is_file($file)) {
                    // Delete the given file
                    unlink($file); 
                }
            }
        }
    }
}

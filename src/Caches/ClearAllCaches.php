<?php

namespace ClearCacheAll\Caches;

class ClearAllCaches {

    public function clear_all_caches() {
        if (function_exists('shell_exec')) {
            // clear w3 total cache
            if ( defined( 'W3TC' ) ) {
                shell_exec('php ' . CLEAR_CACHE_ALL_PLUGIN_DIR . 'wp-cli.phar w3-total-cache flush all --allow-root');
            }
            // clear view blade cache
            if (function_exists('view')) {
                $view_clear_cli = shell_exec('php ' . CLEAR_CACHE_ALL_PLUGIN_DIR . 'wp-cli.phar acorn view:clear --allow-root');
            } else {
                $this->delete_views_cache();
            }
            // clear wordpress cache
            shell_exec('php ' . CLEAR_CACHE_ALL_PLUGIN_DIR . 'wp-cli.phar cache flush --allow-root');
        }
    }

    private function delete_views_cache() {
        $files = glob(get_stylesheet_directory() . '/storage/framework/views/*');
        // Deleting all the files in the /storage/framework/views
        if($files) {
            foreach($files as $file) {
                if(is_file($file)) {
                    // Delete the given file
                    unlink($file); 
                }
            }
        }
    }

}

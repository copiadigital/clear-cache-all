<?php

namespace ClearCacheAll\Caches;

class ClearAllCaches {

    public function clear_all_caches() {
        // delete_w3tc_page_enhanced_cache
        $this->delete_dir($_SERVER['DOCUMENT_ROOT'] . '/app/cache/page_enhanced');
        
        if (function_exists('shell_exec')) {
            // clear w3 total cache
            if ( defined( 'W3TC' ) ) {
                shell_exec('php ' . CLEAR_CACHE_ALL_PLUGIN_DIR . 'wp-cli.phar w3-total-cache flush all');
            }
            // clear view blade cache
            if (function_exists('view')) {
                $view_clear_cli = shell_exec('php ' . CLEAR_CACHE_ALL_PLUGIN_DIR . 'wp-cli.phar acorn view:clear');
            } else {
                $this->delete_views_cache();
            }
            // clear wordpress cache
            shell_exec('php ' . CLEAR_CACHE_ALL_PLUGIN_DIR . 'wp-cli.phar cache flush');
        }
    }

    public function clear_all_caches_not_view() {
        // delete_w3tc_page_enhanced_cache
        $this->delete_dir($_SERVER['DOCUMENT_ROOT'] . '/app/cache/page_enhanced');

        if (function_exists('shell_exec')) {
            // clear w3 total cache
            if ( defined( 'W3TC' ) ) {
                shell_exec('php ' . CLEAR_CACHE_ALL_PLUGIN_DIR . 'wp-cli.phar w3-total-cache flush all');
            }
            
            // clear wordpress cache
            shell_exec('php ' . CLEAR_CACHE_ALL_PLUGIN_DIR . 'wp-cli.phar cache flush');
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

    private function delete_dir($directory) {
        $files = glob($directory . '/*');
        if($files) {
            foreach ($files as $file) {
                is_dir($file) ? $this->delete_dir($file) : unlink($file);
            }
            if(!is_dir($directory)) {
                rmdir($directory);
            }
        }
        return;
    }

}

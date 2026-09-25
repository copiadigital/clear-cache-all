<?php

namespace ClearCacheAll\Caches;

class ClearAllCaches {

    /**
     * W3 Total Cache and the object cache are flushed in this process through
     * their own APIs. Only the Blade view cache still needs WP-CLI (Acorn's
     * `view:clear`); this runs from the admin bar button, never on save.
     */
    public function clear_all_caches() {
        // delete_w3tc_page_enhanced_cache
        $this->delete_dir($this->page_enhanced_dir());

        // clear w3 total cache
        if (function_exists('w3tc_flush_all')) {
            w3tc_flush_all();
        }

        if ($this->can_run_wp_cli()) {
            // clear view blade cache
            if (function_exists('view')) {
                $view_clear_cli = shell_exec('php ' . CLEAR_CACHE_ALL_PLUGIN_DIR . 'wp-cli.phar acorn view:clear');
            } else {
                $this->delete_views_cache();
            }
        }

        // clear wordpress cache
        wp_cache_flush();

        $this->clear_polylang_cache();
    }

    public function clear_all_caches_not_view() {
        // delete_w3tc_page_enhanced_cache
        $this->delete_dir($this->page_enhanced_dir());

        // clear w3 total cache
        if (function_exists('w3tc_flush_all')) {
            w3tc_flush_all();
        }

        // clear wordpress cache
        wp_cache_flush();

        $this->clear_polylang_cache();
    }

    /**
     * Clears the page cache of the given posts that have pages, then the
     * object cache once.
     *
     * This used to run `wp w3-total-cache flush post` and `wp cache flush` in
     * new processes, which loaded WordPress twice more on every save. When the
     * save itself happened while WordPress was loading in WP-CLI, each new
     * process could save again and start another, without end.
     *
     * @param int[] $post_ids
     */
    public function clear_posts_page_cache(array $post_ids) {
        // clear w3 total cache, as `wp w3-total-cache flush post <id>` does,
        // for posts that have pages (not menu items, forms and the like)
        if (function_exists('w3tc_flush_post')) {
            foreach ($post_ids as $post_id) {
                if (is_post_type_viewable(get_post_type($post_id))) {
                    w3tc_flush_post($post_id, true);
                }
            }
        }

        // clear wordpress cache
        wp_cache_flush();

        $this->clear_polylang_cache();
    }

    /**
     * Whether WP-CLI can be started in a new process.
     *
     * Never from inside WP-CLI: the new process loads WordPress again, so
     * anything that clears caches while loading would start another.
     */
    private function can_run_wp_cli() {
        return function_exists('shell_exec') && !(defined('WP_CLI') && WP_CLI);
    }

    /**
     * W3 Total Cache's disk-enhanced page cache directory.
     *
     * `$_SERVER['DOCUMENT_ROOT']` is empty under WP-CLI and only matched on
     * Bedrock, so use W3TC's own constant, falling back to where it puts it.
     */
    private function page_enhanced_dir() {
        return defined('W3TC_CACHE_PAGE_ENHANCED_DIR')
            ? W3TC_CACHE_PAGE_ENHANCED_DIR
            : WP_CONTENT_DIR . '/cache/page_enhanced';
    }

    /**
     * Clears Polylang's languages cache, when Polylang is active.
     *
     * Polylang has no WP-CLI command for this: `wp pll` only offers `language`
     * and `setting`, so the `wp pll cache clear` this used to run failed on
     * every site, with or without Polylang. Call Polylang's own cleanup
     * instead, which both the free and Pro versions have had since 1.2. It
     * needs no shell_exec(), so it runs even where that is disabled.
     */
    private function clear_polylang_cache() {
        if ( ! function_exists('PLL') ) {
            return;
        }

        $polylang = PLL();

        if ( empty($polylang->model) || ! method_exists($polylang->model, 'clean_languages_cache') ) {
            return;
        }

        $polylang->model->clean_languages_cache();
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

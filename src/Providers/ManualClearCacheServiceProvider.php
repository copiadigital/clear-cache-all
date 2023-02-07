<?php

namespace ClearCacheAll\Providers;

use ClearCacheAll\Caches\ClearAllCaches;
use WP_Admin_Bar;

class ManualClearCacheServiceProvider implements Provider
{
    public function __construct()
    {
        add_action('init', [$this, 'process_clear_cache_request']);
        add_action('admin_bar_menu', [$this, 'clear_cache_all_admin_bar'], 100);
        add_action('admin_notices', [$this, 'clear_cache_all_cleared_notice']);
    }

    public function register()
    {
        //
    }

    public function clear_cache_all_admin_bar(WP_Admin_Bar $wp_admin_bar){
        if ( !is_admin() ) {
            return;
        }

        $wp_admin_bar->add_menu( array(
            'id'    => 'clear_cache_all',
            'title' => 'Clear Cache All',
            'href'   => wp_nonce_url( add_query_arg( array(
                '_cache'  => 'clear-cache-all-enabler',
                '_action' => 'clear',
            ) ), 'clear_cache_all_nonce' ),
            'meta'  => array(
                'title' => __('Clear Cache All'),            
            ),
        ));
    }

    /**
     * Process a clear cache request.
     *
     * This runs on the 'init' action. It clears the cache when a clear cache button
     * is clicked in the admin bar.
     *
     */
    public function process_clear_cache_request() {
        if ( empty( $_GET['_cache'] ) || empty( $_GET['_action'] ) || $_GET['_cache'] !== 'clear-cache-all-enabler' || $_GET['_action'] !== 'clear' ) {
            return;
        }

        if ( empty( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'clear_cache_all_nonce' ) ) {
            return;
        }
        
        if ( $_GET['_action'] === 'clear' ) {
            $clear_all_caches = new ClearAllCaches();
            $clear_all_caches->clear_all_caches();
        }

        // Redirect to the same page.
        wp_safe_redirect( remove_query_arg( array( '_cache', '_action', '_wpnonce' ) ) );

        if(is_admin()) {
            set_transient( $this->get_cache_cleared_transient_name(), 1 );
        }

        exit;
    }

    /**
     * Get the name of the transient that is used in the cache clear notice.
     *
     * @return  string  Name of the transient.
     */
    private function get_cache_cleared_transient_name() {
        $transient_name = 'clear_cache_all_cleared_' . get_current_user_id();

        return $transient_name;
    }

    /**
     * Display an admin notice after the cache has been cleared.
     *
     * This runs on the 'admin_notices' action.
     */
    public function clear_cache_all_cleared_notice() {
        if ( get_transient( $this->get_cache_cleared_transient_name() ) ) {
            printf(
                '<div class="notice notice-success is-dismissible"><p><strong>%s</strong></p></div>',
                esc_html__( 'Site cache cleared.', 'clear-cache-all' )
            );

            delete_transient( $this->get_cache_cleared_transient_name() );
        }
    }
}

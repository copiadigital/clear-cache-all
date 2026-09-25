<?php

namespace ClearCacheAll\Providers;

use ClearCacheAll\Caches\ClearAllCaches;

class AutomateClearCacheServiceProvider implements Provider
{

    private $caches;

    /**
     * Posts updated during this request, keyed by ID.
     *
     * @var array<int, true>
     */
    private $post_ids = [];

    public function __construct()
    {
        $this->caches = new ClearAllCaches();

        // Settings > Clear Cache All can switch automatic clearing off.
        if (!SettingsServiceProvider::auto_clear_enabled()) {
            return;
        }

        add_action('post_updated', [$this, 'queue_post']);
        add_action('acf/save_post', [$this, 'clear_cache_after_save_options']);
    }

    public function register()
    {
        //
    }

    /**
     * Queues an updated post to have its caches cleared at the end of the request.
     *
     * Autosaves and revisions are skipped: visitors never see them, and the
     * block editor autosaves every minute while a post is open. The rest are
     * cleared together, so saving a menu clears the caches once rather than
     * once per menu item.
     *
     * This runs on the 'post_updated' action.
     *
     * @param int $post_id
     */
    public function queue_post($post_id) {
        if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
            return;
        }

        if (!$this->post_ids) {
            add_action('shutdown', [$this, 'clear_queued_posts']);
        }

        $this->post_ids[(int) $post_id] = true;
    }

    /**
     * This runs on the 'shutdown' action, before W3 Total Cache runs its own
     * delayed flushes at priority 100000.
     */
    public function clear_queued_posts() {
        $post_ids = array_keys($this->post_ids);
        $this->post_ids = [];

        $this->caches->clear_posts_page_cache($post_ids);
    }

    public function clear_cache_after_save_options($post_id) {
        if ( function_exists('acf_get_options_page') && $post_id === 'options' ) {
            $this->caches->clear_all_caches_not_view();
        }
    }
}

<?php

namespace ClearCacheAll\Providers;

class SettingsServiceProvider implements Provider
{
    /**
     * Option holding whether caches are cleared automatically on save.
     *
     * Stored as '1' or '0'. Missing means enabled, so existing sites keep
     * clearing automatically until someone turns it off.
     */
    const AUTO_CLEAR_OPTION = 'clear_cache_all_auto_clear';

    const PAGE_SLUG = 'clear-cache-all';

    const SETTINGS_GROUP = 'clear_cache_all';

    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register()
    {
        //
    }

    /**
     * Whether caches should be cleared automatically when content is saved.
     *
     * @return bool
     */
    public static function auto_clear_enabled()
    {
        return (bool) get_option(self::AUTO_CLEAR_OPTION, '1');
    }

    /**
     * Adds Settings > Clear Cache All.
     *
     * This runs on the 'admin_menu' action.
     */
    public function add_settings_page()
    {
        add_options_page(
            __('Clear Cache All', 'clear-cache-all'),
            __('Clear Cache All', 'clear-cache-all'),
            'manage_options',
            self::PAGE_SLUG,
            [$this, 'render_settings_page']
        );
    }

    /**
     * Registers the option and its field with the Settings API.
     *
     * This runs on the 'admin_init' action.
     */
    public function register_settings()
    {
        register_setting(self::SETTINGS_GROUP, self::AUTO_CLEAR_OPTION, [
            'type'              => 'boolean',
            'default'           => '1',
            'sanitize_callback' => [$this, 'sanitize_checkbox'],
        ]);

        add_settings_section(
            'clear_cache_all_automatic',
            __('Automatic cache clearing', 'clear-cache-all'),
            '__return_false',
            self::PAGE_SLUG
        );

        add_settings_field(
            self::AUTO_CLEAR_OPTION,
            __('Clear on save', 'clear-cache-all'),
            [$this, 'render_auto_clear_field'],
            self::PAGE_SLUG,
            'clear_cache_all_automatic',
            ['label_for' => self::AUTO_CLEAR_OPTION]
        );
    }

    /**
     * An unticked checkbox isn't submitted at all, so anything empty means off.
     *
     * @param mixed $value
     * @return string '1' or '0'.
     */
    public function sanitize_checkbox($value)
    {
        return empty($value) ? '0' : '1';
    }

    public function render_auto_clear_field()
    {
        printf(
            '<label><input type="checkbox" id="%1$s" name="%1$s" value="1" %2$s> %3$s</label>',
            esc_attr(self::AUTO_CLEAR_OPTION),
            checked(self::auto_clear_enabled(), true, false),
            esc_html__('Automatically clear caches when content is saved', 'clear-cache-all')
        );

        printf(
            '<p class="description">%s</p>',
            esc_html__(
                'When enabled, caches are cleared every time a post, page or menu item is updated, and when an ACF options page is saved. On larger sites this can make saving slow. When disabled, clear caches manually with the Clear Cache All button in the admin bar (Copia Digital users only).',
                'clear-cache-all'
            )
        );
    }

    public function render_settings_page()
    {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields(self::SETTINGS_GROUP);
                do_settings_sections(self::PAGE_SLUG);
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}

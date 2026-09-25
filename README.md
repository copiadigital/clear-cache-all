# Clear Cache All - WordPress Plugin

A WordPress plugin for clearing all caches including Polylang cache.

## Features

- Automatic cache clearing on post save (can be turned off in Settings > Clear Cache All)
- Clears WordPress object cache
- Clears Polylang's languages cache (when Polylang is active)
- Clears W3 Total Cache (if installed)
- Clears Blade view cache
- Manual cache clearing via admin bar (restricted to Copia Digital users only)

## Requirements

- WordPress 5.0+
- PHP 7.4+
- WP-CLI 2.12.0+ (included in plugin)
- Polylang plugin (for Polylang cache clearing)

## Installation

1. Upload the plugin files to `/wp-content/plugins/clear-cache-all/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Ensure WP-CLI is executable: `chmod +x wp-cli.phar`

## WP-CLI

This plugin includes WP-CLI version 2.12.0. It is only used by the admin bar button, to clear the Blade view cache with `acorn view:clear`, and never from inside WP-CLI. Everything else is cleared in the same request through the W3 Total Cache and WordPress APIs.

### Updating WP-CLI

To update to the latest version:

```bash
cd /path/to/wp-content/plugins/clear-cache-all/
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
```

Check version:
```bash
php wp-cli.phar --version
```

## Usage

### Automatic Cache Clearing

The plugin automatically clears all caches when:
- A post is saved or updated
- Content changes are published

This is on by default. To turn it off, go to **Settings > Clear Cache All** and untick **Automatically clear caches when content is saved**. Caches can then still be cleared manually from the admin bar.

Caches are cleared once, at the end of the request, for all the posts it updated, so saving a menu clears them once rather than once per menu item. Autosaves and revisions are skipped.

### Manual Cache Clearing

Copia Digital users (with @copiadigital.co email addresses) will see a "Clear Cache All" option in the WordPress admin bar for manual cache clearing.

### Caches Cleared

- WordPress object cache: `wp cache flush`
- Polylang languages cache: `PLL()->model->clean_languages_cache()`, only when Polylang is active
- W3 Total Cache (if installed)
- Blade view cache

## Development

### File Structure

```
clear-cache-all/
├── src/
│   ├── Caches/
│   │   └── ClearAllCaches.php
│   └── Providers/
│       ├── AutomateClearCacheServiceProvider.php
│       ├── ClearCacheAllServiceProvider.php
│       ├── ManualClearCacheServiceProvider.php
│       ├── Provider.php
│       └── SettingsServiceProvider.php
├── wp-cli.phar
└── README.md
```

## Support

For issues and feature requests, please contact Copia Digital.

## License

Proprietary - Copia Digital

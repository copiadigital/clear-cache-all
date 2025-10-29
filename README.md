# Clear Cache All - WordPress Plugin

A WordPress plugin for clearing all caches including Polylang cache.

## Features

- Clears WordPress object cache
- Clears Polylang cache via WP-CLI
- Automated cache management

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

This plugin includes WP-CLI version 2.12.0 for cache operations.

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

The plugin automatically clears caches when triggered. Cache clearing includes:

- Polylang cache: `wp pll cache clear`
- Additional cache types as configured

## Development

### File Structure

```
clear-cache-all/
├── src/
│   └── Caches/
│       └── ClearAllCaches.php
├── wp-cli.phar
└── README.md
```

## Support

For issues and feature requests, please contact Copia Digital.

## License

Proprietary - Copia Digital

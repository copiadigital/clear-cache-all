# Changelog

All notable changes to this project will be documented in this file.

## [1.0.13] - 2026-09-25

### Fixed
- Saving a post no longer runs WP-CLI in new processes. Each save used to run `wp w3-total-cache flush post` and `wp cache flush` through `shell_exec()`, loading WordPress twice more and making the save wait for both. Caches are now cleared in the same request through `w3tc_flush_post()` and `wp_cache_flush()`, once per request, at shutdown, for every post the request updated. Saving a menu now clears them once rather than once per menu item.
- The new processes could re-enter without end. When something saved a post while WordPress was loading (for example, a theme updating a Contact Form 7 form from WP-CLI), each WP-CLI process fired `post_updated` again and started the next. On a shared staging server this ran until memory or database connections ran out. The admin bar button still uses WP-CLI for `acorn view:clear`, but never from inside WP-CLI.
- The W3 Total Cache page_enhanced directory is found through `W3TC_CACHE_PAGE_ENHANCED_DIR` instead of `$_SERVER['DOCUMENT_ROOT']`, which is empty under WP-CLI and only matched Bedrock.

### Changed
- Autosaves and revisions no longer clear caches.
- W3 Total Cache's page cache is flushed for every updated post that has a page (a viewable post type), not only the post open in the editor. Menu items, forms and other posts without pages only clear the object cache.

## [1.0.12] - 2026-09-22

### Added
- Settings > Clear Cache All page with an option to turn off automatic cache clearing on save. Automatic clearing stays on by default, so existing sites are unaffected until it is switched off.

### Fixed
- Polylang cache clearing never worked: `wp pll cache clear` is not a Polylang command (`wp pll` only has `language` and `setting`), so it errored on every save. It now calls Polylang's own `clean_languages_cache()`, and only when Polylang is active.

## [1.0.11] - 2025-10-29

### Added
- Added readme.txt

## [1.0.10] - 2025-10-29

### Added
- Added /vendor folder

## [1.0.9] - 2025-10-29

### Added
- Restrict "Clear Cache All" admin bar menu to Copia Digital users only (emails containing @copiadigital.co)
- Polylang cache clearing support via WP-CLI in all cache clearing methods
- README.md with complete plugin documentation
- readme.txt for WordPress plugin details view
- CHANGELOG.md for version tracking

### Changed
- Improved security by limiting cache clearing functionality to authorized users
- Made wp-cli.phar executable

### Fixed
- Added missing Polylang cache clearing to automated cache operations

## [1.0.8] - Previous Release

### Changed
- Various improvements and bug fixes

## Earlier Versions

For earlier version history, see git commit log.

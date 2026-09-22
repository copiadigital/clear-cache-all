# Changelog

All notable changes to this project will be documented in this file.

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

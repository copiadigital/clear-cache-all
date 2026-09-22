=== Clear Cache All ===
Contributors: copiadigital
Tags: cache, performance, polylang, optimization
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 1.0.12
Requires PHP: 7.4
License: MIT License
License URI: https://opensource.org/licenses/MIT

Automate cache clearing after saving posts. Includes support for W3 Total Cache, WordPress cache, Polylang, and Blade views.

== Description ==

Clear Cache All is a WordPress plugin that automatically clears various caches when content is updated. It ensures your site visitors always see the latest content without manual cache intervention.

= Features =

* Automatic cache clearing on post save (can be turned off in Settings > Clear Cache All)
* Clears WordPress object cache
* Clears Polylang's languages cache (when Polylang is active)
* Clears W3 Total Cache (if installed)
* Clears Blade view cache
* Manual cache clearing via admin bar (Copia Digital users only)

= Requirements =

* WordPress 5.0 or higher
* PHP 7.4 or higher
* WP-CLI 2.12.0+ (included in plugin)
* Polylang plugin (optional, for Polylang cache clearing)

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/clear-cache-all/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The plugin will automatically clear caches when posts are saved
4. Copia Digital users will see a "Clear Cache All" option in the admin bar for manual clearing

== Frequently Asked Questions ==

= Who can use the manual cache clearing feature? =

The admin bar "Clear Cache All" button is only visible to logged-in users with @copiadigital.co email addresses.

= Can I turn off automatic cache clearing? =

Yes. Go to Settings > Clear Cache All and untick "Automatically clear caches when content is saved". Caches can still be cleared manually from the admin bar. This helps on larger sites, where clearing after every save can make saving slow.

= Does this work with Polylang? =

Yes. When Polylang (free or Pro) is active, its languages cache is cleared along with the others. On sites without Polylang this step is skipped.

= What caches are cleared? =

* WordPress object cache
* Polylang cache
* W3 Total Cache (if installed)
* Blade view cache
* Any other caches hooked into the clearing process

== Changelog ==

= 1.0.12 =
* Added: Settings > Clear Cache All page with an option to turn off automatic cache clearing on save
* Fixed: Polylang cache clearing now uses Polylang's own API and only runs when Polylang is active (`wp pll cache clear` is not a real command)

= 1.0.11 =
* Added readme.txt

= 1.0.10 =
* Added /vendor folder

= 1.0.9 =
* Added: Restrict "Clear Cache All" admin bar menu to Copia Digital users only
* Added: Polylang cache clearing support via WP-CLI
* Improved: Security by limiting cache clearing functionality to authorized users
* Added: README.md and readme.txt documentation
* Added: CHANGELOG.md for version tracking

= 1.0.8 =
* Various improvements and bug fixes

== Upgrade Notice ==

= 1.0.9 =
This version adds Polylang cache clearing and restricts manual cache clearing to Copia Digital users.

== Additional Information ==

This plugin is developed and maintained by Copia Digital.

For support and feature requests, please contact Copia Digital.

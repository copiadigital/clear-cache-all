<?php
/**
* Plugin Name:  Clear Cache All
* Text Domain:  clear-cache-all
* Description:  Automate clear cache after save post. Cache included (w3 total cache, wordpress cache, & views blade).
* Version:      1.0.8
* Author:       Copia Digital
* Author URI:   https://www.copiadigital.com/
* License:      MIT License
*/

$autoload_path = __DIR__.'/vendor/autoload.php';
if ( file_exists( $autoload_path ) ) {
    require_once( $autoload_path );
}

define( 'CLEAR_CACHE_ALL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

$clover = new ClearCacheAll\Providers\ClearCacheAllServiceProvider;
$clover->register();

add_action('init', [$clover, 'boot']);

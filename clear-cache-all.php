<?php
/**
* Plugin Name:  Clear Cache All
* Description:  Automate clear cache after save post. Cache included (w3 total cache, wordpress cache, & views blade).
* Version:      1.0.0
* Author:       Copia Digital
* Author URI:   https://www.copiadigital.com/
* License:      MIT License
*/

require_once __DIR__.'/../../../../vendor/autoload.php';

$clover = new ClearCacheAll\Providers\ClearCacheAllServiceProvider;
$clover->register();

add_action('init', [$clover, 'boot']);

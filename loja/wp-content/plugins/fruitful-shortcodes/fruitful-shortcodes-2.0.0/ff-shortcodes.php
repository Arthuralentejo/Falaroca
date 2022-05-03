<?php

define( '_FF_SHORTCODES_PLUGIN_FILE_', __FILE__ );

spl_autoload_register( function ( $class ) {
	
	$prefix = 'ffshortcodes\\';
	
	$base_dir = __DIR__ . '/core/';
	
	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		return;
	}
	
	$relative_class = substr( $class, $len );
	$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

	if ( file_exists( $file ) ) {
		require $file;
	}
} );

// Global point of enter
if ( ! function_exists( 'FF_SHORTCODES' ) ) {
	
	function FF_SHORTCODES() {
		return \ffshortcodes\core::getInstance();
	}
	
}

// Fruitful statistics
require_once (__DIR__ . '/core/vendor/fruitful-stats/send-statistics.php');
$FruitfulShortcodes_Stats = new FruitfulShortcodes_Stats(__FILE__);
$FruitfulShortcodes_Stats->dispatch();

// Run the theme
FF_SHORTCODES()->run();
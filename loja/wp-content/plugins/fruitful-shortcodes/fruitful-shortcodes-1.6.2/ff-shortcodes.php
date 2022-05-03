<?php

class ffs {
	function __construct() {
		add_action( 'plugins_loaded', array( &$this, 'fruitful_shortcode_constants'), 	1);
		add_action( 'plugins_loaded', array( &$this, 'fruitful_shortcode_lang'),		2);
		add_action( 'plugins_loaded', array( &$this, 'fruitful_shortcode_includes'), 	3);
		add_action( 'plugins_loaded', array( &$this, 'fruitful_shortcode_admin_init'),	4);

		
		register_activation_hook  ( __FILE__, array( &$this,  'fruitful_shortcode_activation' ));
		register_deactivation_hook( __FILE__, array( &$this,'fruitful_shortcode_deactivation' ));
		
		add_action('init', array( &$this,'fruitful_init_shortcodes'));
	}
		
	function fruitful_shortcode_constants() {
		define( 'FRUITFUL_SHORTCODE_VERSION', '1.0.0' );
		define( 'FRUITFUL_SHORTCODE_WP_VERSION',   get_bloginfo( 'version' ));
		define( 'FRUITFUL_SHORTCODE_DIR', 	    trailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'FRUITFUL_SHORTCODE_URI', 		trailingslashit( plugin_dir_url( __FILE__ ) ) );
		define( 'FRUITFUL_SHORTCODE_INCLUDES', 	FRUITFUL_SHORTCODE_DIR . trailingslashit( 'includes' ) );
		define( 'FRUITFUL_SHORTCODE_LOAD',     	FRUITFUL_SHORTCODE_DIR . trailingslashit( 'load' ) );
	}
		
	function fruitful_shortcode_lang() {
		//load_plugin_textdomain( 'ff_shortcodes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );		
	}	
		
	function fruitful_shortcode_includes() {
		//require_once( fruitful_INCLUDES . 'functions.php' ); 
	}
		
	function fruitful_shortcode_admin_init() {
		if ( is_admin() ) {
			require_once( FRUITFUL_SHORTCODE_INCLUDES . '/admin/admin-options.php' );
			require_once( FRUITFUL_SHORTCODE_INCLUDES . '/admin/admin-mce.php' );
		}	
	}
		
	function fruitful_shortcode_activation() {
		/*Nor Enough*/
	}
		
	function fruitful_shortcode_deactivation() {
		delete_option('ff_shortcodes_options');
		delete_option('ff_shortcodes_db_version');
	}
	
	function fruitful_init_shortcodes() {
		require_once FRUITFUL_SHORTCODE_INCLUDES . '/shortcodes/shortcodes.php';
	}
	
}

// Fruitful statistics
require_once (__DIR__ . '/vendor/fruitful-stats/send-statistics.php');
$FruitfulShortcodes_Stats = new FruitfulShortcodes_Stats(__FILE__);
$FruitfulShortcodes_Stats->dispatch();

$ffs = new ffs();


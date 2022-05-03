<?php
/*
Plugin Name: ZF WordPress Category Search
Plugin URI: https://codecanyon.net/item/zf-wordpress-category-search/9168662
Description: ZF WordPress Category Search is advanced search box display categories as radio/tab/dropdown with advanced fields, auto suggest like google, support custom post type, taxonomies, WooCommerce, Easy Digital Downloads.
Version: 2.7
Author: ZuFusion
Author URI: https://zufusion.com
*/

// require
require_once(plugin_dir_path(__FILE__) . 'define.php');
require_once(plugin_dir_path(__FILE__) . 'inc/taxonomy-walker.php');
require_once(plugin_dir_path(__FILE__) . 'inc/core.php');
require_once(plugin_dir_path(__FILE__) . 'inc/functions.php');
require_once(plugin_dir_path(__FILE__) . 'inc/form-functions.php');

$instance = ZFWCS_Wordpress_Category_Search::get_instance();
$instance->run();
$GLOBALS['zfwcs'] = $instance;

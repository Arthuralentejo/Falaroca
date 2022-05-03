<?php
/**
 * @version    $Version$
 * @package    ZF WordPress Category Search
 * @author     ZuFusion Team
 * @copyright  Copyright (C) 2021 ZuFusion. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
// define
define('ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_FILE', plugin_dir_path(__FILE__) . 'zf-wordpress-category-search.php');
define('ZFWCS_WORDPRESS_CATEGORY_SEARCH_SKINS',   ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_PATH . 'assets/css/skins');
define('ZFWCS_WORDPRESS_CATEGORY_SEARCH_THEME_PATH', get_template_directory() . '/');
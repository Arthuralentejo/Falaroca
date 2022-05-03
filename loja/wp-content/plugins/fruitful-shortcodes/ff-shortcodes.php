<?php
/*
	Plugin Name: Fruitful Shortcodes
	Plugin URI: https://wordpress.org/plugins/fruitful-shortcodes
	Description: Add additional content shortcodes: Alert, Button, Promo-text, Columns, Progress-bar, Recent-posts, Posts-slider, Separator, Tabs
	Version: 2.1
	Author: fruitfulcode
	Author URI: https://fruitfulcode.com
	License: GPL2
*/
/*  Copyright 2014  Fruitful Code  (email : mail@fruitfulcode.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'FF_SC_PLUGIN_FILE_', __FILE__ );
define( 'FF_SC_PLUGIN_NAME', plugin_basename( __FILE__ ) );
define( 'FF_SC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

$ff_shortcodes_version = ff_shortcode_version();

if ( $ff_shortcodes_version == 'new' ) {
	require 'fruitful-shortcodes-2.0.0/ff-shortcodes.php';
} else {
	require 'fruitful-shortcodes-1.6.2/ff-shortcodes.php';
	add_action( 'admin_notices', 'ff_shortcode_admin_notice' );
}

function ff_shortcode_admin_notice() {
	if ( ( get_current_screen()->base == 'plugins' ) && (!isset($_GET['page']) || $_GET['page'] != 'ffsAdminSettings') ) {
	    ?>
        <div class="notice notice-success is-dismissible">
            <p><?php echo __( 'Activate new version of ', 'ff_shortcodes' ) . '<a href="/wp-admin/options-general.php?page=ffsAdminSettings">' . __( 'Fruitful Shortcodes', 'ff_shortcodes' ) . '</a>' . __( '. Get new features and shortcodes', 'ff_shortcodes' ); ?></p>
        </div>
	    <?php
    }
}

/** Get plugin version  */
function ff_shortcode_version() {
	$ff_shortcodes_options = get_option( 'fruitful_options_plugin' );
	//dd($ff_shortcodes_options);

	if ( empty( $ff_shortcodes_options ) ) {
		add_option( 'fruitful_options_plugin', array( 'fruitful_version' => 'new' ) );
		set_transient('ff_sc_modal', 1);

		return 'new';
	} else {
		if ( isset( $ff_shortcodes_options['fruitful_version'] ) && in_array( $ff_shortcodes_options['fruitful_version'], array(
				'old',
				'new'
			) ) ) {
			return $ff_shortcodes_options['fruitful_version'];
		} else {
			return 'old';
		}
	}
}

/** Redirect after changing plugin version  */
add_action( 'update_option_fruitful_options_plugin', function ( $old_value, $new_value ) {

    if (!defined('DOING_AJAX')) {
        ff_shortcode_update_plugins($new_value['fruitful_version']);

        if ($new_value['fruitful_version'] == 'old') {
            wp_safe_redirect(get_admin_url(null, '/options-general.php?page=ffsAdminSettings'));
        } else {
            wp_safe_redirect(get_admin_url(null, '/options-general.php?page=fruitful-shortcodes%2Ffruitful-shortcodes-2.0.0%2Fcore%2Fcontroller%2Fbackend.php'));
        }
        //wp_safe_redirect( get_admin_url() );
        exit;
    }

}, 1, 100 );

/** Block plugin update functionality for old plugin version */
function ff_shortcode_update_plugins( $version ) {

	if ( $version == 'new') {
		delete_site_transient( 'update_plugins' );
	} else {
		$ff_update_plugins = get_site_transient( 'update_plugins' );

		if ( ! isset( $ff_update_plugins->no_update[ FF_SC_PLUGIN_NAME ] ) ) {

			if ( isset( $ff_update_plugins->response[ FF_SC_PLUGIN_NAME ] ) ) {
				$ff_update_plugins->no_update[ FF_SC_PLUGIN_NAME ] = $ff_update_plugins->response[ FF_SC_PLUGIN_NAME ];
				unset( $ff_update_plugins->response[ FF_SC_PLUGIN_NAME ] );
			} else {
				$ff_update_plugins->no_update[ FF_SC_PLUGIN_NAME ] = new stdClass();
			}

			set_site_transient( 'update_plugins', $ff_update_plugins );
		}
	}
}

if (!empty(get_transient('ff_sc_modal'))) {

    /** Load scripts for modal window */
    add_action('admin_enqueue_scripts', 'ff_plugin_load_assets');

    function ff_plugin_load_assets() {
        wp_enqueue_style('ff-shortcodes-trans', FF_SC_PLUGIN_URL . 'assets/css/styles.css', false, time());
        wp_register_script('ff-shortcodes-trans', FF_SC_PLUGIN_URL . 'assets/js/scripts.js', array('jquery'), time());
        $js_vars = array(
            'ajaxurl' => admin_url('admin-ajax.php'),
        );
        wp_localize_script('ff-shortcodes-trans', 'ffSC_Trans', $js_vars);
        wp_enqueue_script('ff-shortcodes-trans');
    }

    add_action('admin_footer', 'ff_plugin_version_choice', 1);
    function ff_plugin_version_choice() {
        require_once('modal-view.php');
    }

    add_action('admin_footer', 'ff_plugin_version_del_transient', 100);
    function ff_plugin_version_del_transient() {
        delete_transient('ff_sc_modal');
    }
}

/** AJAX */
add_action('wp_ajax_ff_sc_plugin_version', 'ff_sc_plugin_version');
add_action('wp_ajax_nopriv_ff_sc_plugin_version', 'ff_sc_plugin_version');

function ff_sc_plugin_version() {
    $return = array(
        'result' => 'false',
        'refresh' => 0
    );
    //exit;

    if (isset($_POST['version']) && in_array($_POST['version'], array('old', 'new'))) {
        $opt = get_option('fruitful_options_plugin');
        if (!empty($opt)) {
            if (!(isset($opt['fruitful_version']) && $opt['fruitful_version'] == $_POST['version'])) {
                update_option('fruitful_options_plugin', array('fruitful_version' => $_POST['version']));
                $return['refresh'] = 1;
            }
        } else {
            add_option('fruitful_options_plugin', array('fruitful_version' => $_POST['version']));
        }
        $return['result'] = 'ok';
    }
    $return['_POST'] = $_POST;
    $return['option'] = get_option('fruitful_options_plugin');

    wp_send_json($return);
    exit;
}
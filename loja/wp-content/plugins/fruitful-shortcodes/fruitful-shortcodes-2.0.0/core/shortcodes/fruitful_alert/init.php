<?php

/**
 * Display alerts shortcode on a front-end part
 **/

if ( ! function_exists( 'display_fruitful_alert_shortcode' ) ) {
	
	function display_fruitful_alert_shortcode( $atts, $content ) {
		
		$default_atts = [
			'color' => 'alert-success',
			'id'    => '',
		];
		
		$default_atts = apply_filters( 'ff_shortcodes_shortcode_default_atts', $default_atts );
		$atts         = shortcode_atts( $default_atts, $atts, 'fruitful_alert' );
		
		wp_enqueue_style( 'ff-fruitful_alert' );
		wp_enqueue_script( 'ff-fruitful_alert' );
		
		
		do_action( 'ff_shortcodes_shortcode_before_view_load', $atts, $content );
		
		return apply_filters( 'fruitful_alert_shortcode', FF_SHORTCODES()->view->load(
			FF_SHORTCODES()->shortcodes_dir . '/' . 'fruitful_alert/view', [
			'atts'    => $atts,
			'content' => $content
		], false, true ) );
		
	}
	
}

add_shortcode( 'fruitful_alert', 'display_fruitful_alert_shortcode' );

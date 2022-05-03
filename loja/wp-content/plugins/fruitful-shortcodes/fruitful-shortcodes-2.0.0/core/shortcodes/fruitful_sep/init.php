<?php

if ( ! function_exists( 'display_fruitful_sep_shortcode' ) ) {
	
	function display_fruitful_sep_shortcode( $atts, $content ) {
		
		$default_atts = [
			'height' => '10',
			'color'  => '#e0e0e0',
			'style'  => ''
		];
		
		$default_atts = apply_filters( 'ff_shortcodes_shortcode_default_atts', $default_atts );
		$atts         = shortcode_atts( $default_atts, $atts, 'fruitful_sep' );
		
		
		do_action( 'ff_shortcodes_shortcode_before_view_load', $atts, $content );
		
		return apply_filters( 'fruitful_sep_shortcode', FF_SHORTCODES()->view->load(
			FF_SHORTCODES()->shortcodes_dir . '/' . 'fruitful_sep/view', [
			'atts' => $atts
		], false, true ) );
		
	}
	
}

add_shortcode( 'fruitful_sep', 'display_fruitful_sep_shortcode' );

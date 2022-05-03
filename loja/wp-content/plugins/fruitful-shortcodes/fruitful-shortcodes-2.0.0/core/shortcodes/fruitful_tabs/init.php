<?php

if ( ! function_exists( 'display_fruitful_tabs_shortcode' ) ) {
	
	function display_fruitful_tabs_shortcode( $atts, $content ) {
		
		$default_atts = [
			'type'       => 'default',
			'resp_break' => 767,
		];
		
		$default_atts = apply_filters( 'ff_shortcodes_shortcode_default_atts', $default_atts );
		$atts         = shortcode_atts( $default_atts, $atts, 'fruitful_tabs' );
		
		wp_enqueue_style( 'ff-fruitful_tabs' );
		wp_enqueue_script( 'ff-fruitful_tabs' );
		
		do_action( 'ff_shortcodes_shortcode_before_view_load', $atts, $content );
		
		return apply_filters( 'fruitful_tabs_shortcode', FF_SHORTCODES()->view->load(
			FF_SHORTCODES()->shortcodes_dir . '/' . 'fruitful_tabs/view', [
			'atts'    => $atts,
			'content' => $content
		], false, true ) );
		
	}
	
}

add_shortcode( 'fruitful_tabs', 'display_fruitful_tabs_shortcode' );

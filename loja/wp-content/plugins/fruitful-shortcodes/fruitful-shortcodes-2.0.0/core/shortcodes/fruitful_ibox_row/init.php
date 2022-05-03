<?php

if ( ! function_exists( 'display_fruitful_ibox_row_shortcode' ) ) {
	
	function display_fruitful_ibox_row_shortcode( $atts, $content ) {
		
		$default_atts = [];
		$default_atts = apply_filters( 'ff_shortcodes_shortcode_default_atts', $default_atts );
		$atts         = shortcode_atts( $default_atts, $atts, 'fruitful_ibox_row' );
		
		wp_enqueue_style( 'ff-shortcodes-grid' );
		
		do_action( 'ff_shortcodes_shortcode_before_view_load', $atts, $content );
		
		return apply_filters( 'fruitful_ibox_row_shortcode', FF_SHORTCODES()->view->load(
			FF_SHORTCODES()->shortcodes_dir . '/' . 'fruitful_ibox_row/view', [
			'atts'    => $atts,
			'content' => $content
		], false, true ) );
		
	}
	
}

add_shortcode( 'fruitful_ibox_row', 'display_fruitful_ibox_row_shortcode' );

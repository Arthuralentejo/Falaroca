<?php

if ( ! function_exists( 'display_fruitful_pbar_shortcode' ) ) {
	
	function display_fruitful_pbar_shortcode( $atts, $content ) {
		
		$default_atts = [];
		$default_atts = apply_filters( 'ff_shortcodes_shortcode_default_atts', $default_atts );
		$atts         = shortcode_atts( $default_atts, $atts, 'fruitful_ibox_row' );
		
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'ff-fruitful_pbar' );
		wp_enqueue_script( 'wow' );
		wp_enqueue_script( 'ff-fruitful_pbar' );
		
		do_action( 'ff_shortcodes_shortcode_before_view_load', $atts, $content );
		
		return apply_filters( 'fruitful_pbar_shortcode', FF_SHORTCODES()->view->load(
			FF_SHORTCODES()->shortcodes_dir . '/' . 'fruitful_pbar/view', [
			'atts'    => $atts,
			'content' => $content
		], false, true ) );
	}
	
}

add_shortcode( 'fruitful_pbar', 'display_fruitful_pbar_shortcode' );

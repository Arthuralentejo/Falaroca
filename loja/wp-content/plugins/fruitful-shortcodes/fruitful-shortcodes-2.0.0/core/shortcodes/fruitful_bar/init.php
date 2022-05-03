<?php

	/**
	 * Single Progress Bar shortcode on a front-end part
	**/

	if( ! function_exists( 'display_fruitful_bar_shortcode') ) {

		function display_fruitful_bar_shortcode( $atts, $content ) {

			$atts = shortcode_atts( [
				'title'		=> '',
				'width'		=> 0,
				'type' 		=> 'success',
				'icon'		=> '',
				'striped'	=> 'off',
				'stripped'	=> 'false'
			], $atts, 'fruitful_bar' );

			return apply_filters( 'fruitful_bar_shortcode', FF_SHORTCODES()->view->load(
				FF_SHORTCODES()->shortcodes_dir . '/' . 'fruitful_bar/view', [
					'atts' => $atts,
					'content' => $content
				], false, true ) );

		}

	}

    add_shortcode( 'fruitful_bar', 'display_fruitful_bar_shortcode' );

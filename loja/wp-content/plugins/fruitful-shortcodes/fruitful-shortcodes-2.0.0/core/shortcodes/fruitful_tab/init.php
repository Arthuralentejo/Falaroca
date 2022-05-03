<?php

	if( ! function_exists( 'display_fruitful_tab_shortcode') ) {

		function display_fruitful_tab_shortcode( $atts, $content ) {

			return apply_filters( 'fruitful_tab_shortcode', FF_SHORTCODES()->view->load(
				FF_SHORTCODES()->shortcodes_dir . '/' . 'fruitful_tab/view', [
					'atts' => $atts,
					'content' => $content
				], false, true ) );

		}

	}

    add_shortcode( 'fruitful_tab', 'display_fruitful_tab_shortcode' );

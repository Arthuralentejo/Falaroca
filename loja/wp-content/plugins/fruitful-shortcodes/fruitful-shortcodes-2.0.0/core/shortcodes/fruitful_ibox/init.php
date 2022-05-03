<?php

	if( ! function_exists( 'display_fruitful_ibox_shortcode') ) {

		function display_fruitful_ibox_shortcode( $atts, $content ) {

			$atts = shortcode_atts( array(
				'column' => 'ffs-two-one',
				'image' => '',
				'title' => '',
				'align' => 'center',
                'styleicon' => '',
                'styletitle' => '',
                'styletext' => '',
                'icon_position' => ''
			), $atts, 'fruitful_ibox' );

			return apply_filters( 'fruitful_ibox_shortcode', FF_SHORTCODES()->view->load(
				FF_SHORTCODES()->shortcodes_dir . '/' . 'fruitful_ibox/view', [
					'atts' => $atts,
					'content' => $content
				], false, true ) );

		}

	}

    add_shortcode( 'fruitful_ibox', 'display_fruitful_ibox_shortcode' );

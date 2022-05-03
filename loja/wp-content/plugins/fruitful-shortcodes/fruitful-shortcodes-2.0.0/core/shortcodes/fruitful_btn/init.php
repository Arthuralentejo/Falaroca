<?php

/**
 * Display button shortcode on a front-end part
 **/

if ( ! function_exists( 'display_fruitful_btn_shortcode' ) ) {

	function display_fruitful_btn_shortcode( $atts, $content ) {

		$default_atts = [
			'id'               => '',
			'link'             => '',
			'target'           => '_self',
			'icon'             => '',
			'icon_position'    => 'right',
			'size'             => 'mini',
			'color'            => 'default',
			'style'            => 'default',
			'radius'           => 2,
			'type'             => 'button',
			'state'            => 'active',
			'text_color'       => '',
			'background_color' => '',
			'border_color' => '',
		];

		$default_atts = apply_filters( 'ff_shortcodes_shortcode_default_atts', $default_atts );
		$atts         = shortcode_atts( $default_atts, $atts, 'fruitful_btn' );

		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'ff-fruitful_btn' );

		$custom_css = '';

		if ( $atts['radius'] <> '' ) {
			$custom_css .= '#' . $atts['id'] . ' { border-radius: ' . absint( $atts['radius'] ) . 'px; }';
		}

		/** pring custom CSS **/
		add_action( 'ff_shortcodes_print_custom_styles', function () use ( $custom_css ) {
			echo $custom_css;
		} );

		do_action( 'ff_shortcodes_shortcode_before_view_load', $atts, $content );

		return apply_filters( 'fruitful_btn_shortcode', FF_SHORTCODES()->view->load(
			FF_SHORTCODES()->shortcodes_dir . '/' . 'fruitful_btn/view', [
			'atts'    => $atts,
			'content' => $content
		], false, true ) );

	}

}

add_shortcode( 'fruitful_btn', 'display_fruitful_btn_shortcode' );

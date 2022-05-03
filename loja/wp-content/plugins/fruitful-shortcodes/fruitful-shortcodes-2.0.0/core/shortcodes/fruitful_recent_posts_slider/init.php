<?php

if ( ! function_exists( 'display_fruitful_recent_posts_slider_shortcode' ) ) {
	
	function display_fruitful_recent_posts_slider_shortcode( $atts, $content ) {
		
		$default_atts =  [
			'title'              => '',
			'posts'              => 4,
			'cat'                => '',
			'style'              => 'default',
			'slides'             => 4,
			'slides_small'       => 2,
			'slides_extra_small' => 1,
			//'show_nav' 					=> 'on',
			'show_thumbs'        => 'on',
			'thumb_width'        => 255,
			'thumb_height'       => 240,
			'thumb_radius'       => 4,
			'show_date'          => 'on',
			'show_header'        => 'on',
			'show_excerpt'       => 'on',
			'excerpt_len'        => 30,
			'show_metadata'      => 'on',
		];
		
		$default_atts = apply_filters( 'ff_shortcodes_shortcode_default_atts', $default_atts );
		$atts         = shortcode_atts( $default_atts, $atts, 'fruitful_recent_posts_slider' );
		
		$q_array = array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => absint( $atts['posts'] ),
			'ignore_sticky_posts' => true
		);
		
		if ( $atts['cat'] <> '' ) {
			$cats_array           = array_filter( explode( ',', $atts['cat'] ) );
			$q_array['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => $cats_array
				)
			);
		}
		
		$posts = new WP_Query( $q_array );
		
		wp_enqueue_style( 'slick' );
		wp_enqueue_style( 'ff-fruitful_recent_posts' );
		wp_enqueue_style( 'ff-fruitful_recent_posts_slider' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'slick' );
		wp_enqueue_script( 'ff-fruitful_recent_posts_slider' );
		
		do_action( 'ff_shortcodes_shortcode_before_view_load', $atts, $content );
		
		return apply_filters( 'fruitful_recent_posts_slider_shortcode', FF_SHORTCODES()->view->load(
			FF_SHORTCODES()->shortcodes_dir . '/' . 'fruitful_recent_posts_slider/view', [
			'atts'        => $atts,
			'posts_query' => $posts
		], false, true ) );
		
	}
	
}

add_shortcode( 'fruitful_recent_posts_slider', 'display_fruitful_recent_posts_slider_shortcode' );

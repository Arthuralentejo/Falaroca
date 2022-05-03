<?php

// enqueue editor styles
add_action( 'enqueue_block_editor_assets', function () {
	
	$block_name = 'fruitful_recent_posts';
	$block_url  = FF_SHORTCODES()->plugin_url . FF_SHORTCODES()->gutenberg_blocks_dir . '/' . $block_name . '/';
	$assets_url = FF_SHORTCODES()->plugin_url . FF_SHORTCODES()->assets_dir . '/' . $block_name . '/';
	
	// Block Scripts
	wp_enqueue_script(
		'fruitful-blocks-recent-posts', // Handle
		$block_url . 'block/block.build.js',
		[ 'wp-editor', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components' ],
		FF_SHORTCODES()->cache_time,
		true
	);
	
	// Block Styles
	wp_enqueue_style(
		'fruitful-blocks-recent-posts', // Handle
		$assets_url . '/css/styles.css',
		[ 'wp-edit-blocks', 'ff-shortcodes-grid' ],
		'b' . FF_SHORTCODES()->cache_time
	);
	
	// Set translations ( since WP 5.0 )
	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations( 'fruitful-blocks-recent-posts', 'ff-shortcodes' );
	}
	
	// pre WP 5.0 with gutenberg plugin
	if ( function_exists( 'gutenberg_get_jed_locale_data' ) ) {
		wp_add_inline_script(
			'fruitful-blocks-recent-posts',
			sprintf(
				'var fruitful_blocks_recent_posts = { localeData: %s };',
				json_encode( gutenberg_get_jed_locale_data( 'ff-shortcodes' ) )
			),
			'before'
		);
	}
	
} );

// load both front-end + back-end assets
add_action( 'enqueue_block_assets', function () {
	
	wp_enqueue_style( 'ff-shortcodes-grid' );
	if ( ! is_admin() ) {
		wp_enqueue_style( 'ff-fruitful_recent_posts' );
	}
	
} );

// register and server-render the block
add_action( 'init', function () {
	
	register_block_type( 'fruitful-blocks/fruitful-recent-posts', [
		'script'          => 'fruitful-blocks-recent-posts',
		'attributes'      => [
			'order'             => [
				'type'    => 'string',
				'default' => 'desc'
			],
			'orderBy'           => [
				'type'    => 'string',
				'default' => 'date'
			],
			'category'          => [
				'type'    => 'string',
				'default' => ''
			],
			'numberOfPosts'     => [
				'type'    => 'number',
				'default' => 4
			],
			'columns'           => [
				'type'    => 'number',
				'default' => 4
			],
			'displayDate'       => [
				'type'    => 'boolean',
				'default' => true
			],
			'displayExcerpt'    => [
				'type'    => 'boolean',
				'default' => true
			],
			'displayHeader'     => [
				'type'    => 'boolean',
				'default' => true
			],
			'displayMetaData'   => [
				'type'    => 'boolean',
				'default' => true
			],
			'displayThumb'      => [
				'type'    => 'boolean',
				'default' => true
			],
			'postExcerptLength' => [
				'type'    => 'number',
				'default' => 30
			],
			'style'             => [
				'type'    => 'string',
				'default' => 'default'
			],
			'thumbBorderRadius' => [
				'type'    => 'number',
				'default' => 4
			],
			'thumbHeight'       => [
				'type'    => 'number',
				'default' => 255
			],
			'thumbWidth'        => [
				'type'    => 'number',
				'default' => 240
			],
		],
		'render_callback' => function ( $attributes ) {
			
			// we use a view file from Shortcodes, so prepare atts regarding used params
			$view_atts = [
				'posts'         => $attributes['numberOfPosts'],
				'cat'           => $attributes['category'],
				'style'         => $attributes['style'],
				'cols'          => $attributes['columns'],
				'show_thumbs'   => $attributes['displayThumb'],
				'thumb_width'   => $attributes['thumbWidth'],
				'thumb_height'  => $attributes['thumbHeight'],
				'thumb_radius'  => $attributes['thumbBorderRadius'],
				'show_date'     => $attributes['displayDate'],
				'show_header'   => $attributes['displayHeader'],
				'show_excerpt'  => $attributes['displayExcerpt'],
				'excerpt_len'   => $attributes['postExcerptLength'],
				'show_metadata' => $attributes['displayMetaData'],
			];
			
			$q_array = [
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'posts_per_page'      => absint( $attributes['numberOfPosts'] ),
				'ignore_sticky_posts' => true
			];
			
			if ( $view_atts['cat'] <> '' ) {
				$cats_array           = array_filter( explode( ',', $view_atts['cat'] ) );
				$q_array['tax_query'] = [
					[
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $cats_array
					]
				];
			}
			
			$posts = new WP_Query( $q_array );
			
			return apply_filters( 'fruitful_recent_posts_shortcode', FF_SHORTCODES()->view->load(
				FF_SHORTCODES()->shortcodes_dir . '/' . 'fruitful_recent_posts/view', [
				'atts'        => $view_atts,
				'posts_query' => $posts
			], false, true ) );
		}
	] );
	
} );
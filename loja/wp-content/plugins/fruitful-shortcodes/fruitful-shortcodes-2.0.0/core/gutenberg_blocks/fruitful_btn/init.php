<?php

// enqueue admin scripts and styles
add_action( 'enqueue_block_editor_assets', function () {
	
	$block_name = 'fruitful_btn';
	$block_url  = FF_SHORTCODES()->plugin_url . FF_SHORTCODES()->gutenberg_blocks_dir . '/' . $block_name . '/';
	$assets_url = FF_SHORTCODES()->plugin_url . FF_SHORTCODES()->assets_dir . '/' . $block_name . '/';
	
	// Block Scripts
	wp_enqueue_script(
		'fruitful-blocks-btn', // Handle
		$block_url . 'block/block.build.js',
		[ 'wp-editor', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components' ],
		FF_SHORTCODES()->cache_time,
		true
	);
	
	// Block Styles
	wp_enqueue_style(
		'fruitful-blocks-btn', // Handle
		$assets_url . '/css/styles.css',
		[ 'wp-edit-blocks' ],
		'b' . FF_SHORTCODES()->cache_time
	);
	
	// Set translations ( since WP 5.0 )
	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations( 'fruitful-blocks-btn', 'ff-shortcodes' );
	}
	
	// pre WP 5.0 with gutenberg plugin
	if ( function_exists( 'gutenberg_get_jed_locale_data' ) ) {
		wp_add_inline_script(
			'fruitful-blocks-btn',
			sprintf(
				'var fruitful_blocks_btn = { localeData: %s };',
				json_encode( gutenberg_get_jed_locale_data( 'ff-shortcodes' ) )
			),
			'before'
		);
	}
	
} );


// load both front-end + back-end assets
add_action( 'enqueue_block_assets', function () {
	
	if ( ! is_admin() ) {
		wp_enqueue_style( 'ff-fruitful_btn' );
		wp_enqueue_script( 'ff-fruitful_btn' );
	}
	
} );


// register the block
add_action( 'admin_init', function () {
	
	register_block_type( 'fruitful-blocks/fruitful-btn', [
		'script' => 'fruitful-blocks-btn',
	] );
	
} );
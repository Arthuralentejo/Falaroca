<?php

// enqueue editor styles
add_action( 'enqueue_block_editor_assets', function () {
	
	$block_name = 'fruitful_tabs';
	$block_url  = FF_SHORTCODES()->plugin_url . FF_SHORTCODES()->gutenberg_blocks_dir . '/' . $block_name . '/';
	$assets_url = FF_SHORTCODES()->plugin_url . FF_SHORTCODES()->assets_dir . '/' . $block_name . '/';
	
	// Block Scripts
	wp_enqueue_script( 'ff-fruitful_tabs' );
	
	wp_enqueue_script(
		'fruitful-blocks-tabs', // Handle
		$block_url . 'block/block.build.js',
		[ 'wp-editor', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components' ],
		FF_SHORTCODES()->cache_time,
		true
	);
	
	// Block Styles
	wp_enqueue_style(
		'fruitful_tabs',
		null,
		[ 'wp-edit-blocks' ],
		'b' . FF_SHORTCODES()->cache_time
	);
	
	// Set translations ( since WP 5.0 )
	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations( 'fruitful-blocks-tabs', 'ff-shortcodes' );
	}
	
	// pre WP 5.0 with gutenberg plugin
	if ( function_exists( 'gutenberg_get_jed_locale_data' ) ) {
		wp_add_inline_script(
			'fruitful-blocks-tabs',
			sprintf(
				'var fruitful_blocks_tabs = { localeData: %s };',
				json_encode( gutenberg_get_jed_locale_data( 'ff-shortcodes' ) )
			),
			'before'
		);
	}
	
} );

// load both front-end + back-end assets
add_action( 'enqueue_block_assets', function () {
	
	wp_enqueue_style( 'ff-fruitful_tabs' );
	wp_enqueue_script( 'ff-fruitful_tabs' );
	
} );

// register the block
add_action( 'admin_init', function () {
	
	register_block_type( 'fruitful-blocks/fruitful-tabs', [
		'script' => 'fruitful-blocks-tabs',
	] );
	
} );
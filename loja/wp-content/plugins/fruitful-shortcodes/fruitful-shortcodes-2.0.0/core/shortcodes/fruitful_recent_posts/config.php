<?php

/**
 * This file used to build a form
 * in modal window
 * config is an array with form options
 **/

$cfg = array(
	'title'     => esc_html__( 'Recent posts', 'ff_shortcodes' ),
	'desc'      => esc_html__( 'Add recent posts', 'ff_shortcodes' ),
	'shortcode' => 'fruitful_recent_posts',
	'tabs'      => true,
	'query'     => array(
		'tab_title' => esc_html__( 'Query', 'ff_shortcodes' ),
		'fields'    => array(
			
			array(
				'type'  => 'textfield',
				'name'  => 'posts',
				'label' => esc_html__( 'Posts count', 'ff_shortcodes' ),
				'value' => 4,
			),
			array(
				'type'  => 'textarea',
				'name'  => 'cat',
				'label' => esc_html__( 'Categories', 'ff_shortcodes' ),
				'desc'  => esc_html__( 'Explode multiple categories by comma', 'ff_shortcodes' ),
				'value' => '',
			),
		
		),
	),
	'style'     => array(
		'tab_title' => esc_html__( 'Style', 'ff_shortcodes' ),
		'fields'    => array(
			
			array(
				'type'  => 'radio',
				'name'  => 'style',
				'label' => esc_html__( 'Style', 'ff_shortcodes' ),
				'value' => array(
					'default'  => esc_html__( 'Clean', 'ff_shortcodes' ),
					'bordered' => esc_html__( 'Bordered', 'ff_shortcodes' ),
				),
			),
			array(
				'type'  => 'dropdown',
				'name'  => 'cols',
				'label' => esc_html__( 'Columns', 'ff_shortcodes' ),
				'value' => array(
					'1' => esc_html__( 'One', 'ff_shortcodes' ),
					'2' => esc_html__( 'Two', 'ff_shortcodes' ),
					'3' => esc_html__( 'Three', 'ff_shortcodes' ),
					'4' => esc_html__( 'Four', 'ff_shortcodes' ),
				),
			),
			array(
				'type'    => 'switcher',
				'name'    => 'show_thumbs',
				'default' => 'on',
				'label'   => esc_html__( 'Display thumbnails', 'ff_shortcodes' ),
			),
			array(
				'type'  => 'text_unit',
				'name'  => 'thumb_width',
				'label' => esc_html__( 'Thumbnail width', 'ff_shortcodes' ),
				'unit'  => 'px',
				'value' => '255',
			),
			array(
				'type'  => 'text_unit',
				'name'  => 'thumb_height',
				'label' => esc_html__( 'Thumbnail height', 'ff_shortcodes' ),
				'unit'  => 'px',
				'value' => '240',
			),
			array(
				'type'  => 'text_unit',
				'name'  => 'thumb_radius',
				'label' => esc_html__( 'Thumbnail border radius', 'ff_shortcodes' ),
				'unit'  => 'px',
				'value' => '4',
			),
			array(
				'type'    => 'switcher',
				'name'    => 'show_date',
				'default' => 'on',
				'label'   => esc_html__( 'Display post date', 'ff_shortcodes' ),
			),
			array(
				'type'    => 'switcher',
				'name'    => 'show_header',
				'default' => 'on',
				'label'   => esc_html__( 'Display header', 'ff_shortcodes' ),
			),
			array(
				'type'    => 'switcher',
				'name'    => 'show_excerpt',
				'default' => 'on',
				'label'   => esc_html__( 'Display excerpt', 'ff_shortcodes' ),
			),
			array(
				'type'  => 'text_unit',
				'name'  => 'excerpt_len',
				'label' => esc_html__( 'Excerpt length', 'ff_shortcodes' ),
				'unit'  => 'words',
				'value' => '30',
			),
			array(
				'type'    => 'switcher',
				'name'    => 'show_metadata',
				'default' => 'on',
				'label'   => esc_html__( 'Display meta data', 'ff_shortcodes' ),
			),
		
		)
	),
	
);
// config can be extended with common tabs
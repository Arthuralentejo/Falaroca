<?php

/**
 * This file used to build a form
 * in a modal window
 * The config is an array with form options / control types
 **/

$cfg = array(
	'title'     => esc_html__( 'Promo Text', 'ff_shortcodes' ),
	'desc'      => esc_html__( 'Add promo text box', 'ff_shortcodes' ),
	'shortcode' => 'fruitful_dbox',
	'tabs'      => true,
	'general'   => array(
		'tab_title' => esc_html__( 'General', 'ff_shortcodes' ),
		'fields'    => array(
			array(
				'type'  => 'textfield',
				'name'  => 'small_heading',
				'label' => esc_html__( 'Small Heading', 'ff_shortcodes' ),
			),
			array(
				'type'  => 'textfield',
				'name'  => 'heading',
				'label' => esc_html__( 'Heading', 'ff_shortcodes' ),
			),
			array(
				'type'  => 'textarea',
				'name'  => 'content',
				'label' => esc_html__( 'Text', 'ff_shortcodes' ),
				'value' => esc_html__( 'Hello, world! This is Fruitful Shortcodes plugin.', 'ff_shortcodes' ),
			),
			array(
				'type'  => 'textfield',
				'name'  => 'button_title',
				'label' => esc_html__( 'Button title', 'ff_shortcodes' ),
			),
			array(
				'type'  => 'textfield',
				'name'  => 'button_link',
				'label' => esc_html__( 'Button link', 'ff_shortcodes' ),
			),
			array(
				'type'  => 'dropdown',
				'name'  => 'style',
				'label' => esc_html__( 'Block style', 'ff_shortcodes' ),
				'value' => array(
					'style-1' => esc_html__( 'Style 1', 'ff_shortcodes' ),
					'style-2' => esc_html__( 'Style 2', 'ff_shortcodes' ),
					'style-3' => esc_html__( 'Style 3', 'ff_shortcodes' ),
				),
			),
		),
	)
);
// config can be extended with common tabs
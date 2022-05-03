<?php

/**
 * This file used to build a form
 * in a modal window
 * The config is an array with form options / control types
 **/

$cfg = array(
	'title'     => esc_html__( 'Separator', 'ff_shortcodes' ),
	'desc'      => esc_html__( 'Add a gap', 'ff_shortcodes' ),
	'shortcode' => 'fruitful_sep',
	'tabs'      => true,
	'general'   => array(
		'tab_title' => esc_html__( 'General', 'ff_shortcodes' ),
		'fields'    => array(
			array(
				'type'  => 'text_unit',
				'name'  => 'height',
				'label' => esc_html__( 'Separator height', 'ff_shortcodes' ),
				'unit'  => 'px',
				'value' => '10',
			),
			array(
				'type'  => 'color_picker',
				'name'  => 'color',
				'label' => esc_html__( 'Color', 'ff_shortcodes' ),
				'value' => '#e0e0e0',
			),
			array(
				'type'  => 'textfield',
				'name'  => 'style',
				'label' => esc_html__( 'Style', 'ff_shortcodes' ),
			),
		),
	)
);
// config can be extended with common tabs
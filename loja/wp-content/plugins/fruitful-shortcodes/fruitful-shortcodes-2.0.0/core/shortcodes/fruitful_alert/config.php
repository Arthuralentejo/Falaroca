<?php

/**
 * This file used to build a form
 * in a modal window
 * The config is an array with form options / control types
 **/

$cfg = array(
	'title'     => esc_html__( 'Alert', 'ff_shortcodes' ),
	'desc'      => esc_html__( 'Add alert box', 'ff_shortcodes' ),
	'shortcode' => 'fruitful_alert',
	'tabs'      => true,
	'general'   => array(
		'tab_title' => esc_html__( 'General', 'ff_shortcodes' ),
		'fields'    => array(
			array(
				'type'  => 'radio',
				'name'  => 'color',
				'label' => esc_html__( 'Alert style', 'ff_shortcodes' ),
				'value' => array(
					'alert-success' => esc_html__( 'Success', 'ff_shortcodes' ),
					'alert-info'    => esc_html__( 'Info', 'ff_shortcodes' ),
					'alert-warning' => esc_html__( 'Warning', 'ff_shortcodes' ),
					'alert-danger'  => esc_html__( 'Danger', 'ff_shortcodes' ),
				),
			),
			array(
				'type'  => 'textarea',
				'name'  => 'content',
				'label' => esc_html__( 'Alert text', 'ff_shortcodes' ),
				'value' => esc_html__( 'Oh snap! Change a few things up and try submitting again.', 'ff_shortcodes' ),
			),
			array(
				'type'  => 'textfield',
				'name'  => 'id',
				'label' => esc_html__( 'Shortcode ID', 'ff_shortcodes' ),
			),
		)
	)
);
// config can be extended with common tabs

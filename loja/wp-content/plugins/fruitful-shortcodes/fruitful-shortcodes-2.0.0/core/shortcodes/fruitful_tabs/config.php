<?php

/**
 * This file used to build a form
 * in modal window
 * config is an array with form options
 **/

$cfg = array(
	'title'        => esc_html__( 'Tabs', 'ff_shortcodes' ),
	'desc'         => esc_html__( 'Add horizontal tabs', 'ff_shortcodes' ),
	'shortcode'    => 'fruitful_tabs',
	'tabs'         => true,
	'tabs_content' => array(
		'tab_title' => esc_html__( 'Tabs Content', 'ff_shortcodes' ),
		'fields'    => array(
			array(
				'type'      => 'dynamic',
				'count'     => 3,
				'shortcode' => 'fruitful_tab',
				'row_title' => esc_html__( 'My tab title', 'ff_shortcodes' ),
				'fields'    => array(
					
					array(
						'type'        => 'textfield',
						'name'        => 'title',
						'css_classes' => array(
							'ff-row-title'
						),
						'label'       => esc_html__( 'Tab title', 'ff_shortcodes' ),
						'value'       => esc_html__( 'My tab title', 'ff_shortcodes' ),
					),
					array(
						'type'  => 'textarea',
						'name'  => 'content',
						'label' => esc_html__( 'Tab content', 'ff_shortcodes' ),
						'value' => esc_html__( 'Type here your text inside tab', 'ff_shortcodes' ),
					),
				
				),
			),
		)
	),
	'settings'     => array(
		'tab_title' => esc_html__( 'Settings', 'ff_shortcodes' ),
		'fields'    => array(
			array(
				'type'  => 'dropdown',
				'name'  => 'type',
				'label' => esc_html__( 'Tabs type', 'ff_shortcodes' ),
				'value' => array(
					'default'   => esc_html__( 'Horizontal tabs', 'ff_shortcodes' ),
					'vertical'  => esc_html__( 'Vertical tabs', 'ff_shortcodes' ),
					'accordion' => esc_html__( 'Accordion', 'ff_shortcodes' ),
				),
			),
			array(
				'type'  => 'textfield',
				'name'  => 'resp_break',
				'label' => esc_html__( 'Responsive break', 'ff_shortcodes' ),
				'value' => '767',
				'desc'  => esc_html__( 'type here a screen width when tabs become responsive', 'ff_shortcodes' ),
			),
		)
	),
);
// config can be extended with common tabs

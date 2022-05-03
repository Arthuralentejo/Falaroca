<?php

/**
 * This file used to build a form
 * in a modal window
 * The config is an array with form options / control types
 **/

$cfg = array(
	'title'     => esc_html__( 'Progress bar', 'ff_shortcodes' ),
	'desc'      => esc_html__( 'Add progress bar', 'ff_shortcodes' ),
	'shortcode' => 'fruitful_pbar',
	'tabs'      => true,
	'general'   => array(
		'tab_title' => esc_html__( 'General', 'ff_shortcodes' ),
		'fields'    => array(
			array(
				'type'      => 'dynamic',
				'count'     => 3,
				'shortcode' => 'fruitful_bar',
				'row_title' => esc_html__( 'Progress bar', 'ff_shortcodes' ),
				
				'fields' => array(
					
					array(
						'type'  => 'textfield',
						'name'  => 'title',
						'label' => esc_html__( 'Bar title', 'ff_shortcodes' ),
						'value' => esc_html__( 'My title', 'ff_shortcodes' ),
					),
					array(
						'type'  => 'text_unit',
						'name'  => 'width',
						'label' => esc_html__( 'Bar width', 'ff_shortcodes' ),
						'unit'  => '%',
						'value' => '70',
					),
					array(
						'type'  => 'dropdown',
						'name'  => 'type',
						'label' => esc_html__( 'Bar type', 'ff_shortcodes' ),
						'value' => array(
							'success' => esc_html__( 'Success', 'ff_shortcodes' ),
							'info'    => esc_html__( 'Info', 'ff_shortcodes' ),
							'warning' => esc_html__( 'Warning', 'ff_shortcodes' ),
							'danger'  => esc_html__( 'Danger', 'ff_shortcodes' ),
						),
					),
					array(
						'type'  => 'icon_picker',
						'name'  => 'icon',
						'label' => esc_html__( 'Icon', 'ff_shortcodes' ),
					),
					array(
						'type'    => 'switcher',
						'name'    => 'striped',
						'default' => 'off',
						'label'   => esc_html__( 'Stripped', 'ff_shortcodes' ),
					),
				
				),
			),
		),
	)

);
// config can be extended with common tabs
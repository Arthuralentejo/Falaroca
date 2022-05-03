<?php

/**
 * This file used to build a form
 * in modal window
 * config is an array with form options
 **/

$cfg = array(
	'title'     => esc_html__( 'Columns', 'ff_shortcodes' ),
	'desc'      => esc_html__( 'Add columns grid', 'ff_shortcodes' ),
	'shortcode' => 'fruitful_ibox_row',
	'tabs'      => true,
	'general'   => array(
		'tab_title' => esc_html__( 'General', 'ff_shortcodes' ),
		'fields'    => array(
			array(
				'type'      => 'dynamic',
				'count'     => 2,
				'shortcode' => 'fruitful_ibox',
				'row_title' => esc_html__( 'Column', 'ff_shortcodes' ),
				'fields'    => array(
					
					array(
						'type'  => 'dropdown',
						'name'  => 'column',
						'label' => esc_html__( 'Column width', 'ff_shortcodes' ),
						'value' => array(
							'ffs-two-one'    => esc_html__( '1/2', 'ff_shortcodes' ),
							'ffs-three-one'  => esc_html__( '1/3', 'ff_shortcodes' ),
							'ffs-three-two'  => esc_html__( '2/3', 'ff_shortcodes' ),
							'ffs-four-one'   => esc_html__( '1/4', 'ff_shortcodes' ),
							'ffs-four-three' => esc_html__( '3/4', 'ff_shortcodes' ),
							'ffs-five-one'   => esc_html__( '1/5', 'ff_shortcodes' ),
						),
					),
					array(
						'type'  => 'image',
						'name'  => 'image',
						'label' => esc_html__( 'Column image', 'ff_shortcodes_pro' ),
					),
					array(
						'type'        => 'textfield',
						'name'        => 'icon',
						'css_classes' => array(
							'ff-row-title'
						),
						'label'       => esc_html__( 'Icon', 'ff_shortcodes' ),
						'value'       => 'fa-check-square-o',
					),
					array(
						'type'        => 'textfield',
						'name'        => 'title',
						'css_classes' => array(
							'ff-row-title'
						),
						'label'       => esc_html__( 'Column title', 'ff_shortcodes' ),
						'value'       => esc_html__( 'Column', 'ff_shortcodes' ),
					),
					array(
						'type'  => 'textarea',
						'name'  => 'content',
						'label' => esc_html__( 'Column content', 'ff_shortcodes' ),
						'value' => esc_html__( 'Type here your text inside column', 'ff_shortcodes' ),
					),
					array(
						'type'  => 'dropdown',
						'name'  => 'align',
						'label' => esc_html__( 'Content align', 'ff_shortcodes' ),
						'value' => array(
							'center' => esc_html__( 'Center', 'ff_shortcodes' ),
							'left'   => esc_html__( 'Left', 'ff_shortcodes' ),
							'right'  => esc_html__( 'Right', 'ff_shortcodes' ),
						),
					),
					
					array(
						'type'  => 'dropdown',
						'name'  => 'icon_position ',
						'label' => esc_html__( 'Icon position', 'ff_shortcodes' ),
						'value' => array(
							'center' => esc_html__( 'Center', 'ff_shortcodes' ),
							'left'   => esc_html__( 'Left', 'ff_shortcodes' ),
							'right'  => esc_html__( 'Right', 'ff_shortcodes' ),
						),
					),
					array(
						'type'  => 'textfield',
						'name'  => 'styleicon',
						'label' => esc_html__( 'Icon styles', 'ff_shortcodes' ),
					),
					array(
						'type'  => 'textfield',
						'name'  => 'styletitle',
						'label' => esc_html__( 'Title styles', 'ff_shortcodes' ),
					),
					array(
						'type'  => 'textfield',
						'name'  => 'styletext',
						'label' => esc_html__( 'Text styles', 'ff_shortcodes' ),
					),
				
				),
			),
		)
	),
);
// config can be extended with common tabs
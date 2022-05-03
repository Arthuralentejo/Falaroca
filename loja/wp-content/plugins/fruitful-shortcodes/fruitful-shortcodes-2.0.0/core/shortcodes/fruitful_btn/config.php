<?php

/**
 * This file used to build a form
 * in a modal window
 * The config is an array with form options / control types
 **/

$cfg = array(
	'title'     => esc_html__( 'Button', 'ff_shortcodes' ),
	'desc'      => esc_html__( 'Add button', 'ff_shortcodes' ),
	'shortcode' => 'fruitful_btn',
	'tabs'      => true,
	'general'   => array(
		'tab_title' => esc_html__( 'General', 'ff_shortcodes' ),
		'fields'    => array(
			array(
				'type'  => 'textfield',
				'name'  => 'content',
				'label' => esc_html__( 'Button label', 'ff_shortcodes' ),
				'value' => esc_html__( 'Click me', 'ff_shortcodes' ),
				'desc'  => esc_html__( 'type here button label', 'ff_shortcodes' ),
			),
			array(
				'type'  => 'textfield',
				'name'  => 'link',
				'label' => esc_html__( 'Button link', 'ff_shortcodes' ),
				'value' => 'http://google.com',
			),
			array(
				'type'  => 'dropdown',
				'name'  => 'target',
				'label' => esc_html__( 'Link target', 'ff_shortcodes' ),
				'value' => array(
					'_self'  => esc_html__( 'Current window', 'ff_shortcodes' ),
					'_blank' => esc_html__( 'New window', 'ff_shortcodes' ),
				),
			),
			array(
				'type'  => 'icon_picker',
				'name'  => 'icon',
				'label' => esc_html__( 'Button Icon', 'ff_shortcodes' ),
				'desc'  => esc_html__( 'Icon can be applied only for "Button" or "Link" button type', 'ff_shortcodes' ),
			),
			array(
				'type'  => 'radio',
				'name'  => 'icon_position',
				'label' => esc_html__( 'Icon position', 'ff_shortcodes' ),
				'value' => array(
					'right' => esc_html__( 'Right', 'ff_shortcodes' ),
					'left'  => esc_html__( 'Left', 'ff_shortcodes' ),
				),
				'desc'  => esc_html__( 'Icon can be applied only for "Button" or "Link" button type', 'ff_shortcodes' ),
			),
			array(
				'type'  => 'textfield',
				'name'  => 'id',
				'label' => esc_html__( 'Button ID', 'ff_shortcodes' ),
				'value' => 'ff-btn-' . uniqid(),
			),
		)
	),
	'style'     => array(
		'tab_title' => esc_html__( 'Style', 'ff_shortcodes' ),
		'fields'    => array(
			array(
				'type'  => 'dropdown',
				'name'  => 'size',
				'label' => esc_html__( 'Size', 'ff_shortcodes' ),
				'value' => array(
					'mini'        => esc_html__( 'Mini', 'ff_shortcodes' ),
					'small'       => esc_html__( 'Small', 'ff_shortcodes' ),
					'large'       => esc_html__( 'Large', 'ff_shortcodes' ),
					'extra-large' => esc_html__( 'Extra Large', 'ff_shortcodes' ),
				),
			),
			array(
				'type'  => 'dropdown',
				'name'  => 'color',
				'label' => esc_html__( 'Color', 'ff_shortcodes' ),
				'value' => array(
					'default'   => esc_html__( 'Default', 'ff_shortcodes' ),
					'primary'   => esc_html__( 'Primary', 'ff_shortcodes' ),
					'info'      => esc_html__( 'Info', 'ff_shortcodes' ),
					'success'   => esc_html__( 'Success', 'ff_shortcodes' ),
					'secondary' => esc_html__( 'Secondary', 'ff_shortcodes' ),
					'warning'   => esc_html__( 'Warning', 'ff_shortcodes' ),
					'danger'    => esc_html__( 'Danger', 'ff_shortcodes' ),
					'inverse'   => esc_html__( 'Inverse', 'ff_shortcodes' ),
				),
			),
			array(
				'type'  => 'color_picker',
				'name'  => 'text_color',
				'label' => esc_html__( 'Text Color', 'ff_shortcodes' ),
				'value' => '#fff',
			),
			array(
				'type'  => 'color_picker',
				'name'  => 'background_color',
				'label' => esc_html__( 'Background Color', 'ff_shortcodes' ),
			),
			array(
				'type'  => 'color_picker',
				'name'  => 'border_color',
				'label' => esc_html__( 'Border Color', 'ff_shortcodes' ),
			),
			array(
				'type'  => 'radio',
				'name'  => 'style',
				'label' => esc_html__( 'Style', 'ff_shortcodes' ),
				'value' => array(
					'default' => esc_html__( 'Filled', 'ff_shortcodes' ),
					'outline' => esc_html__( 'Outline', 'ff_shortcodes' ),
				),
			),
			array(
				'type'  => 'text_unit',
				'name'  => 'radius',
				'label' => esc_html__( 'Border Radius', 'ff_shortcodes' ),
				'unit'  => 'px',
				'value' => '4',
			),
			array(
				'type'  => 'dropdown',
				'name'  => 'type',
				'label' => esc_html__( 'Type', 'ff_shortcodes' ),
				'value' => array(
					'button' => esc_html__( 'Button', 'ff_shortcodes' ),
					'link'   => esc_html__( 'Link', 'ff_shortcodes' ),
					'input'  => esc_html__( 'Input', 'ff_shortcodes' ),
					'submit' => esc_html__( 'Submit', 'ff_shortcodes' ),
				),
			),
			array(
				'type'  => 'dropdown',
				'name'  => 'state',
				'label' => esc_html__( 'State', 'ff_shortcodes' ),
				'value' => array(
					'active'   => esc_html__( 'Active', 'ff_shortcodes' ),
					'disabled' => esc_html__( 'Disabled', 'ff_shortcodes' ),
				),
			),
		
		)
	)
);
// config can be extended with common tabs

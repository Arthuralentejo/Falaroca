<?php

	namespace ffshortcodes\controller;
	use ffshortcodes\helper\utils;

	/**
	 * Front-end part of plugin
	**/

	class front {

		public function __construct() {

			// load scripts and styles
			add_action( 'wp_enqueue_scripts', [ $this, 'load_assets' ] );

			// load custom styles
			add_action( 'wp_footer', [ $this, 'load_custom_styles' ] );
			
			// Add default attributes related to common tabs - front, init
			add_filter( 'ff_shortcodes_shortcode_default_atts', [ $this, 'add_common_tabs_default_atts' ] );
			
			// Enqueue styles and scripts related to common tabs - front, init 
			add_action( 'ff_shortcodes_shortcode_before_view_load', [ $this, 'enqueue_common_tabs_front_assets' ], 10, 2 );
			
			// Add shortcode wrap attrs - front, view
			add_filter( 'ff_shortcodes_shortcode_wrap_attrs', [ $this, 'add_shortcode_wrap_attrs' ], 10, 2 );
			
			// Blocks scripts and styles
			add_action( 'enqueue_block_assets', [ $this, 'blocks_assets' ] );

		}

		/**
		 * Load JavaScript and CSS files in a front-end
		**/
		public function load_assets() {

			// CSS styles
			wp_register_style( 'font-awesome', FF_SHORTCODES()->plugin_url . 'assets/libs/fontawesome/css/font-awesome.min.css', false, FF_SHORTCODES()->cache_time );
			wp_register_style( 'slick', FF_SHORTCODES()->plugin_url . 'assets/libs/slick/slick.css', false, FF_SHORTCODES()->cache_time );
			wp_register_style( 'ff-shortcodes-grid', FF_SHORTCODES()->plugin_url . 'assets/libs/bootstrap/bootstrap-grid.min.css', false, FF_SHORTCODES()->cache_time );
			wp_register_style( 'aos', FF_SHORTCODES()->plugin_url . 'assets/libs/aos/aos.min.css', [], FF_SHORTCODES()->cache_time );
			
			wp_enqueue_style( 'ff-google-fonts', '//fonts.googleapis.com/css?family=Raleway:400,500,700', false, FF_SHORTCODES()->cache_time );
			wp_enqueue_style( 'ff-shortcodes', FF_SHORTCODES()->plugin_url . 'assets/css/front.css', false, FF_SHORTCODES()->cache_time );

			$postfix = FF_SHORTCODES()->dev_mode ? '' : '.min';

			utils::register_shortcodes_assets();

			// JS scripts
			wp_register_script( 'wow', FF_SHORTCODES()->plugin_url . 'assets/libs/wow/wow.min.js', [ 'jquery' ], FF_SHORTCODES()->cache_time, true );
			wp_register_script( 'slick', FF_SHORTCODES()->plugin_url . 'assets/libs/slick/slick.min.js', [ 'jquery' ], FF_SHORTCODES()->cache_time, true );
			wp_register_script( 'aos', FF_SHORTCODES()->plugin_url . 'assets/libs/aos/aos.min.js', [], FF_SHORTCODES()->cache_time, true );
			wp_register_script( 'ff-shortcodes-animation', FF_SHORTCODES()->plugin_url . 'assets/js/animation.js', ['aos'], FF_SHORTCODES()->cache_time, true );
			wp_enqueue_script( 'ff-shortcodes', FF_SHORTCODES()->plugin_url . 'assets/js/front' . $postfix . '.js', [ 'jquery' ], FF_SHORTCODES()->cache_time, true );

		}

		/**
		 * Load custom styles generated based on user settings
		**/
		public function load_custom_styles() {
			?>
			<!-- Fruitful Shortcodes Custom Styles -->
			<style>
			<?php do_action( 'ff_shortcodes_print_custom_styles'); ?>
			</style>
			<?php
		}
		
		
		/**
		 * Add default attributes related to common tabs
		 */
		public function add_common_tabs_default_atts( $atts ) {
			
			$default_atts = [
				// Animation
				'animation'          => '',
				'animation_offset'   => '',
				'animation_delay'    => '',
				'animation_duration' => '',
				'animation_easing'   => '',
				'animation_once'     => '',
			];
			
			return array_merge( $default_atts, $atts );
		}
		
		
		/**
		 * Enqueue styles and scripts related to common tabs
		 */
		public function enqueue_common_tabs_front_assets( $atts, $content ) {
			
			// Animation
			if ( ! empty( $atts['animation'] ) ) {
				wp_enqueue_style( 'aos' );
				wp_enqueue_script( 'aos' );
				wp_enqueue_script( 'ff-shortcodes-animation' );
			}
			
		}
		
		
		/**
		 * Add shortcode wrap attrs
		 */
		public function add_shortcode_wrap_attrs( $attributes, $data ) {
			
			// Animation
			
			$animation          = ! empty( $data['atts']['animation'] ) ? trim( $data['atts']['animation'] ) : '';
			$animation_offset   = ! empty( $data['atts']['animation_offset'] ) ? trim( $data['atts']['animation_offset'] ) : '';
			$animation_delay    = isset( $data['atts']['animation_delay'] ) ? trim( $data['atts']['animation_delay'] ) : '';
			$animation_duration = ! empty( $data['atts']['animation_duration'] ) ? trim( $data['atts']['animation_duration'] ) : '';
			$animation_easing   = ! empty( $data['atts']['animation_easing'] ) ? trim( $data['atts']['animation_easing'] ) : '';
			$animation_once     = ! empty( $data['atts']['animation_once'] ) ? trim( $data['atts']['animation_once'] ) : '';
			
			
			if ( $animation ) {
				
				$attributes[] = 'data-aos="' . esc_attr( $animation ) . '"';
				
				if ( $animation_offset ) {
					$attributes[] = 'data-aos-offset="' . absint( $animation_offset ) . '"';
				}
				
				if ( $animation_delay ) {
					$attributes[] = 'data-aos-delay="' . absint( $animation_delay ) . '"';
				}
				
				if ( $animation_duration ) {
					$attributes[] = 'data-aos-duration="' . absint( $animation_duration ) . '"';
				}
				
				if ( $animation_easing ) {
					$attributes[] = 'data-aos-easing="' . esc_attr( $animation_easing ) . '"';
				}
				
				if ( $animation_once && $animation_once === 'true' ) {
					$attributes[] = 'data-aos-once="true"';
				}
			}
			
			return $attributes;
		}
	
		
		
		/**
		 * Blocks assets
		**/
		function blocks_assets() {
			$this->load_assets();
		}

	}

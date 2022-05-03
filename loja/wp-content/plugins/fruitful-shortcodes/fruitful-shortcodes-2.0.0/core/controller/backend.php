<?php

namespace ffshortcodes\controller;

use ffshortcodes\helper\utils;

/**
 * Back-end part of plugin
 **/
class backend {
	
	function __construct() {
		
		// load assets for admin side
		add_action( 'admin_enqueue_scripts', [ $this, 'load_assets' ] );
		
		// add "Fruitful Shortcodes" button to TinyMCE - external plugin
		add_filter( 'mce_external_plugins', [ $this, 'add_mce_editor_plugin' ] );
		
		// add "Fruitful Shortcodes" button to TinyMCE  - external plugins buttons area
		add_action( 'mce_buttons', [ $this, 'add_mce_editor_button'] );

		// load primary modal window through AJAX
		add_action( 'wp_ajax_ff_shortcodes_load_modal', [ $this, 'ajax_load_modal' ] );
		
		// load shortocode into modal window
		add_action( 'wp_ajax_ff_shortcodes_load_shortcode', [ $this, 'ajax_load_shortcode' ] );
		
		// promo screen to buy pro version
		add_action( 'wp_ajax_ff_shortcodes_load_modal_promo', [ $this, 'ajax_load_promo_screen' ] );
		
		// Allow additional mime types (SVG)
		add_filter( 'upload_mimes', [ $this, 'add_upload_types' ] );
		
		// fix SVG thumbs in admin
		add_action( 'admin_init', [ $this, 'fix_svg_thumbs' ] );
		add_filter( 'wp_prepare_attachment_for_js', [ $this, 'fix_svgs_response_for_svg' ], 10, 3 );
		
		// add links to Plugins screen
		add_filter( 'plugin_action_links_' . plugin_basename( FF_SC_PLUGIN_FILE_ ), [ $this, 'plugin_action_links' ] );
		add_filter( 'plugin_row_meta', [ $this, 'add_plugins_screen_links' ], 10, 2 );
		
		// register plugin settings
		add_action( 'admin_init', [ $this, 'register_plugin_settings' ] );
		
		// Add action save plugin settings to update ffc stat option
		add_action( 'fruitful_shortcodes_plugin_setting_save', [ $this, 'save_plugin_settings' ] );
		
		// add settings menu
		add_action( 'admin_menu', [ $this, 'add_menu' ] );
		
		// Add default attributes related to common tabs
		add_filter( 'ff_shortcodes_get_common_tabs', [ $this, 'add_common_tabs' ], 10, 2 );
		
		// add block category
		add_filter( 'block_categories', [ $this, 'add_block_category' ] );
		
		// add block editor assets
		add_action( 'enqueue_block_editor_assets', [ $this, 'block_editor_assets' ] );
		
	}
	
	
	/**
	 * Add scripts and styles
	 **/
	function load_assets() {
		
		wp_register_script( 'wow', FF_SHORTCODES()->plugin_url . 'assets/libs/wow/wow.min.js', [ 'jquery' ], FF_SHORTCODES()->cache_time, true );
		wp_register_script( 'slick', FF_SHORTCODES()->plugin_url . 'assets/libs/slick/slick.min.js', [ 'jquery' ], FF_SHORTCODES()->cache_time, true );
		wp_register_style( 'slick', FF_SHORTCODES()->plugin_url . 'assets/libs/slick/slick.css', false, FF_SHORTCODES()->cache_time );
		
		wp_register_style( 'ff-shortcodes-grid', FF_SHORTCODES()->plugin_url . 'assets/libs/bootstrap/bootstrap-grid.min.css', false, FF_SHORTCODES()->cache_time );
		wp_enqueue_style( 'font-awesome', FF_SHORTCODES()->plugin_url . 'assets/libs/fontawesome/css/font-awesome.min.css' );
		
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'ff-shortcodes-backend', FF_SHORTCODES()->plugin_url . '/assets/css/admin.css' );
		
		wp_enqueue_script( 'serialize-json', FF_SHORTCODES()->plugin_url . 'assets/libs/jquery.serializejson.min.js' );
		wp_register_script( 'ff-shortcodes-fonts', '//ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js', false, FF_SHORTCODES()->cache_time, true );
		wp_register_script( 'nicescroll', FF_SHORTCODES()->plugin_url . '/assets/libs/nicescroll/jquery.nicescroll.min.js', [ 'jquery' ], FF_SHORTCODES()->cache_time, true );
		
		wp_enqueue_script( 'shake-fn', FF_SHORTCODES()->plugin_url . '/assets/js/shake.js', [ 'jquery' ], FF_SHORTCODES()->cache_time, true );
		wp_enqueue_script( 'liveupdate', FF_SHORTCODES()->plugin_url . '/assets/js/liveupdate.js', [ 'jquery' ], FF_SHORTCODES()->cache_time, true );
		
		wp_register_script( 'ff-shortcodes-window', FF_SHORTCODES()->plugin_url . '/assets/js/modal.js', [
			'jquery',
			'liveupdate',
			'nicescroll',
			'ff-shortcodes-fonts'
		], FF_SHORTCODES()->cache_time, true );
		wp_register_script( 'ff-shortcodes-ui', FF_SHORTCODES()->plugin_url . '/assets/js/modal_ui.js', [
			'jquery',
			'wp-color-picker',
			'shake-fn',
			'jquery-ui-sortable',
			'serialize-json'
		], FF_SHORTCODES()->cache_time, true );
		wp_enqueue_script( 'ff-shortcodes', FF_SHORTCODES()->plugin_url . '/assets/js/admin.js', [
			'ff-shortcodes-window',
			'ff-shortcodes-ui'
		], FF_SHORTCODES()->cache_time, true );
		
		utils::register_shortcodes_assets();
		
	}
	
	
	/**
	 * Add "Fruitful Shortcodes" button to TinyMCE- external plugins buttons area
	 **/
	function add_mce_editor_plugin( $plugins ) {
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
			$plugins['ff_shortcodes_button'] = FF_SHORTCODES()->plugin_url . 'assets/js/mce_button.js';
		}
		
		return $plugins;
	}
	
	
	/**
	 * Add "Fruitful Shortcodes" button to TinyMCE - external plugins buttons area
	 **/
	function add_mce_editor_button( $buttons ) {
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
			$buttons[] = 'ff_shortcodes_button';
		}
		
		return $buttons;
	}

	/**
	 * Load modal content
	 **/
	function ajax_load_modal() {
		
		FF_SHORTCODES()->view->load( '/core/view/backend/modal/window', [
			'shortcodes' => FF_SHORTCODES()->shortcodes,
			'is_pro'     => utils::is_pro()
		], true );
		
	}
	
	/**
	 * Load shortcode into modal window
	 **/
	function ajax_load_shortcode() {
		
		$shortcode = sanitize_title( $_POST['data'] );
		
		if ( isset( FF_SHORTCODES()->shortcodes[ $shortcode ] ) ) {
			
			if ( filter_var( FF_SHORTCODES()->shortcodes[ $shortcode ]['is_pro'] ) && function_exists( 'FF_SHORTCODES_PRO' ) ) {
				
				FF_SHORTCODES_PRO()->view->load( FF_SHORTCODES_PRO()->shortcodes_dir . '/' . $shortcode . '/modal', [], true );
				
			} else {
				
				FF_SHORTCODES()->view->load( FF_SHORTCODES()->shortcodes_dir . '/' . $shortcode . '/modal', [], true );
				
			}
			
		}
		
	}
	
	/**
	 * Load promo screen
	 **/
	function ajax_load_promo_screen() {
		FF_SHORTCODES()->view->load( '/core/view/backend/modal/promo', [], true );
	}
	
	/**
	 * Allow additional mime types to upload
	 **/
	function add_upload_types( $existing_mimes ) {
		$existing_mimes['svg']  = 'image/svg+xml';
		$existing_mimes['svgz'] = 'image/svg+xml';
		
		return $existing_mimes;
	}
	
	function fix_svg_thumbs() {
		
		$screen = get_current_screen();
		
		if ( is_object( $screen ) && $screen->id == 'upload' ) {
			
			function ffshortcodes_svgs_fix_thumbs_filter( $content ) {
				
				return apply_filters( 'final_output', $content );
				
			}
			
			ob_start( 'ffshortcodes_svgs_fix_thumbs_filter' );
			
			add_filter( 'final_output', 'ffshortcodes_svgs_fix_final_output' );
			function ffshortcodes_svgs_fix_final_output( $content ) {
				
				$content = str_replace(
					'<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
					'<# } else if ( \'svg+xml\' === data.subtype ) { #>
						<img class="details-image" src="{{ data.url }}" draggable="false" />
						<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
					$content
				);
				
				$content = str_replace(
					'<# } else if ( \'image\' === data.type && data.sizes ) { #>',
					'<# } else if ( \'svg+xml\' === data.subtype ) { #>
						<div class="centered">
							<img src="{{ data.url }}" class="thumbnail" draggable="false" />
						</div>
						<# } else if ( \'image\' === data.type && data.sizes ) { #>',
					$content
				);
				
				return $content;
				
			}
			
		}
		
	}
	
	function fix_svgs_response_for_svg( $response, $attachment, $meta ) {
		if ( $response['mime'] == 'image/svg+xml' && empty( $response['sizes'] ) ) {
			
			$svg_path = get_attached_file( $attachment->ID );
			
			if ( ! file_exists( $svg_path ) ) {
				// If SVG is external, use the URL instead of the path
				$svg_path = $response['url'];
			}
			
			$dimensions = $this->svgs_get_dimensions( $svg_path );
			
			$response['sizes'] = [
				'full' => [
					'url'         => $response['url'],
					'width'       => $dimensions->width,
					'height'      => $dimensions->height,
					'orientation' => $dimensions->width > $dimensions->height ? 'landscape' : 'portrait'
				]
			];
			
		}
		
		return $response;
	}
	
	function svgs_get_dimensions( $svg ) {
		$svg = simplexml_load_file( $svg );
		
		if ( $svg === false ) {
			
			$width  = '0';
			$height = '0';
			
		} else {
			
			$attributes = $svg->attributes();
			$width      = (string) $attributes->width;
			$height     = (string) $attributes->height;
		}
		
		return (object) [ 'width' => $width, 'height' => $height ];
	}
	
	/**
	 * Add links to WP admin > Plugins screen
	 **/
	
	function plugin_action_links( $links ) {
		
		if ( ! FF_SHORTCODES()->is_pro_version_active ) {
			$links['ff_shortcodes_get_pro'] = sprintf( '<a href="%1$s" target="_blank" class="ff-get-pro">%2$s</a>', FF_SHORTCODES()->links['pro_plugin'], __( 'Get Pro Version', 'ff_shortcodes' ) );
		}
		
		return $links;
	}
	
	function add_plugins_screen_links( $links, $file ) {
		
		if ( $file == plugin_basename( FF_SHORTCODES()->plugin_base ) ) {
			$links[] = '<a href="' . FF_SHORTCODES()->links['docs'] . '" target="_blank">' . __( 'Documentation & FAQ', 'ff_shortcodes' ) . '</a>';
			$links[] = '<a href="' . FF_SHORTCODES()->links['support'] . '" target="_blank">' . __( 'Support', 'ff_shortcodes' ) . '</a>';
		}
		
		return $links;
		
	}
	
	/**
	 * Register plugin settings
	 **/
	function register_plugin_settings() {
		//Settings rigister example
		//register_setting( 'ff_shortcodes_settings', [ $this, 'save_plugin_settings' ] );
		
		do_action( 'fruitful_shortcodes_plugin_setting_save' );
	}
	
	/**
	 * Add settings menu
	 **/
	function add_menu() {
		add_submenu_page( 'options-general.php', esc_html__( 'Fruitful Shortcodes Plugin Settings', 'ff_shortcodes' ), esc_html__( 'Fruitful Shortcodes Plugin Settings', 'ff_shortcodes' ), 'administrator', __FILE__, [
			$this,
			'display_settings_page'
		] );
	}
	
	/**
	 * Display plugin's settings page
	 **/
	function display_settings_page() {
		
		/** Default values statistics options */
		$data['ffc_statistic'] = 1;
		$data['ffc_subscribe'] = 0;
		$data['ffc_email']     = '';
		$data['ffc_name']      = '';
		
		/** General statistics option for all fruitfulcode products */
		$ffc_statistics_option = get_option( 'ffc_statistics_option' );
		
		if ( $ffc_statistics_option ) {
			
			if ( isset( $ffc_statistics_option['ffc_statistic'] ) ) {
				$data['ffc_statistic'] = (int) $ffc_statistics_option['ffc_statistic'];
			}
			if ( isset( $ffc_statistics_option['ffc_subscribe'] ) ) {
				$data['ffc_subscribe'] = (int) $ffc_statistics_option['ffc_subscribe'];
			}
			if ( isset( $ffc_statistics_option['ffc_subscribe_email'] ) ) {
				$data['ffc_email'] = $ffc_statistics_option['ffc_subscribe_email'];
			}
			if ( isset( $ffc_statistics_option['ffc_subscribe_name'] ) ) {
				$data['ffc_name'] = $ffc_statistics_option['ffc_subscribe_name'];
			}
		}
		
		if ( function_exists( 'ff_shortcode_version' ) ) {
			$data['fruitful_version'] = ff_shortcode_version();
		}
		
		FF_SHORTCODES()->view->load( '/core/view/settings', $data );
		
	}
	
	/**
	 * Save plugin settings action
	 */
	public function save_plugin_settings() {
		
		$post = $_POST;
		
		if ( ! empty( $post ) ) {
			if ( ! empty( $post['option_page'] ) ) {
				if ( $post['option_page'] === 'ff_shortcodes_settings' ) {
					$ffc_statistics_option = get_option( 'ffc_statistics_option' );
					
					if ( isset( $post['ffc_statistic'] ) ) {
						$ffc_statistics_option['ffc_statistic'] = (int) $post['ffc_statistic'];
					} else {
						$ffc_statistics_option['ffc_statistic'] = 0;
					}
					
					if ( isset( $post['ffc_subscribe'] ) ) {
						$ffc_statistics_option['ffc_subscribe'] = (int) $post['ffc_subscribe'];
					} else {
						$ffc_statistics_option['ffc_subscribe'] = 0;
					}
					
					if ( isset( $post['ffc_subscribe_email'] ) ) {
						$ffc_statistics_option['ffc_subscribe_email'] = $post['ffc_subscribe_email'];
					} else {
						$ffc_statistics_option['ffc_subscribe_email'] = '';
					}
					
					if ( isset( $post['ffc_subscribe_name'] ) ) {
						$ffc_statistics_option['ffc_subscribe_name'] = $post['ffc_subscribe_name'];
					} else {
						$ffc_statistics_option['ffc_subscribe_name'] = '';
					}
					
					update_option( 'ffc_statistics_option', $ffc_statistics_option );
					
					// Plugin version - old | new
					if ( isset( $post['fruitful_version'] ) && in_array( $post['fruitful_version'], array( 'new', 'old' ) ) ) {
						$opt                     = get_option( 'fruitful_options_plugin' );
						$opt['fruitful_version'] = $post['fruitful_version'];
						
						ff_shortcode_update_plugins( $opt['fruitful_version'] );
						
						update_option( 'fruitful_options_plugin', $opt );
					}
				}
			}
		}
	}
	
	
	/**
	 * Get common tabs for all shortcodes
	 */
	public function add_common_tabs( $common_tabs, $config ) {
		
		$common_tabs_add = [];
		
		
		// Animation
		$exclude_animation_shortcodes = ! empty( FF_SHORTCODES()->config['animation']['exclude_animation_shortcodes'] )
			? FF_SHORTCODES()->config['animation']['exclude_animation_shortcodes']
			: [];
		
		if ( ! empty( $config['shortcode'] ) && ! in_array( $config['shortcode'], $exclude_animation_shortcodes, true ) ) {
			
			$common_tabs_add['animation'] = [
				'tab_title' => esc_html__( 'Animation', 'ff_shortcodes' ),
				'fields'    => [
					[
						'type'              => 'dropdown',
						'name'              => 'animation',
						'label'             => esc_html__( 'Animation', 'ff_shortcodes' ),
						'value'             => ! empty( FF_SHORTCODES()->config['animation']['animations_list'] )
							? FF_SHORTCODES()->config['animation']['animations_list']
							: [],
						'first_null_option' => true
					],
					[
						'type'  => 'text_unit',
						'name'  => 'animation_offset',
						'label' => esc_html__( 'Change offset to trigger animations sooner or later (px)', 'ff_shortcodes_pro' ),
						'unit'  => 'px',
						'value' => '',
					],
					[
						'type'              => 'dropdown',
						'name'              => 'animation_delay',
						'label'             => esc_html__( 'Delay animation (ms)', 'ff_shortcodes' ),
						'value'             => ! empty( FF_SHORTCODES()->config['animation']['delay'] )
							? FF_SHORTCODES()->config['animation']['delay']
							: [],
						'first_null_option' => true
					],
					[
						'type'              => 'dropdown',
						'name'              => 'animation_duration',
						'label'             => esc_html__( 'Duration of animation (ms)', 'ff_shortcodes' ),
						'value'             => ! empty( FF_SHORTCODES()->config['animation']['duration'] )
							? FF_SHORTCODES()->config['animation']['duration']
							: [],
						'first_null_option' => true
					],
					[
						'type'              => 'dropdown',
						'name'              => 'animation_easing',
						'label'             => esc_html__( 'Choose timing function to ease elements in different ways', 'ff_shortcodes' ),
						'value'             => ! empty( FF_SHORTCODES()->config['animation']['easing'] )
							? FF_SHORTCODES()->config['animation']['easing']
							: [],
						'first_null_option' => true
					],
					[
						'type'  => 'radio',
						'name'  => 'animation_once',
						'label'   => esc_html__( 'Choose whether animation should fire once, or every time you scroll up/down to element', 'ff_shortcodes' ),
						'value' => [
							'' => esc_html__( 'Every time', 'ff_shortcodes' ),
							'true'  => esc_html__( 'Once', 'ff_shortcodes' ),
						],
						'desc'  => '',
					],
				]
			];
		}
		
		
		return array_merge( $common_tabs, $common_tabs_add );
	}
	
	
	
	/**
	 * Add block category (Gutenberg)
	 */
	public function add_block_category( $categories ) {
		
		$categories[] = [
			'slug'  => 'fruitful-blocks',
			'title' => __( 'Fruitful Blocks', 'ff_shortcodes' ),
			'icon'  => null,
		];
		
		return $categories;
	}
	
	
	/**
	 * Add block editor assets
	 */
	public function block_editor_assets() {
		
		$this->load_assets();
		
		$assets_url = FF_SHORTCODES()->plugin_url . 'assets/';
		
		// Special styles for the Gutenberg Editor
		wp_enqueue_style(
			'fruitful-blocks-editor',
			$assets_url . 'css/blocks_editor.css',
			array( 'wp-edit-blocks' ),
			FF_SHORTCODES()->cache_time
		);
		
	}
}

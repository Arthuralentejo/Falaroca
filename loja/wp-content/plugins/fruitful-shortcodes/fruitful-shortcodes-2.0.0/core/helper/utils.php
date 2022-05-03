<?php

	namespace ffshortcodes\helper;	

	/**
	 * Utils helper
	**/
	class utils {

		/**
		 * Check is pro version active
		**/
		public static function is_pro() {

			return FF_SHORTCODES()->is_pro_version_active;

		}

		/**
		 * Autoload PHP files in directory
		 *
		 * @param $dir
		 * @param int $max_scan_depth
		 * @param string $load_file
		 * @param int $current_depth
		 */
		public static function autoload_dir( $dir, $max_scan_depth = 0, $load_file = '', $current_depth = 0 ) {
			if ( $current_depth > $max_scan_depth ) {
				return;
			}

			// require all php files
			$scan = glob( "$dir" . DIRECTORY_SEPARATOR . "*" );

			foreach ( $scan as $path ) {

				if ( preg_match( '/\.php$/', $path ) ) {

					if ( is_string( $load_file ) && $load_file <> '' ) {

						// load specific file

						$dir  = dirname( $path );
						$file = $dir . '/' . $load_file;

						if ( is_file( $file ) ) {
							require_once $file;
						}

					} else {

						// load all PHP files in folder
						require_once $path;

					}

				} elseif ( is_dir( $path ) ) {

					self::autoload_dir( $path, $max_scan_depth, $load_file, $current_depth + 1 );

				}
			}
		}

		/**
		 * Make sure that Visual Composer is active
		 **/
		public static function is_vc() {
			return in_array( 'js_composer/js_composer.php', \apply_filters( 'active_plugins', \get_option( 'active_plugins' ) ) );
		}

		/**
		 * Check that Gutenberg functions present or plugin active
		 **/
		public static function is_gutenberg() {
			return function_exists( 'register_block_type' ) || in_array( 'gutenberg/gutenberg.php', \apply_filters( 'active_plugins', \get_option( 'active_plugins' ) ), true );
		}
		
		
		/**
		 * Check that Gutenberg enable on current admin page, for hook usage only
		 **/
		public static function is_block_editor() {
			if ( is_admin() ) {
				global $current_screen;
				
				if ( ( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() )
				     ||
				     ( function_exists( 'is_gutenberg_page' ) && is_gutenberg_page() )
				) {
					return true;
				}
			}
			
			return false;
		}
		
		
		
		/**
		 * Register all available assets
		 */
		public static function register_shortcodes_assets() {

			$postfix = FF_SHORTCODES()->dev_mode ? '' : '.min';

			// register scripts and styles for each shortcode
			foreach( FF_SHORTCODES()->shortcodes as $shortcode_name => $data ) {
				$style_file = FF_SHORTCODES()->assets_dir . $shortcode_name . '/css/styles.css';
				$scripts_file = FF_SHORTCODES()->assets_dir . $shortcode_name . '/js/scripts' . $postfix . '.js';
				
				
				if( ! wp_style_is( 'ff-' . $shortcode_name, 'registered' ) && file_exists( FF_SHORTCODES()->plugin_path . $style_file ) ) {
					wp_register_style( 'ff-' . $shortcode_name, FF_SHORTCODES()->plugin_url . $style_file, [], FF_SHORTCODES()->cache_time );
				}

				if( ! wp_script_is( 'ff-' . $shortcode_name, 'registered' ) && file_exists( FF_SHORTCODES()->plugin_path . $scripts_file ) ) {
					wp_register_script( 'ff-' . $shortcode_name, FF_SHORTCODES()->plugin_url . $scripts_file, ['jquery'], FF_SHORTCODES()->cache_time, true);
				}

			}

		}

	}
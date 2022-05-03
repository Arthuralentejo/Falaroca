<?php

	namespace ffshortcodes\view;

	/**
	 * Anything to do with templates
	 * and outputting client code
	**/
	class view {

		function load( $path = '', $data = [], $die = false, $return = false ) {

			// Check for template in theme's path as a first thing
			$theme_dir = get_stylesheet_directory();
			$override_path = $theme_dir . '/fruitful-shortcodes/' . str_replace( FF_SHORTCODES()->shortcodes_dir, '', $path ) . '.php';
			$default_path = FF_SHORTCODES()->plugin_path . $path . '.php';

			if( $return ) {
				ob_start();
			}

			// If user places a template in theme's directory, override default template
			if( file_exists( $override_path ) ) {

				require $override_path;

			// if not, load default template
			} elseif( file_exists( $default_path ) ) {

				require $default_path;

			// if template path doesn't exist
			} else {

				throw new \Exception( 'The view path ' . $path . ' can not be found.' );

			}

			if( $return ) {
				return ob_get_clean();
			}

			if( $die ) {
				die;
			}

		}

	}

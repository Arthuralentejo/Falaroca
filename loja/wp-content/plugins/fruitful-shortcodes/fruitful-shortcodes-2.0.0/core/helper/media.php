<?php

	namespace ffshortcodes\helper;

	/**
	 * Media helper
	**/
	class media {

		/**
		 * Resize image
		 * @return string image path
		 **/
		public static function img_resize( $url, $width, $height ) {

			if( ! class_exists( 'Aq_Resize' )) {
				require_once FF_SHORTCODES()->plugin_path . '/core/vendor/aq_resizer/aq_resizer.php';
			}

			$src = '';
			$src_protocol = substr( $url, 0, 5);
			if ( ! in_array( $src_protocol, [ 'http:', 'https'] ) ) {
				$protocol = \is_ssl() ? 'https:' : 'http:';
				if( $url <> '' ) {
					$url = $protocol . $url;
				}
			}

			$src = \aq_resize( $url, $width, $height, true );

			if( !$src ) {
				$src = $url;
			}

			return $src;

		}

	}
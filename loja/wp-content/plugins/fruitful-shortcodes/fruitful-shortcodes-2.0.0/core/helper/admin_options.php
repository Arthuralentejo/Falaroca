<?php

namespace ffshortcodes\helper;

	/**
	 * Admin options helper
	**/
	class admin_options {

		/**
		 * Header option type
		 * just displays h4 tag with a text
		**/
		public static function header( $config ) {

			$defaults = array(
				'title' => '',
				'css_classes' => array()
			);

			$config = array_replace_recursive( $defaults, $config );

			?>
			<div class="ff-bk-row">
				<h4 class="<?php echo implode(' ', $config['css_classes']); ?>"><?php echo wp_kses_post( $config['title'] ); ?></h4>
			</div>
			<?php
		}

		/**
		 * Hidden option type
		 * invisible in Shortcode Builder form
		**/
		public static function hidden( $config ) {

			$defaults = array(
				'name' => '',
				'value' => '',
				'css_classes' => array()
			);

			$config = array_replace_recursive( $defaults, $config );

			?>
			<input type="hidden" class="<?php echo implode(' ', $config['css_classes']); ?>" name="<?php echo esc_attr( $config['name'] ); ?>" value="<?php echo esc_attr( $config['value'] ); ?>" />
			<?php
		}

		/**
		 * Display text option type
		**/
		public static function textfield( $config ) {

			$defaults = array(
				'label' => '',
				'name' => '',
				'value' => '',
				'desc' => '',
				'heading' => '',
				'css_classes' => array()
			);

			$config = array_replace_recursive( $defaults, $config );

			?>
			<div class="ff-bk-row">

				<?php if( $config['heading'] <> '' ): ?>
					<h4><?php echo wp_kses_post( $config['heading'] ); ?></h4>
				<?php endif; ?>

				<div class="ff-control ff-control-text">

					<?php if( $config['label'] <> '' ): ?>
					<label for="ff-shortcodes-input-<?php echo esc_attr( $config['name'] ); ?>"><?php echo wp_kses_post( $config['label'] ); ?></label>	
					<?php endif; ?>	

					<input class="<?php echo implode(' ', $config['css_classes']); ?>" id="ff-shortcodes-input-<?php echo esc_attr( $config['name'] ); ?>" type="text" name="<?php echo esc_attr( $config['name'] ); ?>" value="<?php echo esc_attr( $config['value'] ); ?>" />
					<?php if( $config['desc'] <> '' ): ?>
						<div class="desc">
							<?php echo wp_kses_post( $config['desc'] ); ?>
						</div>
					<?php endif; ?>
				</div>

			</div>
			<?php
		}

		/**
		 * Display color picker option type
		**/
		public static function color_picker( $config ) {

			$defaults = array(
				'label' => '',
				'name' => '',
				'value' => '',
				'desc' => '',
				'heading' => '',
				'css_classes' => array()
			);

			$config = array_replace_recursive( $defaults, $config );

			?>
			<div class="ff-bk-row">

				<?php if( $config['heading'] <> '' ): ?>
					<h4><?php echo wp_kses_post( $config['heading'] ); ?></h4>
				<?php endif; ?>

				<div class="ff-control ff-control-color-picker">

					<?php if( $config['label'] <> '' ): ?>
					<label for="ff-shortcodes-input-<?php echo esc_attr( $config['name'] ); ?>"><?php echo wp_kses_post( $config['label'] ); ?></label>	
					<?php endif; ?>	

					<div class="ff-picker">
						<div class="color"></div>
						<input class="<?php echo implode(' ', $config['css_classes']); ?>" id="ff-shortcodes-input-<?php echo esc_attr( $config['name'] ); ?>" type="text" name="<?php echo esc_attr( $config['name'] ); ?>" value="<?php echo esc_attr( $config['value'] ); ?>">
					</div>

					<?php if( $config['desc'] <> '' ): ?>
						<div class="desc">
							<?php echo wp_kses_post( $config['desc'] ); ?>
						</div>
					<?php endif; ?>
				</div>

			</div>
			<?php
		}

		/**
		 * Display icon picker option type
		**/
		public static function icon_picker( $config ) {

			$defaults = array(
				'label' => '',
				'name' => '',
				'value' => '',
				'desc' => '',
				'heading' => '',
				'default' => '',
				'css_classes' => array()
			);

			$config = array_replace_recursive( $defaults, $config );

			?>
			<div class="ff-bk-row">

				<?php if( $config['heading'] <> '' ): ?>
					<h4><?php echo wp_kses_post( $config['heading'] ); ?></h4>
				<?php endif; ?>

				<div class="ff-control ff-control-icon-picker <?php echo trim( $config['default'] ) == '' ? 'no-icon' : ''; ?>">

					<?php if( $config['label'] <> '' ): ?>
					<label for="ff-shortcodes-input-<?php echo esc_attr( $config['name'] ); ?>"><?php echo wp_kses_post( $config['label'] ); ?></label>	
					<?php endif; ?>	

					<div class="ff-picker">
						<div class="picker-input">
							<div class="icon"><i class="<?php echo $config['default']; ?>"></i></div>
							<input type="hidden" name="<?php echo esc_attr( $config['name'] ); ?>" value="<?php echo esc_attr( $config['value'] ); ?>">
							<input class="<?php echo implode(' ', $config['css_classes']); ?>" name="<?php echo esc_attr( $config['name'] ); ?>_search" id="ff-shortcodes-input-<?php echo esc_attr( $config['name'] ); ?>" value="" type="text">
							<a href="javascript:;" class="search"></a>
						</div>

						<div class="all-icons">
							<?php
								$icons = self::get_fa_icons();
								foreach( $icons as $icon_name => $icon_css_content ) {
									echo '<a href="javascript:;" class="ff-shortcodes-icon" data-icon="' . $icon_name . '"><i class="' . $icon_name . '"></i></a>';
								}
							?>
						</div>
					</div>

					<?php if( $config['desc'] <> '' ): ?>
						<div class="desc">
							<?php echo wp_kses_post( $config['desc'] ); ?>
						</div>
					<?php endif; ?>
				</div>

			</div>
			<?php
		}

		/**
		 * Display switch option type
		**/
		public static function switcher( $config ) {

			$defaults = array(
				'label' => '',
				'name' => '',
				'value' => '',
				'desc' => '',
				'heading' => '',
				'default' => 'on',
				'text_on' => __('on', 'ff_shortcodes'),
				'text_off' => __('off', 'ff_shortcodes'),
				'css_classes' => array()
			);

			$config = array_replace_recursive( $defaults, $config );

			?>
			<div class="ff-bk-row">

				<?php if( $config['heading'] <> '' ): ?>
					<h4><?php echo wp_kses_post( $config['heading'] ); ?></h4>
				<?php endif; ?>

				<div class="ff-control ff-control-switch <?php echo implode(' ', $config['css_classes']); ?>">

					<?php if( $config['label'] <> '' ): ?>
					<label for="ff-shortcodes-input-<?php echo esc_attr( $config['name'] ); ?>"><?php echo wp_kses_post( $config['label'] ); ?></label>	
					<?php endif; ?>	

					<div class="ff-picker <?php echo esc_attr( $config['default'] ); ?>">
						<input type="hidden" name="<?php echo esc_attr( $config['name'] ); ?>" value="<?php echo esc_attr( $config['default'] ); ?>"> <span class="label-on"><?php echo wp_kses_post( $config['text_on'] ); ?></span> <span class="label-off"><?php echo wp_kses_post( $config['text_off'] ); ?></span>
					</div>

					<?php if( $config['desc'] <> '' ): ?>
						<div class="desc">
							<?php echo wp_kses_post( $config['desc'] ); ?>
						</div>
					<?php endif; ?>
				</div>

			</div>
			<?php
		}

		/**
		 * Display align picker option type
		**/
		public static function align_picker( $config ) {

			$defaults = array(
				'label' => '',
				'name' => '',
				'value' => '',
				'desc' => '',
				'heading' => '',
				'default' => 'left',
				'css_classes' => array()
			);

			$config = array_replace_recursive( $defaults, $config );

			?>
			<div class="ff-bk-row">

				<?php if( $config['heading'] <> '' ): ?>
					<h4><?php echo wp_kses_post( $config['heading'] ); ?></h4>
				<?php endif; ?>

				<div class="ff-control ff-control-alignment <?php echo implode(' ', $config['css_classes']); ?>">

					<?php if( $config['label'] <> '' ): ?>
					<label for="ff-shortcodes-input-<?php echo esc_attr( $config['name'] ); ?>"><?php echo wp_kses_post( $config['label'] ); ?></label>	
					<?php endif; ?>	

					<div class="ff-picker">
						<label class="left picker <?php echo $config['default'] == 'left' ? 'selected' : ''; ?>"><input <?php checked( $config['default'], 'left' ); ?> type="radio" value="left" name="<?php echo esc_attr( $config['name'] ); ?>"></label>
						<label class="center picker <?php echo $config['default'] == 'center' ? 'selected' : ''; ?>"><input <?php checked( $config['default'], 'center' ); ?> type="radio" value="center" name="<?php echo esc_attr( $config['name'] ); ?>"></label>
						<label class="right picker <?php echo $config['default'] == 'right' ? 'selected' : ''; ?>"><input <?php checked( $config['default'], 'right' ); ?> type="radio" value="right" name="<?php echo esc_attr( $config['name'] ); ?>"></label>
						<label class="justify picker <?php echo $config['default'] == 'justify' ? 'selected' : ''; ?>"><input <?php checked( $config['default'], 'justify' ); ?> type="radio" value="justify" name="<?php echo esc_attr( $config['name'] ); ?>"></label>
					</div>

					<?php if( $config['desc'] <> '' ): ?>
						<div class="desc">
							<?php echo wp_kses_post( $config['desc'] ); ?>
						</div>
					<?php endif; ?>
				</div>

			</div>
			<?php
		}

		/**
		 * Display Text Unit option type
		**/
		public static function text_unit( $config ) {

			$defaults = array(
				'label' => '',
				'name' => '',
				'value' => '',
				'desc' => '',
				'heading' => '',
				'unit' => 'px',
				'css_classes' => array()
			);

			$config = array_replace_recursive( $defaults, $config );

			?>
			<div class="ff-bk-row">

				<?php if( $config['heading'] <> '' ): ?>
					<h4><?php echo wp_kses_post( $config['heading'] ); ?></h4>
				<?php endif; ?>

				<div class="ff-control ff-control-text-unit">

					<?php if( $config['label'] <> '' ): ?>
					<label for="ff-shortcodes-input-<?php echo esc_attr( $config['name'] ); ?>"><?php echo wp_kses_post( $config['label'] ); ?></label>	
					<?php endif; ?>	

					<div class="ff-picker <?php echo implode(' ', $config['css_classes']); ?>">
						<input id="ff-shortcodes-input-<?php echo esc_attr( $config['name'] ); ?>" type="text" name="<?php echo esc_attr( $config['name'] ); ?>" value="<?php echo esc_attr( $config['value'] ); ?>">
						<div><?php echo $config['unit']; ?></div>
					</div>

					<?php if( $config['desc'] <> '' ): ?>
						<div class="desc">
							<?php echo wp_kses_post( $config['desc'] ); ?>
						</div>
					<?php endif; ?>
				</div>

			</div>
			<?php
		}

		/**
		 * Display textarea option type
		**/
		public static function textarea( $config ) {

			$defaults = array(
				'label' => '',
				'name' => '',
				'value' => '',
				'desc' => '',
				'heading' => '',
				'css_classes' => array()
			);

			$config = array_replace_recursive( $defaults, $config );

			?>
			<div class="ff-bk-row">

				<?php if( $config['heading'] <> '' ): ?>
					<h4><?php echo wp_kses_post( $config['heading'] ); ?></h4>
				<?php endif; ?>

				<div class="ff-control ff-control-textarea">

					<?php if( $config['label'] <> '' ): ?>
					<label for="ff-shortcodes-input-<?php echo esc_attr( $config['name'] ); ?>"><?php echo wp_kses_post( $config['label'] ); ?></label>
					<?php endif; ?>

					<textarea class="<?php echo implode(' ', $config['css_classes']); ?>" id="ff-shortcodes-input-<?php echo esc_attr( $config['name'] ); ?>" name="<?php echo esc_attr( $config['name'] ); ?>"><?php echo wp_kses_post( $config['value'] ); ?></textarea>

					<?php if( $config['desc'] <> '' ): ?>
						<div class="desc">
							<?php echo wp_kses_post( $config['desc'] ); ?>
						</div>
					<?php endif; ?>

				</div>

			</div>
			<?php
		}

		/**
		 * Display dropdown option type
		**/
		public static function dropdown( $config ) {

			$defaults = array(
				'label' => '',
				'name' => '',
				'value' => array(),
				'default' => '',
				'desc' => '',
				'heading' => '',
				'css_classes' => array(),
				'first_null_option' => false
			);

			$config = array_replace_recursive( $defaults, $config );

			?>

			<div class="ff-bk-row">

				<?php if( $config['heading'] <> '' ): ?>
					<h4><?php echo wp_kses_post( $config['heading'] ); ?></h4>
				<?php endif; ?>

				<div class="ff-control ff-control-dropdown">

					<?php if( $config['label'] <> '' ): ?>
					<label for="ff-shortcodes-input-<?php echo esc_attr( $config['name'] ); ?>"><?php echo wp_kses_post( $config['label'] ); ?></label>
					<?php endif; ?>

					<div class="dropdown-wrapper">
						<select class="<?php echo implode(' ', $config['css_classes']); ?>" id="ff-shortcodes-input-<?php echo esc_attr( $config['name'] ); ?>" name="<?php echo esc_attr( $config['name'] ); ?>">
							
							<?php if( $config['first_null_option'] ): ?>
									<option <?php echo selected( '', $config['default'] ); ?> value=""></option>
							<?php endif; ?>
							
							<?php if( is_array( $config['value'] ) ): ?>

								<?php foreach( $config['value'] as $k=>$v ): ?>
									<option <?php echo selected( $k, $config['default'] ); ?> value="<?php echo esc_attr( $k ); ?>"><?php echo wp_kses_post( $v ); ?></option>
								<?php endforeach; ?>

							<?php endif; ?>
						</select>
					</div>

					<?php if( $config['desc'] <> '' ): ?>
						<div class="desc">
							<?php echo wp_kses_post( $config['desc'] ); ?>
						</div>
					<?php endif; ?>

				</div>

			</div>

			<?php
		}

		/**
		 * Display radio option type
		**/
		public static function radio( $config ) {

			$defaults = array(
				'label' => '',
				'name' => '',
				'value' => array(),
				'default' => '',
				'desc' => '',
				'heading' => '',
				'css_classes' => array()
			);

			$config = array_replace_recursive( $defaults, $config );

			?>

			<div class="ff-bk-row">

				<?php if( $config['heading'] <> '' ): ?>
					<h4><?php echo wp_kses_post( $config['heading'] ); ?></h4>
				<?php endif; ?>

				<div class="ff-control ff-control-radio <?php echo implode(' ', $config['css_classes']); ?>">

					<?php if( $config['label'] <> '' ): ?>
					<label><?php echo wp_kses_post( $config['label'] ); ?></label>
					<?php endif; ?>

					<div class="radios">
						<?php if( is_array( $config['value'] ) ): ?>

							<?php $i=0; foreach( $config['value'] as $k=>$v ): $i++; ?>

								<div class="ff-radio <?php if( $config['default'] == $k || (trim( $config['default'] ) == '' && $i == 1) ): ?>selected<?php endif; ?>">
									<label><input type="radio" <?php checked( $config['default'], $k ); ?> name="<?php echo esc_attr( $config['name'] ); ?>" value="<?php echo esc_attr( $k ); ?>"><?php echo wp_kses_post( $v ); ?></label>
								</div>

							<?php endforeach; ?>

						<?php endif; ?>
					</div>

					<?php if( $config['desc'] <> '' ): ?>
						<div class="desc">
							<?php echo wp_kses_post( $config['desc'] ); ?>
						</div>
					<?php endif; ?>

				</div>

			</div>

			<?php
		}

		/**
		 * Display image option type
		**/
		public static function image( $config ) {

			$defaults = array(
				'label' => '',
				'name' => '',
				'desc' => '',
				'heading' => '',
				'css_classes' => array()
			);

			$config = array_replace_recursive( $defaults, $config );

			?>
			<div class="ff-bk-row">

				<?php if( $config['heading'] <> '' ): ?>
					<h4><?php echo wp_kses_post( $config['heading'] ); ?></h4>
				<?php endif; ?>

				<div class="ff-control ff-control-image-picker <?php echo implode(' ', $config['css_classes']); ?>">

					<?php if( $config['label'] <> '' ): ?>
					<label><?php echo wp_kses_post( $config['label'] ); ?></label>
					<?php endif; ?>

					<div class="ff-picker">

						<input type="hidden" name="<?php echo esc_attr( $config['name'] ); ?>" value="">

						<div class="ff-thumb">
							<div class="img-holder"></div>
							<a href="javascript:;" class="remove"></a>
						</div>

						<a href="javascript:;" class="add"></a>

					</div>

					<?php if( $config['desc'] <> '' ): ?>
						<div class="desc">
							<?php echo wp_kses_post( $config['desc'] ); ?>
						</div>
					<?php endif; ?>

				</div>

			</div>
			<?php

		}

		/**
		 * Dynamic option type
		 * allows to create shortcodes with dynamic number of parameters, e.g. Tabs / Toggles / Accordions etc
		 * for example:
		 * [fruitful_tabs type="accordion" width="100%" fit="false"]
		 * [fruitful_tab title="Title 1"] Tab 1 content place [/fruitful_tab]
		 * [fruitful_tab title="Title 2"] Tab 2 content place [/fruitful_tab]
		 * [fruitful_tab title="Title 3"] Tab 3 content place [/fruitful_tab]
		 * [/fruitful_tabs]
		**/
		public static function dynamic( $config ) {

			$defaults = array(
				'count' => 1,
				'shortcode' => '',
				'row_title' => '',
				'fields' => array()
			);

			$config = array_replace_recursive( $defaults, $config );
			?>

			<div class="ff-shortcodes-dynamic-rows">
				<div class="sortable">
			<?php
				for( $i = 0; $i < absint( $config['count'] ); $i++ ):
				?>

				<div class="ff-shortcodes-dynamic-row <?php if( $i == 0): ?>open<?php endif; ?>">

					<div class="ff-shortcodes-dynamic-controls">

						<a href="javascript:;" class="toggle"></a>
						<h4><?php echo $config['row_title']; ?></h4>

						<a href="javascript:;" class="remove"></a>
						<a href="javascript:;" class="duplicate"></a>
						<a href="javascript:;" class="move"></a>
					</div>

					<?php

						$_new_fields = array();

						// modifle field name to be inner shortcode
						foreach( $config['fields'] as $field ) {
							$field['name'] = $config['shortcode'] . '[' . $i . ']' . '[' . $field['name'] . ']';
							$_new_fields[] = $field;
						}
						?>
						<input type="hidden" name="<?php echo esc_attr( $config['shortcode'] ); ?>[<?php echo $i; ?>][_ff_shortcode_name]" value="<?php echo esc_attr( $config['shortcode'] ); ?>" />
						<?php
						foreach( $_new_fields as $field ):
							call_user_func( array( 'self', $field['type'] ), $field );
						endforeach;

					?>

				</div>

				<?php
				endfor;
			?>
			</div>
			<a href="javascript:;" class="ff-shortcodes-dynamic-row-add"></a>

			</div>

			<?php
		}

		/**
		 * Child shortcode option type
		 * this option helps to create following structure based on "fields" param:
		 * [fruitful_ibox_row]
		 * [fruitful_ibox column="ffs-two-one" title="Title 1"]Lorem ipsum dolor sit amet.[/fruitful_ibox]
		 * [fruitful_ibox column="ffs-two-one" title="Title 2" last="true"]Lorem ipsum dolor sit amet.[/fruitful_ibox]
		 * [/fruitful_ibox_row]
		**/
		public static function child( $config ) {

			static $child_box_id = 0;

			$defaults = array(
				'shortcode' => '',
				'fields' => array()
			);

			$config = array_replace_recursive( $defaults, $config );
			?>
			<div class="ff-shortcodes-inner-container">

				<div class="ff-shortcodes-inner-rows">

					<div class="ff-shortcodes-inner-row">

						<?php

							$_new_fields = array();

							// modifle field name to be inner shortcode
							foreach( $config['fields'] as $field ) {
								$field['name'] = $config['shortcode'] . '[' . $child_box_id . ']' . '[' . $field['name'] . ']';
								$_new_fields[] = $field;
							}

							foreach( $_new_fields as $field ):
								?>
								<input type="hidden" name="<?php echo esc_attr( $config['shortcode'] ); ?>[<?php echo $child_box_id; ?>][_ff_shortcode_name]" value="<?php echo esc_attr( $config['shortcode'] ); ?>" />
								<?php
								call_user_func( array( self, $field['type'] ), $field );
							endforeach;

						?>

					</div>

				</div>

			</div>
			<?php

			$child_box_id++;

		}

		/**
		 * Print form fields
		**/
		public static function print_fields( $config ) {

			if( !empty( $config ) ): ?>
				<?php
					foreach( $config as $field ):

						call_user_func( array( 'self', $field['type'] ), $field );

					endforeach;
				?>
			<?php endif;

		}

		/**
		 * Print form
		**/
		public static function print_form( $config ) {

			$tabbed_form = isset( $config['tabs'] ) && filter_var( $config['tabs'], FILTER_VALIDATE_BOOLEAN );
			?>
			<form action="javascript:;" id="ff-shortcode-params-form" class="ff-shortcode-params <?php if( $tabbed_form ): ?> tabbed<?php endif; ?>" method="POST">
			<?php

			if( ! empty( $config['shortcode'] ) ):
					
				// add common tabs to config 
				if ( $tabbed_form && apply_filters( 'ff_shortcodes_can_add_common_tabs', true, $config ) ) {
					
					$common_tabs = apply_filters( 'ff_shortcodes_get_common_tabs', [], $config );
					
					if ( is_array( $common_tabs ) && $common_tabs ) {
						foreach ($common_tabs as $tab => $tab_params ) {
							if ( ! isset( $config[$tab] ) ) { // prevent overriding shortcode tabs by common tabs 
								$config[$tab] = $tab_params;
							}
						}
					}
				}
				
				
				?>
				<input type="hidden" name="_ff_shortcode_name" value="<?php echo esc_attr( $config['shortcode'] ); ?>" />
				<?php
			endif;

			// if tabbed form style
			if( $tabbed_form ):

				?>
				<!--
					Tabs navigation
				-->
				<div class="ff-tabs">
				<?php

				// print tab navigation
				$i=0; foreach( $config as $key => $value ):
					if( is_array( $value ) ): $i++; ?>
						<a class="<?php echo $i == 1 ? 'current' : ''; ?>" href="#ff-shortcodes-modal-tab-<?php echo esc_attr( $key ); ?>"><?php echo wp_kses_post( $value['tab_title'] ); ?></a>
					<?php endif;
				endforeach;

				?>
				</div>

				<div class="ff-tabs-content">
				<?php

				// print tabs content
				foreach( $config as $key => $value ):
					if( !isset( $value['fields'] ) ) {
						continue;
					}
					?>
					<div id="ff-shortcodes-modal-tab-<?php echo esc_attr( $key ); ?>" class="ff-tab">

						<?php self::print_fields( $value['fields'] ); ?>

					</div>
					<?php
				endforeach;
				?>
				</div>
				<?php

			// else flat form style
			else:
				?>
				<div class="ff-controls">
				<?php 
					self::print_fields( $config['fields'] );
				?>
				</div>
				<?php 
			endif;
			?>

			<footer id="ff-shortcodes-modal-footer">

				<a href="javascript:;" class="ff-button ff-shortcodes-back"><?php _e( 'Cancel', 'ff_shortcodes'); ?></a>
				<a href="javascript:;" class="ff-button add-shortcode"><?php _e( 'Add', 'ff_shortcodes'); ?></a>

			</footer>

			</form>
			<?php
		}

		/**
		 * Get all CSS classes from FontAwesome Library
		 **/
		public static function get_fa_icons() {
			global $wp_filesystem;
			// get results from cache
			// delete_transient('_ff_shortcodes_fa_icons');
			$icons = get_transient( '_ff_shortcodes_fa_icons' );

			if( empty( $icons ) || count( $icons ) == 0 ) {

				if (empty($wp_filesystem)) {
					require_once (ABSPATH . '/wp-admin/includes/file.php');
					WP_Filesystem();
				}

				add_filter( 'filesystem_method', function() {
					return 'direct';
				} );

				$icons = array();

				$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
				$subject = $wp_filesystem->get_contents( FF_SHORTCODES()->plugin_path . '/assets/libs/fontawesome/css/font-awesome.css');

				preg_match_all( $pattern, $subject, $matches, PREG_SET_ORDER);

				foreach( $matches as $match) {
					$icons[ 'fa ' . $match[1]] = $match[2];
				}

				// cache results
				set_transient( '_ff_shortcodes_fa_icons', $icons, 60*60*12 );

			}

			return $icons;
		}

	}

<div class="wrap">

	<h2><?php esc_html_e( 'Fruitful Shortcodes Plugin Settings', 'ff_shortcodes' ); ?></h2>

	<form method="post">

		<?php settings_fields( 'ff_shortcodes_settings' ); ?>

		<div class="ff-settings-options-form ff-shortcodes-settings-form">

			<div class="ffst-modal__content">
                
                <!--- Shortcode Version: old | new ----->
                <h3><?php esc_html_e( 'Plugin version', 'ff_shortcodes' ); ?></h3>
                
                <div class="form-group">
                    <label>
                        <select name="fruitful_version">
                            <option value="old" <?php echo $data['fruitful_version']=='old' ? ' selected':''; ?>><?php echo __("Old version", "ff_shortcodes"); ?></option>
                            <option value="new" <?php echo $data['fruitful_version']=='new' ? ' selected':''; ?>><?php echo __("New version", "ff_shortcodes"); ?></option>
                        </select>
                    </label>
                
                </div>
                
				<h2><?php _e( 'Fruitful Code statistic', 'ff_shortcodes' ); ?></h2>
				<p class="description">
					<?php _e( 'We would be happy if you assist us in becoming better. Share your site anonymous technical data to help us
                        improve our products and services. Also, don’t forget to subscribe to the Fruitful Code
                        newsletters for the latest updates!', 'ff_shortcodes' ); ?>
				</p>
				<div class="form-group">
					<label>
						<input type="checkbox"
						       name="ffc_statistic"
						       value="1"
							<?php if($data['ffc_statistic'] === 1) { echo esc_attr( 'checked'); }?> >
						<?php _e( 'Send configuration information to Fruitful Code to help to improve this plugin', 'ff_shortcodes' ) ?>
					</label>
				</div>

				<div class="form-group">
					<label>
						<input type="checkbox"
						       name="ffc_subscribe"
						       value="1"
							<?php if($data['ffc_subscribe'] === 1) { echo esc_attr( 'checked'); }?> >
						<?php _e( 'Subscribe to the Fruitful Code newsletters', 'ff_shortcodes' ) ?>
					</label>

					<div class="ffst-content_user-info">
						<div class="floating-placeholder__wrapper subscribe__input_name">
							<input type="text" placeholder="Name" name="ffc_subscribe_name" value="<?php echo esc_attr( $data['ffc_name'] ); ?>">
							<label><?php _e( 'Name', 'ff_shortcodes' ); ?>*</label>
						</div>
						<div class="floating-placeholder__wrapper subscribe__input_email">
							<input type="email" placeholder="E-mail" name="ffc_subscribe_email" value="<?php echo esc_attr( $data['ffc_email'] ); ?>">
							<label><?php _e( 'E-mail', 'ff_shortcodes' ); ?>*</label>
						</div>
					</div>
				</div>

			</div>

		</div>

		<?php //do_action( 'ff_shortcodes_display_settings_page'); ?>

		<?php submit_button(); ?>

	</form>



</div>
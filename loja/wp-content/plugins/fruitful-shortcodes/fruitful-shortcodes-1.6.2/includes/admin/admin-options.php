<?php

class ffsSettingsPage   {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'ffsPluginPage' ) );
        add_action( 'admin_init', array( $this, 'ffsPageInit' ) );
        
        $this->save_plugin_settings();
    }

    public function ffsPluginPage() {
        
        add_options_page(
            'Fruitful Shortcodes', 
            'Fruitful Shortcodes', 
            'manage_options', 
            'ffsAdminSettings', 
            array( $this, 'ffsCreateOptionsPage' )
        );
    }

    public function ffsCreateOptionsPage() {
        $this->fruitful_options = get_option( 'fruitful_options_plugin' );
    ?>
        <style>
        .ff-settings-options-form {border:1px solid #d3d3d3;padding:20px;background:#fff}
        .ff-settings-options-form .description{margin-bottom:15px}
        .ff-settings-options-form .form-group{margin-bottom:5px}
        .ff-settings-options-form .submit-btn__wrapper{text-align:right;margin-top:15px}
        .ff-settings-options-form .floating-placeholder__wrapper{position:relative;height:30px;margin-top:15px}
        .ff-settings-options-form .floating-placeholder__wrapper input{height:100%;width:100%;position:relative;background-color:transparent;z-index:1}
        .ff-settings-options-form .floating-placeholder__wrapper input::placeholder{color:transparent}
        .ff-settings-options-form .floating-placeholder__wrapper label,
        .ff-settings-options-form .floating-placeholder__wrapper input:placeholder-shown:focus+label,
        .ff-settings-options-form .floating-placeholder__wrapper input:placeholder-shown:active+label{background-color:#fff;font-size:12px;font-style:italic;line-height:1;position:absolute;left:5px;top:0;transform:translateY(-50%);transition:.3s;display:block;padding:0 3px;color:#666;z-index:2;cursor:default}
        .ff-settings-options-form .floating-placeholder__wrapper input:placeholder-shown+label{transform:translateY(50%);font-size:16px;z-index:0;transition:.3s}
        </style>
        
        <div class="wrap ff-settings-options-form ff-shortcodes-settings-form">
            <h2>Shortcode Settings</h2>
            <form method="post" action="options.php">
            <?php
                settings_fields( 'ffsAdminGroup' );   
                do_settings_sections( 'ffsAdminSettings' );
                
                $ff_stats = get_option('ffc_statistics_option');
            ?>

            
			<div class="ffst-modal__content">
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
							<?php if($ff_stats['ffc_statistic'] === 1) { echo esc_attr( 'checked'); }?> >
						<?php _e( 'Send configuration information to Fruitful Code to help to improve this plugin', 'ff_shortcodes' ) ?>
					</label>
				</div>

				<div class="form-group">
					<label>
						<input type="checkbox"
						       name="ffc_subscribe"
						       value="1"
							<?php if($ff_stats['ffc_subscribe'] === 1) { echo esc_attr( 'checked'); }?> >
						<?php _e( 'Subscribe to the Fruitful Code newsletters', 'ff_shortcodes' ) ?>
					</label>

					<div class="ffst-content_user-info">
						<div class="floating-placeholder__wrapper subscribe__input_name">
							<input type="text" placeholder="Name" name="ffc_subscribe_name" value="<?php echo esc_attr( $ff_stats['ffc_subscribe_name'] ); ?>">
							<label><?php _e( 'Name', 'ff_shortcodes' ); ?>*</label>
						</div>
						<div class="floating-placeholder__wrapper subscribe__input_email">
							<input type="email" placeholder="E-mail" name="ffc_subscribe_email" value="<?php echo esc_attr( $ff_stats['ffc_subscribe_email'] ); ?>">
							<label><?php _e( 'E-mail', 'ff_shortcodes' ); ?>*</label>
						</div>
					</div>
				</div>

			</div>
            
            <?php
                submit_button(); 
            ?>

            </form>
        </div>
        <?php
    }
    
    /**
	 * Save plugin settings action
	 */
	public function save_plugin_settings() {

		$post = $_POST;

		if( !empty($post) ){
			if( !empty($post['option_page']) )
			{
				if( $post['option_page'] === 'ffsAdminGroup' ) {
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
				}
			}
		}
	}

    
    public function ffsPageInit() {        
        register_setting(
            'ffsAdminGroup', 		// Option group
            'fruitful_options_plugin', 	// Option name
            array( $this, 'fruitful_sanitize' ) // Sanitize
        );

        add_settings_section(
            'ffsSettingSection', 	// ID
            '', 	// Title
            null, // Callback
            'ffsAdminSettings' // Page
        );  

        add_settings_field(
            'fruitful_post_types', 	// ID
            'Display On', 		// Title 
            array( $this, 'fruitful_get_post_types_call' ), // Callback
            'ffsAdminSettings', 	// Page
            'ffsSettingSection' 	// Section           
        );

	    add_settings_field(
		    'fruitful_version', 	// ID
		    'Plugin version', 		// Title
		    array( $this, 'fruitful_get_version_call' ), // Callback
		    'ffsAdminSettings', 	// Page
		    'ffsSettingSection' 	// Section
	    );
        
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function fruitful_sanitize( $elements ) {
		
        $new_elements = array();
        if( isset( $elements['fruitful_post_types'] ) ) $new_elements['fruitful_post_types'] = $elements['fruitful_post_types'];
	    if( isset( $elements['fruitful_version'] ) ) $new_elements['fruitful_version'] = $elements['fruitful_version'];

        return $new_elements;
    }

    
    protected function fruitful_getPostTypes() {
        return get_post_types(array('public' => true));
    }
	
    public function fruitful_get_post_types_call() {
        $pst_arr = ($pst_arr = $this->fruitful_options['fruitful_post_types']) ? ($pst_arr) : array('page', 'post');
		
        foreach ($this->fruitful_getPostTypes() as $post_type) {
                 $checked = (in_array($post_type, $pst_arr)) ? ' checked="checked"' : '';
                ?>
                <label>
                    <input type="checkbox"<?php echo $checked; ?> value="<?php echo $post_type; ?>" id="fruitful_post_types_<?php echo $post_type; ?>" name="fruitful_options_plugin[fruitful_post_types][]" />
                    <?php echo $post_type; ?>
                </label><br>
                <?php }
        ?>
        <p class="description indicator-hint">
			<?php _e("Select for which content types...", "ff_shortcodes"); ?>
		</p>
        <?php
    }

	public function fruitful_get_version_call() {
        $version = $this->fruitful_options['fruitful_version'];
        ?>

        <select name="fruitful_options_plugin[fruitful_version]">
            <option value="old" <?php echo $version=='old' ? ' selected':''; ?>><?php echo __("Old version", "ff_shortcodes"); ?></option>
            <option value="new" <?php echo $version=='new' ? ' selected':''; ?>><?php echo __("New version", "ff_shortcodes"); ?></option>
        </select>

        <p class="description indicator-hint">
			<?php _e("Select which version of plugin you want to use...", "ff_shortcodes"); ?>
        </p>
		<?php
	}

}

if( is_admin() ) $my_settings_page = new ffsSettingsPage();
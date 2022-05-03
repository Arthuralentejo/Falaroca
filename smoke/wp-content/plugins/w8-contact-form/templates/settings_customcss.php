<div id="screen_preloader"><h3>W8 Contact Form</h3><img src="<?php print(plugins_url( '/assets/img/screen_preloader.gif' , __FILE__ ));?>"><h5><?php esc_html_e( 'LOADING', W8CONTACT_FORM_TEXT_DOMAIN );?><br><br><?php esc_html_e( 'Please wait...', W8CONTACT_FORM_TEXT_DOMAIN );?></h5></div>
<div class="wrap w8contact_form">
	<br />
	<h3><?php esc_html_e( 'Custom CSS', W8CONTACT_FORM_TEXT_DOMAIN );?><hr /></h3>
	<form method="post" action="options.php#contact_form_slider_customcss"> 
		<?php settings_fields('contact_form_slider_customcss-group'); ?>
		<?php do_settings_fields('contact_form_slider_customcss-group','contact_form_slider_customcss-section'); ?>
		<?php do_settings_sections('contact_form_slider_customcss'); ?>
		<?php submit_button(); ?>
	</form>
</div>
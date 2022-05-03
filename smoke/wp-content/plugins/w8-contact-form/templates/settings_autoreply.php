<div id="screen_preloader"><h3>W8 Contact Form</h3><img src="<?php print(plugins_url( '/assets/img/screen_preloader.gif' , __FILE__ ));?>"><h5><?php esc_html_e( 'LOADING', W8CONTACT_FORM_TEXT_DOMAIN );?><br><br><?php esc_html_e( 'Please wait...', W8CONTACT_FORM_TEXT_DOMAIN );?></h5></div>
<div class="wrap w8contact_form">
	<br />
	<h3><?php esc_html_e( 'Auto-Reply', W8CONTACT_FORM_TEXT_DOMAIN );?></h3>
	<div class="help_link"><a target="_blank" href="http://contactform.pantherius.com/documentation"><?php esc_html_e( 'Documentation', W8CONTACT_FORM_TEXT_DOMAIN );?></a></div>
	<hr /><br>
	<form method="post" action="options.php#contact_form_slider_autoreply"> 
		<?php settings_fields('contact_form_slider_autoreply-group'); ?>
		<?php do_settings_fields('contact_form_slider_autoreply-group','contact_form_slider_autoreply-section'); ?>
		<?php do_settings_sections('contact_form_slider_autoreply'); ?>
		<?php submit_button(); ?>
	</form>
</div>
<div id="screen_preloader"><h3>W8 Contact Form</h3><img src="<?php print(plugins_url( '/assets/img/screen_preloader.gif' , __FILE__ ));?>"><h5><?php esc_html_e( 'LOADING', W8CONTACT_FORM_TEXT_DOMAIN );?><br><br><?php esc_html_e( 'Please wait...', W8CONTACT_FORM_TEXT_DOMAIN );?></h5></div>
<div class="wrap w8contact_form">
	<br />
	<h3><?php esc_html_e( 'Update', W8CONTACT_FORM_TEXT_DOMAIN );?><hr /></h3>
	<?php 
		require_once(str_replace('templates','',sprintf("%s/modules/manual.update.php", dirname(__FILE__))));
		manual_plugin_updater::getInstance(
		'w8-contact-form/w8-contact-form.php',
		'w8-contact-form/w8-contact-form.php',
		array(),
		'contact_form_slider'
		);
	?>
</div>
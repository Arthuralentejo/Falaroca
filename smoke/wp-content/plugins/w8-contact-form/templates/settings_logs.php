<div id="screen_preloader"><h3>W8 Contact Form</h3><img src="<?php print(plugins_url( '/assets/img/screen_preloader.gif' , __FILE__ ));?>"><h5><?php esc_html_e( 'LOADING', W8CONTACT_FORM_TEXT_DOMAIN );?><br><br><?php esc_html_e( 'Please wait...', W8CONTACT_FORM_TEXT_DOMAIN );?></h5></div>
<div class="wrap w8contact_form">
	<br />
	<h3><?php esc_html_e( 'Logs', W8CONTACT_FORM_TEXT_DOMAIN );?><hr /></h3>
	<form method="post" action="options.php#contact_form_slider_logs"> 
		<?php settings_fields('contact_form_slider_logs-group'); ?>
		<?php do_settings_fields('contact_form_slider_logs-group','contact_form_slider_logs-section'); ?>
		<?php do_settings_sections('contact_form_slider_logs'); ?>
		<?php submit_button(); ?>
	</form>
	<div class="log-buttons">
		<input class="button" id="log-clear" type="button" value="<?php esc_html_e( 'CLEAR LOGS', W8CONTACT_FORM_TEXT_DOMAIN );?>">
		<input class="button" id="log-display" type="button" value="<?php esc_html_e( 'DISPLAY LOGS', W8CONTACT_FORM_TEXT_DOMAIN );?>">
	</div>
	<div id="cfs-log-entries"></div>
</div>
<div id="dialog-confirm" title="Delete Log Entries?">
	<p><span class="ui-icon ui-icon-alert"></span><?php esc_html_e( 'The logs will be permanently deleted and cannot be recovered. Are you sure?', W8CONTACT_FORM_TEXT_DOMAIN );?></p>
</div>
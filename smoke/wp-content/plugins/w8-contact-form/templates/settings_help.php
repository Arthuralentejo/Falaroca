<div id="screen_preloader"><h3>W8 Contact Form</h3><img src="<?php print(plugins_url( '/assets/img/screen_preloader.gif' , __FILE__ ));?>"><h5><?php esc_html_e( 'LOADING', W8CONTACT_FORM_TEXT_DOMAIN );?><br><br><?php esc_html_e( 'Please wait...', W8CONTACT_FORM_TEXT_DOMAIN );?></h5></div>
<div class="wrap w8contact_form">
	<br />
	<h3><?php esc_html_e( 'Help', W8CONTACT_FORM_TEXT_DOMAIN );?></h3>
	<hr />
	<p>
		<?php esc_html_e( 'To see the full documentation, please click on the following link:', W8CONTACT_FORM_TEXT_DOMAIN );?> <a target="_blank" href="http://contactform.pantherius.com/documentation"><?php esc_html_e( 'Documentation', W8CONTACT_FORM_TEXT_DOMAIN );?></a>
	</p>
	<hr />
	<p>    
	<?php 
		$wp_filesystem = new WP_Filesystem_Direct(null);
		print( $wp_filesystem->get_contents( "http://static.pantherius.com/plugin_directory.html" ) );
	?>
	</p>
</div>
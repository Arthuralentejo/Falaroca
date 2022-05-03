<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
 
    <meta charset="<?php bloginfo('charset'); ?>"> 
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="facebook-domain-verification" content="eyt8cwb1z10m8y5pk9zotwhbmcn2gn" />
        	
<?php wp_head(); ?>	  

<!-- Facebook Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1584999081862021');
    fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1584999081862021&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

</head>  
<body id="start_nicdark_framework" <?php body_class(); ?>>

<!--START theme-->
<div class="nicdark_site nicdark_bg_white <?php if ( is_front_page() ) { echo esc_html("nicdark_front_page"); } ?> ">	
	
<?php if( function_exists('nicdark_headers')){ do_action("nicdark_header_nd"); }else{ ?>

<!--START section-->
<div class="nicdark_section nicdark_bg_greydark">

    <!--start container-->
    <div class="nicdark_container nicdark_clearfix">
        
        <!--START LOGO OR TAGLINE-->
        <?php
            
            $nicdark_customizer_logo_img = get_option( 'nicdark_customizer_logo_img' );
            if ( $nicdark_customizer_logo_img == '' or $nicdark_customizer_logo_img == 0 ) { ?>
                
            <div class="nicdark_grid_3 nicdark_text_align_center_responsive">
                <div class="nicdark_section nicdark_height_10"></div>
                <a href="<?php echo esc_url(home_url()); ?>"><h3 class="nicdark_color_white"><?php echo esc_html(get_bloginfo( 'name' )); ?></h3></a>
                <div class="nicdark_section nicdark_height_10"></div>
                <a href="<?php echo esc_url(home_url()); ?>"><p class="nicdark_font_size_13"><?php echo esc_html(get_bloginfo( 'description' )); ?></p></a>
                <div class="nicdark_section nicdark_height_10"></div>
            </div>

        <?php

            }else{ 

                $nicdark_customizer_logo_img = wp_get_attachment_url($nicdark_customizer_logo_img);

            ?>

            <div class="nicdark_grid_3 nicdark_text_align_center_responsive">
                <a href="<?php echo esc_url(home_url()); ?>">
                    <img class="nicdark_section" src="<?php echo esc_url($nicdark_customizer_logo_img); ?>">
                </a>
            </div>

        <?php } ?>
        <!--END LOGO OR TAGLINE-->
        


        <div class="nicdark_grid_9 nicdark_text_align_center_responsive">

            <!--open menu responsive icon-->
            <div class="nicdark_section nicdark_display_none nicdark_display_block_all_iphone">
                <a class="nicdark_open_navigation_1_sidebar_content nicdark_open_navigation_1_sidebar_content" href="#">
                    <img alt="" class="" width="25" src="<?php echo get_template_directory_uri(); ?>/img/icon-menu.svg">
                </a>
            </div>
            <!--open menu responsive icon-->

        	<div class="nicdark_section nicdark_height_10"></div>

        	<div class="nicdark_section nicdark_navigation_1">        
        		<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>       
        	</div>

        	<div class="nicdark_section nicdark_height_10"></div>

        </div>

    </div>
    <!--end container-->

</div>
<!--END section-->


<!--START menu responsive-->
<div class="nicdark_bg_greydark nicdark_navigation_1_sidebar_content nicdark_padding_40 nicdark_box_sizing_border_box nicdark_overflow_hidden nicdark_overflow_y_auto nicdark_transition_all_08_ease nicdark_height_100_percentage nicdark_position_fixed nicdark_width_300 nicdark_right_300_negative nicdark_z_index_999">

    <img alt="" width="25" class="nicdark_close_navigation_1_sidebar_content nicdark_cursor_pointer nicdark_right_20 nicdark_top_20 nicdark_position_absolute" src="<?php echo get_template_directory_uri(); ?>/img/icon-close-white.svg">

    <div class="nicdark_navigation_1_sidebar">
        <?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
    </div>

</div>
<!--END menu responsive-->

<!--START js-->
<script type="text/javascript">
//<![CDATA[

jQuery(document).ready(function() {

  jQuery(function ($) {
    
    $('.nicdark_open_navigation_1_sidebar_content').on("click",function(event){ $('.nicdark_navigation_1_sidebar_content').css({ 'right': '0px', }); });
    $('.nicdark_close_navigation_1_sidebar_content').on("click",function(event){ $('.nicdark_navigation_1_sidebar_content').css({ 'right': '-300px' }); });

  });
 
});

//]]>
</script>
<!--END js-->
<?php } ?>
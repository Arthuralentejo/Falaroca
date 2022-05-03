<?php 

if( function_exists('nicdark_footers')){ do_action("nicdark_footer_nd"); }else{ ?>

<!--START section-->
<div class="nicdark_section nicdark_bg_greydark nicdark_text_align_center">
    
    <!--start container-->
    <div class="nicdark_container nicdark_clearfix">

        <div class="nicdark_grid_12">

        	<div class="nicdark_section nicdark_height_10"></div>

        	<p class="nicdark_color_grey">
        		<?php echo esc_html(get_bloginfo('name')); ?>
        	</p>
        	
            <div class="nicdark_section nicdark_height_10"></div>

        </div>

    </div>
    <!--end container-->

</div>
<!--END section-->

<?php } ?>  

</div>
<!--END theme-->

<?php wp_footer(); ?>

<script>
	
	jQuery('.nd_options_cursor_zoom_out.nd_options_navigation_close_search_content.nd_options_width_100_percentage.nd_options_height_100_percentage.nd_options_position_absolute.nd_options_z_index_1_negative ').click(function(e){
	
		jQuery('.nd_options_display_table.nd_options_transition_all_08_ease.nd_options_navigation_search_content.nd_options_bg_greydark_alpha_9.nd_options_position_fixed.nd_options_width_100_percentage.nd_options_height_100_percentage.nd_options_z_index_1_negative.nd_options_opacity_0').css('opacity','0');
		jQuery('.nd_options_display_table.nd_options_transition_all_08_ease.nd_options_navigation_search_content.nd_options_bg_greydark_alpha_9.nd_options_position_fixed.nd_options_width_100_percentage.nd_options_height_100_percentage.nd_options_z_index_1_negative.nd_options_opacity_0').css('z-index','-1');
		   
		
		
		})
	
	


</script>
<style>

.nd_options_cursor_zoom_out.nd_options_navigation_close_search_content.nd_options_width_100_percentage.nd_options_height_100_percentage.nd_options_position_absolute.nd_options_z_index_1_negative {
    width: 200px;
    float: right;
    right: 1px;
    content: 'x';
    color: #fff;
    z-index: 99999;
    background-image: url(https://iniciativanegra.com.br/wp/wp-content/uploads/2021/08/fecharbusca.png);
    background-size: 25px;
    background-repeat: no-repeat;
}
</style>
	
</body>  
</html>
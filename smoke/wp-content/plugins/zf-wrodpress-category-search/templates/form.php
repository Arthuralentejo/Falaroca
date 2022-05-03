<?php
/**
 * @version    $Version$
 * @package    ZF WordPress Category Search
 * @author     ZuFusion Team
 * @copyright  Copyright (C) 2021 ZuFusion. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

$taxonomy_cat = $configs['cat_type'];
$cat_str      = zfwcs_current_taxonomy_value($custom_post_type, $taxonomy_cat, false);
$cats_selected = preg_split( '/[+,]+/', $cat_str );
?>

<div id="zf-cs-container-<?php echo esc_attr($id); ?>" class="zfwcs-container">

    <?php zfwcs_form_categories($configs, $taxonomy_cat, $cats_selected[0])?>

	<div class="clearfix"></div>

    <div class="box-search-container">
        <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" id="form-search" class="form-search" role="search">

	        <?php do_action( 'zfwcs_form_search_before', $configs ); ?>

	        <div class="input-query">
	            <input type="text" name="s" id="input-search" class="input-search icon-search typeahead"
	                   placeholder="<?php echo esc_attr($configs['placeholder_input']); ?>" value="<?php echo esc_attr(get_search_query()); ?>"/>

	            <div class="box-input">
		            <?php if ($configs['show_advanced_button'] == 'in') { ?>
		            <!--Open advanced box-->
		            <div class="zf-open-advanced"><?php zfwcs_open_advanced_button($configs)?></div>
		            <?php } ?>
		            <div>
			            <?php zfwcs_form_dropdown_categories($configs) ?>
		            </div>

		            <?php do_action( 'zfwcs_input_box', $custom_post_type, $configs ); ?>

		            <div class="zf-submit-button">
	                   <input type="submit" value="<?php echo esc_attr($configs['submit_label']); ?>" class="submit-button">
	                </div>
	            </div>
	        </div>

		    <div class="clearfix"></div>
			<!-- Advanced box -->
	        <div id="advanced-search-box" class="advanced-popup-box">
				<header>
				  <a href="#" class="advanced-popup-close">×</a>
				  <h3><?php esc_html_e( 'Advanced search', 'wcs' ) ?></h3>
				</header>
		        <div class="advanced-popup-inner">
			        <div id="advanced-search" class="advanced-search">
						<?php
						/*Sub Categories Field*/
						zfwcs_form_subcategories($configs, $taxonomy_cat, $cat_str, $cats_selected);
						/*Advanced Fields*/
						zfwcs_form_advanced_fields($configs);
						/*Price Field*/
						zfwcs_form_price_field($configs);
						/*Date field*/
						zfwcs_form_date_field($configs);
						/*Author field*/
						zfwcs_form_author_field($configs);
						/*Order by field*/
						zfwcs_form_order_by_field($configs);
						/*Order field*/
						zfwcs_form_order_field($configs);
						?>
				    </div>
		        </div>

	        </div>
	        <?php do_action( 'zfwcs_form_search_after', $configs ); ?>
			<?php zfwcs_form_hidden_fields($configs, $taxonomy_cat);?>
	    </form>
	    <?php if ($configs['show_advanced_button'] == 'out') { ?>
		    <!--Open advanced box-->
		    <div class="zf-open-advanced"><?php zfwcs_open_advanced_button($configs)?></div>
	    <?php } ?>
    </div>

</div>
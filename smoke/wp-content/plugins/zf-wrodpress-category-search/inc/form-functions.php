<?php
/**
 * @version    $Version$
 * @package    ZF WordPress Category Search
 * @author     ZuFusion Team
 * @copyright  Copyright (C) 2021 ZuFusion. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Top Categories
 * @param array $configs
 * @param       $taxonomy_cat
 * @param       $cats_selected
 */
function zfwcs_form_categories($configs = array(), $taxonomy_cat, $cats_selected) {

	if ( $configs['display_cat_type'] == 'tabs' ) {

		$cats = zfwcs_get_top_categories( $configs, $taxonomy_cat );

		if ( is_array( $cats ) ) {
			?>

			<div class="tabs-wrapper" style="background: transparent !important">
                <ul class="tabs-navigation <?php echo esc_attr($configs['tab_alignment']); ?>">
                    <?php if ( $configs['show_tab_all'] ) {
	                    $current_all = ( $cats_selected == '' ) ? 'zf-current' : '';
	                    ?>
	                    <li class="tab-nav <?php echo esc_attr($current_all); ?>" data-cat=""
	                        data-slug=""> <?php zfwcs_render_icon( '', $configs, true ); ?><?php esc_html_e( 'All Categories  ', 'wcs' ); ?></li>
                    <?php } ?>
	                <?php foreach ( $cats as $cat ) {
		                $current = ( $cat->slug == $cats_selected ) ? 'zf-current' : '';
		                ?>
		                <li class="tab-nav <?php echo esc_attr($current); ?>" data-cat="<?php echo esc_attr($cat->cat_ID); ?>"
		                    data-slug="<?php echo esc_attr($cat->slug); ?>"><?php zfwcs_render_icon( $cat->cat_ID, $configs ); ?><?php echo esc_attr($cat->name); ?></li>
	                <?php } ?>
                </ul>
            </div>

		<?php }
	}

	if ( $configs['display_cat_type'] == 'radio' ) {
		$cats = zfwcs_get_top_categories( $configs, $taxonomy_cat );
		if ( is_array( $cats ) ) {
			?>
			<ul class="radio-categories">
	                <li class="radio-category">
	                    <input id="cat_all" data-slug="" type="radio" name="radio" value="" checked="true">
	                    <label for="cat_all"><span></span><?php esc_html_e( 'All Categories', 'wcs' ); ?> </label>
	                </li>
				<?php foreach ( $cats as $cat ) {

					?>
					<li class="radio-category">
	                        <input id="cat_<?php echo esc_attr($cat->cat_ID); ?>" data-slug="<?php echo esc_attr($cat->slug); ?>" type="radio"
	                               name="radio" value="<?php echo esc_attr($cat->cat_ID); ?>" <?php checked( $cats_selected, $cat->slug ); ?>>
	                        <label for="cat_<?php echo esc_attr($cat->cat_ID); ?>"><span></span><?php echo esc_attr($cat->name); ?></label>
	                    </li>
				<?php } ?>
	            </ul>
		<?php } ?>

	<?php }

}

/**
 * Dropdown categories
 * @param array $configs
 */
function zfwcs_form_dropdown_categories($configs = array()) {
	if ( $configs['display_cat_type'] == 'dropdown' ) {
		$configs['selected'] = array(); // 0 is selected all
		zfwcs_dropdown_categories( $configs );
	}
}

/**
 * Sub categories
 * @param array  $configs
 * @param string $taxonomy_cat
 * @param string $cat_str
 * @param array  $cats_selected
 */
function zfwcs_form_subcategories($configs = array(), $taxonomy_cat = '', $cat_str = '', $cats_selected = array()) {

    if ( ( $configs['display_cat_type'] == 'tabs' ) || ( $configs['display_cat_type'] == 'radio' ) ) {
		if ( $configs['show_subcategories'] ) { ?>

			<div class="zf-row">
		        <div class="zf-loading"></div>
                <p class="subcategories-label zf-label"><?php esc_html_e( 'Sub Categories', 'wcs' ); ?> :</p>

                <ul class="checkbox-categories">
                    <?php
		                if ($cats_selected[0] !='') {
		                    $parent_cat = get_term_by( 'slug', $cats_selected[0], $taxonomy_cat );

		                    echo zfwcs_render_options( 'li_checkbox', 'slug', array(
			                    'taxonomy' =>  $taxonomy_cat,
			                    'selected' => $cats_selected,
			                    'child_of' => $parent_cat->term_id,
			                    'hide_empty'   => false ,
		                    ), 'ul' );
		                }
                    ?>
                </ul>

            </div>

		<?php }

    }

}

/**
 * Display advanced fields
 * @param array $configs
 */
function zfwcs_form_advanced_fields( $configs = array()) {

	// get post type taxonomies
	$custom_post_type  = $configs['custom_post_type'];
	$taxonomies        = zfwcs_get_taxonomies( $custom_post_type );
	$data              = $configs['custom_post_type_data'];

	if (!empty($data)) {
		$advanced_fields   = explode( ',', $data['advanced'] );
		$advanced_multiple = explode( ',', $data['advanced-multiple'] );
		$use_checkbox = explode( ',', $data['use-checkbox'] );

		foreach ( $taxonomies as $taxonomy ) {

			if ( in_array( $taxonomy->name, $advanced_fields ) ) {

				$multi_selected = '';
				$select_name    = '';

				$is_post_taxonomy_name    = false;
				if ($custom_post_type == 'post') {
					if ($taxonomy->name == 'post_tag') {
						$is_post_taxonomy_name = 'tag';
					}
					if ($taxonomy->name == 'category') {
						$is_post_taxonomy_name = 'category_name';
					}
				}

				if ( in_array( $taxonomy->name, $advanced_multiple ) ) {
					$multi_selected  = 'multiple';
					$zfwcs_chosen_class = ' zf-chosen-full zf-chosen-multiple';
				} else {
					$zfwcs_chosen_class = ' zf-chosen';
					$select_name     = 'name="' . $taxonomy->name . '"';
				}


				if ($is_post_taxonomy_name) {
					$taxonomy_selected_str = isset( $_GET[ $is_post_taxonomy_name ] ) ? $_GET[ $is_post_taxonomy_name ] : '';
				} else {
					$taxonomy_selected_str = isset( $_GET[ $taxonomy->name ] ) ? $_GET[ $taxonomy->name ] : '';
				}

				$_taxonomy_name = $is_post_taxonomy_name ? $is_post_taxonomy_name : $taxonomy->name;

				//                $taxonomy_selected_str = get_query_var($taxonomy->name, '');
				$taxonomy_selected = preg_split( '/[+,]+/', $taxonomy_selected_str );
				$configs_taxonomy  = array(
					'selected' => $taxonomy_selected,
					'taxonomy' =>  $taxonomy->name
				);
				echo '<div class="zf-row zf-use-checkbox">';
				echo "<p class='".esc_attr($taxonomy->name)."-label zf-label'>".esc_attr($taxonomy->label).": </p>";

				if (in_array( $taxonomy->name, $use_checkbox ) && ($multi_selected == 'multiple') ) {
					echo '<ul class="taxonomy-field">';
					echo zfwcs_render_options('li_checkbox', 'slug', $configs_taxonomy, 'ul' );
                    echo '</ul>';
				} else {

					echo "<select data-placeholder='" . esc_html__( 'Any ', 'wcs' ) . "".esc_attr($taxonomy->label)."' $select_name id='select-".esc_attr($_taxonomy_name)."' data-taxonomy='".esc_attr($_taxonomy_name)."' class='".esc_attr($zfwcs_chosen_class)."' $multi_selected>\n";
					if ( $multi_selected == '' ) {
						echo '<option value="">' . esc_html__( 'Any ', 'wcs' ) .''.esc_attr($taxonomy->label).'</option>';
					}
					echo zfwcs_render_options('option', 'slug', $configs_taxonomy );
					echo "</select>\n";
				}

				if ( $multi_selected == 'multiple' ) {
					echo "<input name='".esc_attr($_taxonomy_name)."' id='".esc_attr($_taxonomy_name)."' type='hidden' value='".esc_attr($taxonomy_selected_str)."'/>";
				}
				echo "</div>";



			}

		}
	}

}

/**
 * Price field
 * @param array $configs
 */
function zfwcs_form_price_field($configs = array()) {

	if ( $configs['show_price'] ) {

		list( $min, $max ) = zfwcs_get_prices( $configs['custom_post_type'] );
		$min_price = isset( $_GET['min_price'] ) ? $_GET['min_price'] : $min;
		$max_price = isset( $_GET['max_price'] ) ? $_GET['max_price'] : $max;

		$min_symbol = zfwcs_get_price_format( '<span id="from">' . esc_attr($min_price) . '</span>', $configs['custom_post_type'] );
		$max_symbol = zfwcs_get_price_format( '<span id="to">' . esc_attr($max_price) . '</span>', $configs['custom_post_type'] );
		?>
		<?php if ( $min != $max ) { ?>
			<div class="zf-row">
	            <p class="price-label zf-label"><?php esc_html_e( 'Price Range', 'wcs' ); ?>
		            : <span class="real-price-info"><?php esc_html_e( 'Price', 'wcs' ); ?>
			            : <?php echo esc_html($min_symbol); ?> - <?php echo esc_html($max_symbol); ?></span> </p>
	            <div id="price-slider-range"></div>
	            <input type="hidden" name="min_price" id="min_price" data-minprice="<?php echo esc_attr($min); ?>" value="<?php echo esc_attr($min_price); ?>"/>
	            <input type="hidden" name="max_price" id="max_price" data-maxprice="<?php echo esc_attr($max); ?>" value="<?php echo esc_attr($max_price); ?>"/>
	        </div>
		<?php } ?>
	<?php
	}

}

/**
 * Date field
 * @param array $configs
 */
function zfwcs_form_date_field($configs = array()) {

	if ( $configs['show_date'] ) {
		$date_from = isset( $_GET['date_from'] ) ? $_GET['date_from'] : '';
		$date_to   = isset( $_GET['date_to'] ) ? $_GET['date_to'] : '';
		?>
		<div class="zf-row">
	        <p class="date-label zf-label"><?php esc_html_e( 'Date Range', 'wcs' ); ?>
		        :</p>
	        <div class="zf-col"><label for="date_from" class="zf-label"><?php esc_html_e( 'From', 'wcs' ); ?>
			        : </label>
	        <input type="text" name="date_from" id="date_from" class="date_from zf-full-width zf-datepicker" placeholder="<?php esc_html_e( 'None', 'wcs' ); ?>" value="<?php echo esc_attr($date_from); ?>"/></div>
	        <div class="zf-col"><label for="date_to" class="zf-label"><?php esc_html_e( 'To', 'wcs' ); ?>
			        : </label>
	        <input type="text" name="date_to" id="date_to" class="date_to zf-full-width zf-datepicker" placeholder="<?php esc_html_e( 'None', 'wcs' ); ?>" value="<?php echo esc_attr($date_to); ?>"/></div>
	    </div>
	<?php }

}

/**
 * Author field
 * @param array $configs
 */
function zfwcs_form_author_field($configs = array()) {

	if ( $configs['show_author'] ) { ?>
		<?php
		$authors         = zfwcs_get_authors( array( 'post_type' => $configs['custom_post_type'] ) );
		$author_selected = isset( $_GET['author'] ) ? explode( ',', $_GET['author'] ) : array();
		if ( $authors ) {
			?>

			<div class="zf-row">
				<p class="author-label zf-label"><?php esc_html_e( 'Author', 'wcs' ); ?> :</p>
				<?php
				echo zfwcs_render_select( $authors, array(
					'name'      => 'author',
					'id'        => 'author',
					'class'     => 'select_authors zf-chosen',
					'selected'  => $author_selected,
					'op_attr'   => 'data-placeholder="' . esc_html__( 'Select Authors', 'wcs' ) . '"',
					'op_option' => '<option value="">' . esc_html__( 'Any', 'wcs' ) . '</option>',
					'key'       => 'ID',
					'value'     => 'display_name'
				) );
				?>
			</div>
		<?php
		}
	}

}

/**
 * Order by field
 * @param array $configs
 */
function zfwcs_form_order_by_field($configs = array()) {

	if ( $configs['show_orderby'] ) { ?>
		<div class="zf-row">
	        <p class="orderby-label zf-label"><?php esc_html_e( 'Sort By', 'wcs' ); ?> :</p>

			<?php
			$items            = array();
			$orderby_selected = isset( $_GET['orderby'] ) ? array( $_GET['orderby'] ) : array();

			if ( $configs['custom_post_type'] == 'post' ) {
				$items = array(
					'menu_order'    => esc_html__( 'Default', 'wcs' ),
					'post_date'     => esc_html__( 'Date', 'wcs' ),
					'post_title'    => esc_html__( 'Title', 'wcs' ),
					'post_author'   => esc_html__( 'Author', 'wcs' ),
					'comment_count' => esc_html__( 'Comment count', 'wcs' ),
				);

			} else if ( $configs['custom_post_type'] == 'product' ) {

				$items = array(
					'menu_order' => esc_html__( 'Default', 'wcs' ),
					'title'      => esc_html__( 'Title', 'wcs' ),
					'popularity' => esc_html__( 'Popularity', 'wcs' ),
					'rating'     => esc_html__( 'Rating', 'wcs' ),
					'date'       => esc_html__( 'Newness', 'wcs' ),
					'price'      => esc_html__( 'Price: low to high', 'wcs' ),
					'price-desc' => esc_html__( 'Price: high to low', 'wcs' ),
				);

			}

			echo zfwcs_render_select( $items, array(
				'name'     => 'orderby',
				'id'       => 'orderby',
				'selected' => $orderby_selected,
				'class'    => 'zf-chosen',
				'op_attr'  => ' data-placeholder="' . esc_html__( 'Order by', 'wcs' ) . '"',
			) );

			?>

	    </div>
	<?php }

}

/**
 * Order field
 * @param array $configs
 */
function zfwcs_form_order_field($configs = array()) {

	if ( $configs['show_order'] ) { ?>
		<div class="zf-row">
	        <p class="order-label zf-label"><?php esc_html_e( 'Order', 'wcs' ); ?>
		        :</p>

	        <select name="order" id="order" class="zf-chosen">
	            <option value="DESC"><?php esc_html_e( 'Descending', 'wcs' ); ?></option>
	            <option value="ASC"><?php esc_html_e( 'Ascending', 'wcs' ); ?></option>
	        </select>

	    </div>
	<?php }

}

/**
 * Hidden fields
 * @param array  $configs
 * @param string $taxonomy_cat
 */
function zfwcs_form_hidden_fields($configs = array(), $taxonomy_cat = '') {

    $input_cat_name = $taxonomy_cat;
    // @todo check this again
    if ($configs['custom_post_type'] == 'post' ) {
        $input_cat_name = 'category_name';
    }
	if ($taxonomy_cat != '') {
		$cat_selected = isset( $_GET[ $input_cat_name ] ) ? $_GET[ $input_cat_name ] : '';
		?>
		<input name="<?php echo esc_attr($input_cat_name); ?>" id="cats" type="hidden" value="<?php echo esc_attr($cat_selected); ?>"/>
	<?php } ?>

    <input id="post_type" name="post_type" type="hidden" value="<?php echo esc_attr($configs['custom_post_type']); ?>"/>
    <input id="cat_type" type="hidden" value="<?php echo esc_attr($configs['cat_type']); ?>"/>
<?php
}

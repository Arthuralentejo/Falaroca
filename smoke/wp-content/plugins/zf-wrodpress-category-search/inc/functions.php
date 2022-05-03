<?php
/**
 * @version    $Version$
 * @package    ZF WordPress Category Search
 * @author     ZuFusion Team
 * @copyright  Copyright (C) 2021 ZuFusion. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Display a dropdown list categories
 * @param array $args
 * @return bool
 */
function zfwcs_dropdown_categories( $args = array() ) {

	$defaults = array(
		'show_option_all'    => '',
		'orderby'            => 'name',
		'order'              => 'ASC',
		'show_count'         => 0,
		'hide_empty'         => 1,
		'use_desc_for_title' => 1,
		'child_of'           => 0,
		'exclude'            => '',
		'selected'           => 0,
		'exclude_tree'       => '',
		'current_category'   => 0,
		'name'               => '',
		'id'                 => 'dropdown-categories',
		'class'              => 'dropdown-categories',

	);


	$r = wp_parse_args( $args, $defaults );
	extract( $r );

	$name  = esc_attr( $name );
	$class = esc_attr( $class );
	$id    = $r['id'] ? esc_attr( $id ) : $name;

	$r['taxonomy'] = $r['cat_type'];
	if ( ! taxonomy_exists( $r['taxonomy'] ) ) {
		return false;
	}

	$output = '';
	$name   = ( $name != '' ) ? 'name="' . $name . '"' : '';
	$output .= "<select $name id='$id' class='$class' multiple='multiple' style='display: none'>\n";
	$output .= zfwcs_render_options( 'option', 'slug', $r );
	$output .= "</select>\n";

	echo $output;

}

/**
 * Display a dropdown list
 * @param array $args
 * @return bool
 */
function zfwcs_dropdown_list( $args = array() ) {

	$defaults = array(
		'show_option_all'    => '',
		'orderby'            => 'name',
		'order'              => 'ASC',
		'show_count'         => 0,
		'hide_empty'         => 1,
		'use_desc_for_title' => 1,
		'child_of'           => 0,
		'exclude'            => '',
		'selected'           => 0,
		'exclude_tree'       => '',
		'current_category'   => 0,
		'select_attr'        => '',
		'taxonomy'           => ''
	);


	$r = wp_parse_args( $args, $defaults );
	extract( $r );


	if ( ! taxonomy_exists( $r['taxonomy'] ) ) {
		return false;
	}

	$output = '';
	$output .= "<select " . $select_attr . ">\n";
	$output .= zfwcs_render_options( $r['taxonomy'], 'option', 'slug', $r );
	$output .= "</select>\n";

	echo wp_kses_normalize_entities($output);

}

/**
 * Render options of dropdown
 * @param string $taxonomy
 * @param string $type
 * @param string $option_type
 * @param array  $args
 * @param string $wrap_level
 * @return mixed
 */
function zfwcs_render_options( $type = "option", $option_type = 'id', $a = '', $wrap_level = '' ) {
	$output = '';
	$defaults = array(

		'orderby'      => 'name',
		'order'        => 'ASC',
		'show_count'   => 0,
		'hide_empty'   => 1 ,
		'child_of'     => 0,
		'exclude'      => '',
		'include'      => '',
		'selected'     => array(),
		'exclude_tree' => '',
		'taxonomy'     => 'category'
	);

	$args = wp_parse_args( $a, $defaults );
	$terms = get_terms( $args['taxonomy'], $args );
	$args['walker'] = new ZFWCS_Taxonomy_Walker( $args['taxonomy'], $type, $option_type, $args, $wrap_level);
	$output      = walk_category_tree( $terms, 0, $args );

	return $output;
}


/**
 * Get all taxonomies of custom post type
 * Array (
 * )
 * @param $post_type
 * @return mixed
 */
function zfwcs_get_taxonomies( $post_type ) {

	$taxonomies = get_object_taxonomies( $post_type, 'objects' );

	switch ( $post_type ) {
		case 'product': // WooCommerce

			break;

	}

	return apply_filters( 'zfwcs_taxonomies', $taxonomies, $post_type );

}

/**
 * Get all categories at top level
 * @param array $args
 * @param       $taxonomy
 * @return array|bool
 */
function zfwcs_get_top_categories( $args = array(), $taxonomy ) {

	$args['taxonomy'] = $taxonomy;

	if ( ! taxonomy_exists( $taxonomy ) ) {
		return false;
	}

	$categories     = get_categories( $args );
	$new_categories = array();

	if ( ! empty( $categories ) ) {

		foreach ( $categories as $cat ) {

			if ( $cat->parent == 0 ) {
				$new_categories[] = $cat;
			}

		}

	}

	return $new_categories;
}

/**
 * Get all skin styles from assets/css/skins/
 * @return array
 */
function zfwcs_get_skins() {


	// allow custom skins folder
	$dir = ZFWCS_WORDPRESS_CATEGORY_SEARCH_SKINS;

	$skins = zfwcs_get_skins_from_path( $dir );
	// custom skins
	$addition_dir = zfwcs_get_skin_dir();
	if ( $addition_dir != $dir ) {
		$custom_skins = zfwcs_get_skins_from_path( $addition_dir );
		if ( ! empty( $custom_skins ) ) {
			$skins = array_merge( $skins, $custom_skins );
		}

	}

	return $skins;
}

function zfwcs_get_skins_from_path( $dir ) {

	$skins = array();

	if ( is_dir( $dir ) ) {
		if ( $theme_dir = opendir( $dir ) ) {
			while ( ( $skin_file = readdir( $theme_dir ) ) !== false ) {
				$ext = pathinfo( $skin_file, PATHINFO_EXTENSION );
				if ( $ext == 'css' ) {
					$key                         = str_replace( '.css', '', $skin_file );
					$skins[ strtolower( $key ) ] = $skin_file;
				}
			}
		}
	}

	return $skins;
}


/**
 * get theme dir
 * @return mixed|void
 */
function zfwcs_get_skin_dir() {
	return apply_filters( 'zfwcs_skin_dir', ZFWCS_WORDPRESS_CATEGORY_SEARCH_SKINS );
}

/**
 * List all the authors of a post type, with several options available.
 * @return author array
 */
function zfwcs_get_authors( $args = '' ) {

	global $wpdb;

	$defaults = array(
		'orderby'       => 'name',
		'order'         => 'ASC',
		'number'        => '',
		'exclude_admin' => true,
		'hide_empty'    => true,
		'exclude'       => '',
		'include'       => '',
		'post_type'     => 'post'
	);

	$args = wp_parse_args( $args, $defaults );

	$query_args           = wp_array_slice_assoc( $args, array( 'orderby', 'order', 'number', 'exclude', 'include' ) );
	$query_args['fields'] = 'ids';
	$authors              = get_users( $query_args );

	$author_count = array();
	foreach ( (array) $wpdb->get_results( "SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE post_type = '{$args['post_type']}' AND " . get_private_posts_cap_sql( '' . $args['post_type'] . '' ) . " GROUP BY post_author" ) as $row ) {
		$author_count[ $row->post_author ] = $row->count;
	}

	$return = array();
	foreach ( $authors as $author_id ) {
		$author = get_userdata( $author_id );

		if ( $args['exclude_admin'] && 'admin' == $author->display_name ) {
			continue;
		}

		$posts = isset( $author_count[ $author->ID ] ) ? $author_count[ $author->ID ] : 0;

		if ( ! $posts && $args['hide_empty'] ) {
			continue;
		}

		$return[] = $author;
	}

	return $return;
}

/**
 * Render a select with object/array of array or only array
 * @param array $items object/array or root array
 * @param array $args array
 * @return string
 */

function zfwcs_render_select( $items = null, $args = array() ) {

	$defaults = array(
		'name'      => '',
		'id'        => '',
		'class'     => '',
		'multiple'  => false,
		'selected'  => array(),
		'op_attr'   => '',
		'op_option' => '',
		'key'       => '',
		'value'     => '',
	);

	$args  = wp_parse_args( $args, $defaults );
	$attrs = '';
	if ( $args['name'] != '' ) {
		$attrs .= ' name="' . $args['name'] . '"';
	}
	if ( $args['id'] != '' ) {
		$attrs .= ' id="' . $args['id'] . '"';
	}
	if ( $args['class'] != '' ) {
		$attrs .= ' class="' . $args['class'] . '"';
	}
	if ( $args['multiple'] ) {
		$attrs .= ' multiple="multiple"';
	}

	$html = '';
	if ( ! empty( $items ) ) {
		$html .= "<select " . $attrs . " " . $args['op_attr'] . ">";
		if ( $args['op_option'] != '' ) {
			$html .= $args['op_option'];
		}
		foreach ( $items as $index => $item ) {

			if ( is_object( $item ) ) {
				$key   = $item->$args['key'];
				$value = $item->$args['value'];
			} else if ( is_array( $item ) ) {
				$key   = $item[ $args['key'] ];
				$value = $item[ $args['value'] ];
			} else {
				$key   = $index;
				$value = $item;
			}


			$selected = ( in_array( $key, $args['selected'] ) ) ? 'selected' : '';
			$html .= '<option value="' . $key . '" ' . $selected . ' >' . $value . '</option>';
		}
		$html .= "</select>";
	}

	return $html;

}

/**
 * get options
 * @param array $defaults
 * @return mixed
 */
function zfwcs_get_options() {
	$defaults = array(
		'enable_awesome_font'   => 0,
		'enable_category_cache' => 0,
		'cache_time'            => 1440, //
		'skin'                  => 'dark', //
		'enable_autosuggest'    => 1, //
		'limit_suggest'         => 10, //
		'display_cat_type'      => 'tabs', //
		'tab_alignment'         => '', //
		'show_tab_all'          => 1, //
		'tab_all_icon'          => '', //
		'custom_post_type'      => 'post', //
		'custom_post_type_data' => '', //
		'orderby'               => 'name', //
		'order'                 => 'asc', //
		'exclude'               => '', //
		'number'                => '', //
		'hide_empty'            => 0, //
		'submit_label'          => esc_html__( 'Search', 'wcs' ), //
		'placeholder_input'     => esc_html__( 'Search ...', 'wcs' ), //
		'taxonomy_match_type'  => '+',
		'show_advanced_button'  => 'in',
		'advanced_button_type'  => 'icon',
		'show_subcategories'    => 1, //
		//        'show_tags'      => 1, //
		'show_price'            => 1, //
		'show_date'             => 1, //
		'show_author'           => 1, //
		'show_orderby'          => 1, //
		'show_order'            => 1, //
	);
	$defaults = apply_filters( 'zfwcs_default_options', $defaults );
	$options  = wp_parse_args( get_option( 'zfwcs_settings_options', array() ), $defaults );

	return $options;
}

/**
 * Render an icon for tabs category
 * @param      $catId
 * @param      $configs
 * @param bool $isTabAll
 */
function zfwcs_render_icon( $catId, $configs, $isTabAll = false ) {

	$icon = '';
	if ( $configs['show_tab_all'] && $isTabAll ) {
		$icon = $configs['tab_all_icon'];
	} else if ( ! $isTabAll ) {

		$options = get_option( 'zfwcs_cats_icons', array() );
		if ( isset( $options[ 'cat_icon' . $catId ] ) && ( $options[ 'cat_icon' . $catId ] != '' ) ) {
			$icon = $options[ 'cat_icon' . $catId ];
		}
	}
	if ( $icon != '' ) {

		if ( zfwcs_is_url( $icon ) ) {
			echo '<img src="' . esc_attr($icon) . '" class="zf-icon-url" />';
		} else {
			echo '<i class="fa ' . esc_attr($icon) . '"></i>';
		}
	} else {
		echo esc_html($icon);
	}

}

/**
 * Check is url from a string variable
 * @param $string
 * @return bool
 */
function zfwcs_is_url( $string ) {

	if ( $string != '' ) {

		if ( preg_match( '|^(https?:)?//|', $string ) ) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}


/**
 * Get all child categories by parent
 * @param $parent
 * @param $taxonomy
 * @return array
 */
function zfwcs_get_child_categories( $parent, $taxonomy ) {

	$arguments = array(
		//        'type' => 'product',
		'child_of'   => (int) $parent,
		'taxonomy'   => $taxonomy,
		'hide_empty' => false
	);
	//Get new $categories
	$categories = get_categories( $arguments );

	$new_cats = array();
	if ( ! empty( $categories ) ) {

		foreach ( $categories as $cat ) {

			$new_cats[] = array(
				'id'   => $cat->cat_ID,
				'slug' => $cat->slug,
				'name' => $cat->name,
			);
		}

	}

	return $new_cats;
}

/**
 * Convert a string  to boolean
 * @param $str example $str = 'false'
 * @return bool
 */
function zfwcs_string_to_boolean( $str ) {
	return ( $str == 'true' ) ? true : false;
}

/**
 * Get current taxonomy value
 * @param      $custom_post_type
 * @param      $taxonomy_cat
 * @param bool $get_var
 * @return string
 */
function zfwcs_current_taxonomy_value($custom_post_type, $taxonomy_cat, $get_var = true) {

	if ( $custom_post_type == 'post' ) {
		$taxonomy_cat = 'category_name';
	}

	if ($get_var) {
		$str = get_query_var($taxonomy_cat, '');
	} else {
		$str = isset( $_GET[ $taxonomy_cat ] ) ? $_GET[ $taxonomy_cat ] : '';
	}

	return $str;
}

/**
 * Get min/max price by post type
 * @param $post_type
 * @return array
 */
function zfwcs_get_prices( $post_type ) {

	global $wpdb;
	$min = $max = 0;
	if ( $post_type == 'product' ) {

		$min = floor( $wpdb->get_var( $wpdb->prepare( '
                                SELECT min(meta_value + 0)
                                FROM %1$s
                                LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
                                WHERE ( meta_key = \'%3$s\' OR meta_key = \'%4$s\' )
                                AND meta_value != ""
                            ', $wpdb->posts, $wpdb->postmeta, '_price', '_min_variation_price' ) ) );

		$max = ceil( $wpdb->get_var( $wpdb->prepare( '
                                SELECT max(meta_value + 0)
                                FROM %1$s
                                LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
                                WHERE meta_key = \'%3$s\'
                            ', $wpdb->posts, $wpdb->postmeta, '_price' ) ) );
	} elseif ( $post_type == 'download' ) {
		// Easy digital download
		$products = $wpdb->get_results( $wpdb->prepare( "
            SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta ON ID = post_id
            WHERE post_type = 'download' AND post_status = 'publish' AND (meta_key = %s OR meta_key = %s)
        ", 'edd_price', '_variable_pricing' ), OBJECT_K );

		$prices_filter = array();
		if ( $products ) {
			foreach ( $products as $product_id => $product ) {

				if ( edd_has_variable_prices( $product_id ) ) {
					$prices_filter[] = edd_get_lowest_price_option( $product_id );
					$prices_filter[] = edd_get_highest_price_option( $product_id );
				} else {
					$prices_filter[] = edd_get_download_price( $product_id );
				}
			}
		}

		$prices_filter = array_unique( $prices_filter );

		$min = ceil( min( $prices_filter ) );
		$max = ceil( max( $prices_filter ) );

	}

	return apply_filters( 'zfwcs_get_min_max_price', array( $min, $max ), $post_type );

}

/**
 * Get price format for post type
 * @param $price
 * @param $symbol
 * @param $position
 * @param $post_type
 * @return string
 */
function zfwcs_get_price_format( $price, $post_type ) {

	$price_symbol = $price;

	if ( $post_type == 'product' ) {

		$symbol   = get_woocommerce_currency_symbol();
		$position = get_option( 'woocommerce_currency_pos' );

		if ( $position === 'left' ) {
			$price_symbol = $symbol . $price;
		} else if ( $position === 'left_space' ) {
			$price_symbol = $symbol . " " . $price;
		} else if ( $position === 'right' ) {
			$price_symbol = $price . $symbol;
		} else if ( $position === 'right_space' ) {
			$price_symbol = $price . " " . $symbol;
		}

	} elseif ( $post_type == 'download' ) {
		$price_symbol = edd_currency_filter( $price );
	}

	return apply_filters( 'zfwcs_price_format', $price_symbol, $post_type );

}

/**
 * Render open advanced button
 * @param bool $hide_icon
 * @param bool $hide_text
 */
function zfwcs_open_advanced_button($configs = array()) {
	?>
		<a class="open-advanced-search" href="#" data-popup-id="advanced-search-box">
			<?php if ($configs['advanced_button_type'] == 'icon' ||  $configs['advanced_button_type'] == 'both') {?>
		    <span class="advanced-search-icon"></span>
			<?php } ?>
			<?php if ($configs['advanced_button_type'] == 'text' ||  $configs['advanced_button_type'] == 'both') {?>
		    <span class="advanced-search-text">
			    <?php esc_html_e( 'Advanced search', 'wcs' ) ?>
		    </span>
			<?php } ?>
	    </a>
	<?php
}

/**
 * Render form search html
 * @param string $id
 * @param array  $configs
 */
function zfwcs_render_form_search( $id = '', $configs = array() ) {
	global $zfwcs;

	$options                      = zfwcs_get_options();
	$custom_post_type_data_origin = $options['custom_post_type_data'];
	$custom_post_type_data        = ( $custom_post_type_data_origin != '' ) ? json_decode( $custom_post_type_data_origin, true ) : array();
	$custom_post_type             = $options['custom_post_type'];

	// notice to users if the plugin does not active
	if ( ! post_type_exists( $custom_post_type ) ) {
		echo esc_html__( 'Custom post type does not exist or it has deactived, check custom post type again, in the setting page', 'wcs' );

		return;
	}
	if ( empty( $custom_post_type_data ) ) {
		return;
	}

	$category_type = explode( ',', $custom_post_type_data['category-type'] );

	$configs = array_merge( $configs, array(
		'cat_type'              => $category_type[0],
		'taxonomy'              => $category_type[0],
		'display_cat_type'      => $options['display_cat_type'],
		'tab_alignment'         => $options['tab_alignment'],
		'show_tab_all'          => $options['show_tab_all'],
		'tab_all_icon'          => $options['tab_all_icon'],
		'custom_post_type'      => $options['custom_post_type'],
		'custom_post_type_data' => $custom_post_type_data,
		'orderby'               => $options['orderby'],
		'order'                 => $options['order'],
		'exclude'               => $options['exclude'],
		'number'                => $options['number'],
		'hide_empty'            => $options['hide_empty'],
		'submit_label'          => $options['submit_label'],
		'placeholder_input'     => $options['placeholder_input'],
		'taxonomy_match_type'     => $options['taxonomy_match_type'],
		'show_advanced_button'     => $options['show_advanced_button'],
		'advanced_button_type'     => $options['advanced_button_type'],
		'show_subcategories'    => $options['show_subcategories'],
		'show_price'            => $options['show_price'],
		'show_date'             => $options['show_date'],
		'show_author'           => $options['show_author'],
		'show_orderby'          => $options['show_orderby'],
		'show_order'            => $options['show_order'],
	) );

	// load form template
	if ( file_exists( ZFWCS_WORDPRESS_CATEGORY_SEARCH_THEME_PATH . 'zf-wrodpress-category-search/form.php' ) ) {
		include_once(ZFWCS_WORDPRESS_CATEGORY_SEARCH_THEME_PATH . 'zf-wrodpress-category-search/form.php');
	} else if ( file_exists( ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_PATH . 'templates/form.php') ) {
		include_once(ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_PATH . 'templates/form.php');
	} else {
		return esc_html__( 'Not found template', 'wcs');
	}

	ob_start();
	?>
	<script type="text/javascript">
        /* <![CDATA[ */
        (function ($) {
            "use strict";
	        $('#zf-cs-container-<?php echo esc_attr($id);?>').zfcategorysearch({
		        displayCatType: '<?php echo esc_attr($configs['display_cat_type']);?>',
		        tabAlignment: '<?php echo esc_attr($configs['tab_alignment']);?>',
		        dropdownWidth: '200',
		        dropdownPlaceholder: '<?php esc_html_e('Select category', 'wcs');?>',
		        dropdownSelectAllText: '<?php esc_html_e('All Categories', 'wcs');?>',
		        minumimCountSelected: <?php echo (int) apply_filters('min_count_select', 0);?>,
		        showSubCategories: <?php echo (int)$configs['show_subcategories'];?>,
		        enableAutoSuggest: <?php echo (int)$options['enable_autosuggest'];?>,
		        limitSuggest: <?php echo (int)$options['limit_suggest'];?>,
		        matchType: '<?php echo esc_attr($configs['taxonomy_match_type']);?>'
	        });

        })(jQuery);

        /* ]]> */
    </script>
	<?php
	$js = ob_get_clean();
	$zfwcs->add_footer_extra( $js );
}
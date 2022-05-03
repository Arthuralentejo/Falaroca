<?php
 /**
 * @version    $Version$
 * @package    ZF WordPress Category Search
 * @author     ZuFusion Team
 * @copyright  Copyright (C) 2021 ZuFusion.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

class ZFWCS_Taxonomy_Walker extends Walker {

    private $taxonomy = 'post_tag';
    private $values = array();
    private $type = 'option'; //
    private $option_type = 'id'; // slug or id
    private $wrap_level = '';


    public $db_fields = array ('parent' => 'parent', 'id' => 'term_id');


    function __construct($taxonomy = 'category', $type = 'dropdown', $option_type = 'id',  $values = array(), $wrap_level = '')  {

        $this->taxonomy = $taxonomy;
        $this->type = $type;
        $this->values = $values;
        $this->tree_type = $taxonomy;
        $this->option_type = $option_type;
        $this->wrap_level = $wrap_level;
    }

    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {

        if ($this->wrap_level == 'ul') {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"sub-ul-list\">\n";
        } else {

        }

    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {

        if ($this->wrap_level == 'ul') {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }

    }


    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        $pad = str_repeat('&nbsp;', $depth * 3);

        $item_name = $item->name;
        $value = $item->term_id;
        if ($this->option_type == 'slug') { $value = $item->slug;}

        if ($this->type == 'option') {
            $output .= "\t<option class=\"option-taxonomy level-$depth\" value=\"".$value."\"";

            if ( in_array($value, (array)$args['selected'])) {
                $output .= ' selected="selected"';
            }

            $output .= '>';
            $output .= $pad.$item_name;
            if ( $args['show_count'] )
                $output .= '&nbsp;&nbsp;('. number_format_i18n( $item->count ) .')';
            $output .= "</option>\n";

        } else if ($this->type == 'li_checkbox') {

            $output .= "\t<li class=\"checkbox-taxonomy level-$depth\">";

            $checked = '';

            if ( in_array($value, (array)$args['selected'])) {
                $checked = ' checked';
            }
            $output .= '<input id="checkbox-' . esc_attr($value) . '"' . $checked . ' type="checkbox" value="' . esc_attr($value) . '">';
            $output .= '<label for="checkbox-' . esc_attr($value) . '"><span></span>' . $pad.$item_name . '</label>';

        }

    }

    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Page data object. Not used.
     * @param int    $depth  Depth of page. Not Used.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {

        if ($this->wrap_level == 'ul') {
            $output .= "</li>\n";
        }
    }


}
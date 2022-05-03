<?php
/**
 * @version    $Version$
 * @package    ZF WordPress Category Search
 * @author     ZuFusion Team
 * @copyright  Copyright (C) 2021 ZuFusion. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

function zfwcs_category_search_shortcode( $atts, $content = null )
{
    extract( shortcode_atts( array(
        'title' => '',
    ), $atts ) );

    $shortcode_id = 'zfwcs_shortcode_' . rand(1, 10000);

    $title = empty($title) ? '' : apply_filters('zfwcs_title', $title);
    ob_start();
    if ($title != '') { ?>
        <h3><?php echo esc_attr($title);?></h3>
    <?php }

    zfwcs_render_form_search($shortcode_id);
    return ob_get_clean();
}

add_shortcode('zfwcs', 'zfwcs_category_search_shortcode');

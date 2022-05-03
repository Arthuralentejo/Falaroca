<?php

/**
 * @version    $Version$
 * @package    ZF WordPress Category Search
 * @author     ZuFusion Team
 * @copyright  Copyright (C) 2021 ZuFusion. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
class ZFWCS_Wordpress_Category_Search_Widget extends WP_Widget
{
    var $style = '';

    function __construct()
    {
        $widget_ops = array(
            'name'        => esc_html__('ZF WordPress Category Search', 'wcs'),
            'description' => esc_html__('It is a WordPress advanced search box, support WordPress, WooCommerce, custom post type, multiple taxonomies', 'wcs')
        );
        parent::__construct('zfwcs_widget', esc_html__('ZF WordPress Category Search', 'wcs'), $widget_ops);
    }

    public function form($instance)
    {
        $instance = wp_parse_args($instance,
            array(
                'title' => '',
            )
        );

        $title = esc_attr($instance['title']);

        ?>

        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'wcs'); ?>
                : </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>

        <p>
            <label><?php esc_html_e('Setting page', 'wcs'); ?> :</label>
            <a href="<?php echo esc_url(get_admin_url()) . 'options-general.php?page=zfwcs-settings'; ?>"
               target="_blank"><?php esc_html_e('Click here', 'wcs'); ?></a>
        </p>

    <?php

    }

    function update($new_instance, $old_instance)
    {

        $instance          = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }

    public function widget($args, $instance)
    {

        extract($args, EXTR_SKIP);

        echo wp_kses_normalize_entities($before_widget);

        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);

        if (!empty($title)) {
            echo wp_kses_normalize_entities($before_title . $title . $after_title);
        }

        zfwcs_render_form_search($this->id);

        echo wp_kses_normalize_entities($after_widget);
    }


}
<?php
/**
 * @version    $Version$
 * @package    ZF WordPress Category Search
 * @author     ZuFusion Team
 * @copyright  Copyright (C) 2021 ZuFusion.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

?>
<div id="available-taxonomies-box">
    <p><?php esc_html_e('Available Elements (Taxonomies)', 'wcs'); ?>: </label></p>
    <ul data-key="taxonomies" class="sortable-elements">
        <?php
        $taxonomies_box = !(empty($custom_post_type_data)) ? explode(',', $custom_post_type_data['taxonomies']) : array();
        foreach ($taxonomies as $key => $taxonomy) {

            $li = '<li class="sortable-element" id="' . esc_attr($key) . '" data-key="' . esc_attr($key) . '" data-label="' . esc_attr($taxonomy->label) . '">' . esc_attr($taxonomy->label) . '</li>';
            if (!(empty($custom_post_type_data))) {
                if (in_array($key, $taxonomies_box)) {
                    echo wp_kses_normalize_entities($li);
                }
            } else {
                echo wp_kses_normalize_entities($li);
            }

        }
        ?>
    </ul>
</div>
<br/>
<hr/>
<div id="custom-post-type-category" class="column first">
    <p><?php esc_html_e('Category', 'wcs'); ?> : </p>
    <ul data-key="category-type" class="sortable-elements">
        <?php
        if (!(empty($custom_post_type_data))) {
            $category_type = explode(',', $custom_post_type_data['category-type']);
            if (count($category_type)) {

                foreach ($category_type as $ct) {
                    $taxonomy = get_taxonomy($ct);
                    if ($taxonomy) {
                        echo '<li class="sortable-element" id="' . esc_attr($ct) . '" data-key="' . esc_attr($ct) . '" data-label="' . esc_attr($taxonomy->label) . '">' . esc_attr($taxonomy->label) . '</li>';
                    }
                }
            }
        }
        ?>
    </ul>
    <p><?php esc_html_e('You must choose exactly "categories" element by moving it from "Available Elements" box to display at the frontend. It is to distinguish categories of custom post type that. so if a custom post type that doesn\'t have any taxonomies make it as categories that mean it is beyond this plugin. Leave blank if you only want to search with advanced box', 'wcs'); ?></p>
</div>

<div id="advanced-search-box" class="column">
    <p><?php esc_html_e('Append to advanced search box', 'wcs'); ?> : </p>
    <ul data-key="advanced" class="sortable-elements">
        <?php
        if (!(empty($custom_post_type_data))) {
            $advanced_fields = explode(',', $custom_post_type_data['advanced']);
            if (count($advanced_fields)) {
                foreach ($advanced_fields as $field) {
                    $taxonomy = get_taxonomy($field);
                    if ($taxonomy) {
                        echo '<li class="sortable-element" id="' . esc_attr($field) . '" data-key="' . esc_attr($field) . '" data-label="' . esc_attr($taxonomy->label) . '">' . esc_attr($taxonomy->label) . '</li>';
                    }
                }
            }
        }
        ?>
    </ul>
    <p><?php esc_html_e('Move elements that you want to advanced search box', 'wcs'); ?></p>
    <br/>
    <hr/>
    <p><?php esc_html_e('Search multiple for', 'wcs'); ?> : </p>
    <ul id="advanced-multiple-elements">
        <?php
        if (!(empty($custom_post_type_data))) {
            $advanced_fields   = explode(',', $custom_post_type_data['advanced']);
            $advanced_multiple = explode(',', $custom_post_type_data['advanced-multiple']);
            $use_checkbox = explode(',', $custom_post_type_data['use-checkbox']);
            if (count($advanced_fields)) {
                foreach ($advanced_fields as $field) {
                    $taxonomy = get_taxonomy($field);
                    if ($taxonomy) {
                        $selected = '';
                        $selected_use_checkbox = '';
                        $disabled = '';
                        if (in_array($field, $advanced_multiple)) {
                            $selected = ' checked';
                        } else {
                            $disabled = ' disabled="true"';
                        }

                        if (in_array($field, $use_checkbox)) {
                            $selected_use_checkbox =  ' checked';
                        }

                        echo '<li><label for="checkbox-' . esc_attr($taxonomy->name) . '"><input type="checkbox" name="checkbox-' . esc_attr($taxonomy->name) . '" id="checkbox-' . esc_attr($taxonomy->name) . '" data-key="' . esc_attr($taxonomy->name) . '"' . $selected . '> ' . esc_attr($taxonomy->label) . '</label>';
                        echo '<label class="use-checkbox"><input type="checkbox" name="use-checkbox-' . esc_attr($taxonomy->name) . '" id="use-checkbox-' . esc_attr($taxonomy->name) . '" class="is-checkbox-field" data-key="' . esc_attr($taxonomy->name) . '"' . $disabled . $selected_use_checkbox . '> ' . esc_html('Use checkbox?', 'wcs'). '</label>';
                        echo '</li>';
                    }
                }
            }
        }
        ?>
    </ul>

</div>

<input name="zfwcs_settings_options[custom_post_type_data]" id="custom_post_type_data" type="hidden"
       value="<?php echo esc_html($custom_post_type_data_origin); ?>"/>
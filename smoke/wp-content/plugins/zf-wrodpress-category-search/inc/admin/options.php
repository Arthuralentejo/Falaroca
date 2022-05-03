<?php
 /**
 * @version    $Version$
 * @package    ZF WordPress Category Search
 * @author     ZuFusion Team
 * @copyright  Copyright (C) 2021 ZuFusion.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
}
$options = zfwcs_get_options();
$skins = zfwcs_get_skins();
$custom_post_type_data_origin = $options['custom_post_type_data'];
$custom_post_type_data = ($custom_post_type_data_origin != '' ) ? json_decode($custom_post_type_data_origin, true) : array();
$custom_post_type = $options['custom_post_type'];

if ( !post_type_exists( $custom_post_type ) ) {
    $custom_post_type = 'post';
    $custom_post_type_data_origin = '';
    $custom_post_type_data = array();
}

$taxonomies = zfwcs_get_taxonomies($custom_post_type);

$args = array(
    'public'   => true,
    '_builtin' => false
);

$output = 'objects'; // names or objects, note names is the default
$operator = 'and'; // 'and' or 'or'

$post_types = get_post_types( $args, $output, $operator );


?>

<div class="wrap">
    <div id="icon-options-general" class="icon32"></div>
    <h2><?php esc_html_e('General Settings', 'wcs') ?></h2>
    <form method="post" action="options.php">
        <?php settings_fields('zfwcs_settings_fields'); ?>
        <table class="form-table">
            <tbody>
            <!--Hook Header-->
            <?php do_action('zfwcs_footer_setting_page', $custom_post_type, $options );?>
                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[enable_awesome_font]"><?php esc_html_e('Awesome Font', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Awesome Font', 'wcs');?></span></legend>
                            <label for="zfwcs_settings_options[enable_awesome_font]">
                                <input name="zfwcs_settings_options[enable_awesome_font]" type="radio" id="zfwcs_settings_options[enable_awesome_font]" value="0" <?php checked('0', $options['enable_awesome_font']); ?>>
                                <?php esc_html_e('Using local', 'wcs');?></label>
                            <label for="zfwcs_settings_options[enable_awesome_font]">
                                <input name="zfwcs_settings_options[enable_awesome_font]" type="radio" id="zfwcs_settings_options[enable_awesome_font]" value="-1" <?php checked('-1', $options['enable_awesome_font']); ?>>
                                <?php esc_html_e('Disable', 'wcs');?></label>
                            <p><span><?php esc_html_e('Using Local, the file will be loaded from the plugin<br>
                                    Disable, only use this option when you know that it was loaded before by another the plugins/themes', 'wcs');?></span> </p>
                        </fieldset>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[enable_category_cache]"><?php esc_html_e('Caching category', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Enable category cache', 'wcs');?></span></legend>
                            <label for="zfwcs_settings_options[enable_category_cache]">
                                <input name="zfwcs_settings_options[enable_category_cache]" type="radio" id="zfwcs_settings_options[enable_category_cache]" value="1" <?php checked('1', $options['enable_category_cache']); ?>>
                                <?php esc_html_e('Enable', 'wcs');?></label>
                            <label for="zfwcs_settings_options[enable_category_cache]">
                                <input name="zfwcs_settings_options[enable_category_cache]" type="radio" id="zfwcs_settings_options[enable_category_cache]" value="0" <?php checked('0', $options['enable_category_cache']); ?>>
                                <?php esc_html_e('Disable', 'wcs');?></label>
                            <p><span><?php esc_html_e('Caching child categories for tab/radio option.', 'wcs');?></span> </p>
                        </fieldset>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Cache time', 'wcs');?></span></legend>
                            <label for="zfwcs_settings_options[cache_time]"><?php esc_html_e('Cache time', 'wcs');?>: </label>
                                <input name="zfwcs_settings_options[cache_time]" type="text" id="zfwcs_settings_options[cache_time]" value="<?php echo esc_attr($options['cache_time']);?>"/> <?php esc_html_e('(in minutes)', 'wcs');?>
                                <p><span><?php esc_html_e('The cache time to refresh data again', 'wcs');?></span> </p>
                        </fieldset>

                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[skin]"><?php esc_html_e('Skins', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Skins', 'wcs');?></span></legend>
                            <select name="zfwcs_settings_options[skin]" id="zfwcs_settings_options[skin]">
                                <?php
                                    foreach ($skins as $key => $skin) {
                                        $selected = ($key == $options['skin']) ? 'selected' : '';
                                        echo '<option value="'.esc_attr($key).'" '.$selected.'>'.esc_attr($key).'</option>';
                                    }
                                ?>
                            </select>
                            <p><span><?php esc_html_e('Choose skin for the plugin (default is dark)', 'wcs');?></span> </p>
                        </fieldset>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[enable_autosuggest]"><?php esc_html_e('Enable AutoSuggest', 'wcs');?>: </label>
                    </th>
                    <td>

                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Enable AutoSuggest', 'wcs');?></span></legend>
                            <label for="zfwcs_settings_options[enable_autosuggest]">
                                <input name="zfwcs_settings_options[enable_autosuggest]" type="radio" id="zfwcs_settings_options[enable_autosuggest]" value="1" <?php checked('1', $options['enable_autosuggest']); ?>>
                                <?php esc_html_e('Enable', 'wcs');?></label>
                            <label for="zfwcs_settings_options[enable_autosuggest]">
                                <input name="zfwcs_settings_options[enable_autosuggest]" type="radio" id="zfwcs_settings_options[enable_autosuggest]" value="0" <?php checked('0', $options['enable_autosuggest']); ?>>
                                <?php esc_html_e('Disable', 'wcs');?></label>
                            <p><span><?php esc_html_e('The Auto suggest query like google suggest while you type into the field.', 'wcs');?></span> </p>
                        </fieldset>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Limit suggest', 'wcs');?></span></legend>
                            <label for="zfwcs_settings_options[limit_suggest]"><?php esc_html_e('Limit number of suggestions', 'wcs');?>: </label>
                            <input name="zfwcs_settings_options[limit_suggest]" type="text" id="zfwcs_settings_options[limit_suggest]" value="<?php echo esc_attr($options['limit_suggest']);?>"/>
                        </fieldset>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[custom_post_type]"><?php esc_html_e('Custom post type', 'wcs');?>: </label>
                    </th>
                    <td>

                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Custom post type', 'wcs');?></span></legend>

                            <?php

                            echo '<select name="zfwcs_settings_options[custom_post_type]" id="custom_post_type">';
                            echo '<option value="post" '.selected($custom_post_type, 'post').'>'.__('Post', 'wcs').'</option>';
                            foreach ( $post_types  as $post_type ) {

                                echo '<option value="'.$post_type->name.'" '.selected($custom_post_type, $post_type->name).'>' . $post_type->label . '</option>';
                            }
                            echo '</select';
                            ?>
                            <br/>
                            <p><?php esc_html_e('Select any custom post type to configure.', 'wcs');?></p>
                        </fieldset>

                        <br/>
                        <hr/>
                        <div id="elements-box">
                            <?php include('options-custom-post-type.php');?>
                        </div>

                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[taxonomy_match_type]"><?php esc_html_e('Match type', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Match type', 'wcs');?></span></legend>
                            <select name="zfwcs_settings_options[taxonomy_match_type]" id="zfwcs_settings_options[taxonomy_match_type]">
                                <option
                                    value="+"<?php selected($options['taxonomy_match_type'], '+'); ?>><?php esc_html_e('AND', 'wcs'); ?></option>
                                <option
                                    value=","<?php selected($options['taxonomy_match_type'], ','); ?>><?php esc_html_e('OR', 'wcs'); ?></option>
                            </select>

                            <p><span><?php esc_html_e('AND: Display posts that have "all" of these taxonomy values(categories) <br> OR: Display posts that have these these taxonomy values(categories): ', 'wcs');?></span> </p>
                        </fieldset>

                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[display_cat_type]"><?php esc_html_e('Display category', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Display category', 'wcs');?></span></legend>
                            <select name="zfwcs_settings_options[display_cat_type]" id="zfwcs_settings_options[display_cat_type]" class="zf-depend">
                                <option
                                    value="tabs"<?php selected($options['display_cat_type'], 'tabs'); ?>><?php esc_html_e('Tabs', 'wcs'); ?></option>
                                <option
                                    value="dropdown"<?php selected($options['display_cat_type'], 'dropdown'); ?>><?php esc_html_e('Dropdown', 'wcs'); ?></option>
                                <option
                                    value="radio"<?php selected($options['display_cat_type'], 'radio'); ?>><?php esc_html_e('Radio', 'wcs'); ?></option>
                            </select>
                            <p><?php esc_html_e('Display categories as tabs/dropdown/radio.', 'wcs');?> </p>
                        </fieldset>
                    </td>
                </tr>

                <tr data-for="zfwcs_settings_options[display_cat_type]" data-value="tabs">
                    <th scope="row">
                        <label for="zfwcs_settings_options[tab_alignment]"><?php esc_html_e('Tab alignment', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Tab alignment', 'wcs');?></span></legend>
                            <select name="zfwcs_settings_options[tab_alignment]" id="zfwcs_settings_options[tab_alignment]">
                                <option
                                    value="tab-left"<?php selected($options['tab_alignment'], 'tab-left'); ?>><?php esc_html_e('Left', 'wcs'); ?></option>
                                <option
                                    value="tab-center"<?php selected($options['tab_alignment'], 'tab-center'); ?>><?php esc_html_e('Center', 'wcs'); ?></option>
                                <option
                                    value="tab-right"<?php selected($options['tab_alignment'], 'tab-right'); ?>><?php esc_html_e('Right', 'wcs'); ?></option>
                            </select>
                            <p><span><?php esc_html_e('The alignment of tabs. (Left/Center/Right)', 'wcs');?></span> </p>

                        </fieldset>
                    </td>
                </tr>

                <tr data-for="zfwcs_settings_options[display_cat_type]" data-value="tabs">
                    <th scope="row">
                        <label for="zfwcs_settings_options[show_tab_all]"><?php esc_html_e('Show tab all', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Show tab all', 'wcs');?></span></legend>
                            <label for="zfwcs_settings_options[show_tab_all]">
                                <input name="zfwcs_settings_options[show_tab_all]" type="radio" id="zfwcs_settings_options[show_tab_all]" value="1" <?php checked('1', $options['show_tab_all']); ?>>
                                <?php esc_html_e('Show', 'wcs');?></label>
                            <label for="zfwcs_settings_options[show_tab_all]">
                                <input name="zfwcs_settings_options[show_tab_all]" type="radio" id="zfwcs_settings_options[show_tab_all]" value="0" <?php checked('0', $options['show_tab_all']); ?>>
                                <?php esc_html_e('Hide', 'wcs');?></label>
                            <p><?php esc_html_e('Show tab all categories.', 'wcs');?></p>
                        </fieldset>
                    </td>
                </tr>

                <tr data-for="zfwcs_settings_options[display_cat_type]" data-value="tabs">
                    <th scope="row">
                        <label for="zfwcs_settings_options[tab_all_icon]"><?php esc_html_e('Icon tab all', 'wcs');?>:</label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Icon tab all', 'wcs');?></span></legend>
                            <input name="zfwcs_settings_options[tab_all_icon]" type="text" id="tab_all_icon" class="zfwcs_icon_value" value="<?php echo esc_attr($options['tab_all_icon']);?>"/>  <a href="#" id="zfwcs_insert_all_icon" class="zfwcs_insert_all_icon"><?php esc_html_e('Insert Icon', 'wcs'); ?></a>
                            <p><?php esc_html_e('Icon for tab all categories, click on insert icon button to add an awesome font code, or you also can enter a the image url. Add icon for each tab category, you go to categories management of custom post type, you can see a the category icon option, choosen an awesome font or enter an image url. <br/> For example, the custom post type is post, you go to Posts -> Categories', 'wcs');?></p>
                        </fieldset>
                    </td>
                </tr>


                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[orderby]"><?php esc_html_e('Order By', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Order By', 'wcs');?></span></legend>
                            <select name="zfwcs_settings_options[orderby]" id="zfwcs_settings_options[orderby]">
                                <option
                                    value=""<?php selected($options['orderby'], ''); ?>><?php esc_html_e('ID', 'wcs'); ?></option>
                                <option
                                    value="name"<?php selected($options['orderby'], 'name'); ?>><?php esc_html_e('Name', 'wcs'); ?></option>
                                <option
                                    value="count"<?php selected($options['orderby'], 'count'); ?>><?php esc_html_e('Count', 'wcs'); ?></option>
                            </select>

                            <p><span><?php esc_html_e('Specify how to sort the display categories order by ID, Name, Count. This option only be applied when you chose a taxonomy for category box', 'wcs');?></span> </p>
                        </fieldset>

                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[order]"><?php esc_html_e('Order', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Order', 'wcs');?></span></legend>
    <!--                            <label for="zfwcs_settings_options[order]">--><?php //esc_html_e('Order', 'wcs');?><!--: </label>-->
                            <select name="zfwcs_settings_options[order]" id="zfwcs_settings_options[order]">
                                <option
                                    value="asc"<?php selected($options['order'], 'asc'); ?>><?php esc_html_e('Asc', 'wcs'); ?></option>
                                <option
                                    value="desc"<?php selected($options['order'], 'desc'); ?>><?php esc_html_e('Desc', 'wcs'); ?></option>
                            </select>

                            <p><span><?php esc_html_e('Specify the sort order used to display categories Asc or Desc. This option only be applied when you chose a taxonomy for category box', 'wcs');?></span> </p>
                        </fieldset>

                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[exclude]"><?php esc_html_e('Exclude', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Exclude', 'wcs');?></span></legend>
    <!--                            <label for="zfwcs_settings_options[exclude]">--><?php //esc_html_e('Exclude', 'wcs');?><!--: </label>-->
                            <input name="zfwcs_settings_options[exclude]" type="text" id="zfwcs_settings_options[exclude]" value="<?php echo esc_attr($options['exclude']);?>"/>
                            <p><span><?php esc_html_e('Category IDs, separated by commas. This option only be applied when you chose a taxonomy for category box', 'wcs');?></span> </p>
                        </fieldset>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[number]"><?php esc_html_e('Limit number of categories', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Limit number of categories', 'wcs');?></span></legend>
    <!--                            <label for="zfwcs_settings_options[number]">--><?php //esc_html_e('Exclude', 'wcs');?><!--: </label>-->
                            <input name="zfwcs_settings_options[number]" type="text" id="zfwcs_settings_options[number]" value="<?php echo esc_attr($options['number']);?>"/>
                            <p><span><?php esc_html_e('Limit number of categories is displayed, leave blank is unlimited. This option only be applied when you chose a taxonomy for category box', 'wcs');?></span> </p>
                        </fieldset>

                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[hide_empty]"><?php esc_html_e('Hide Empty', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Hide Empty', 'wcs');?></span></legend>
                            <label for="zfwcs_settings_options[hide_empty]">
                                <input name="zfwcs_settings_options[hide_empty]" type="radio" id="zfwcs_settings_options[hide_empty]" value="1" <?php checked('1', $options['hide_empty']); ?>>
                                <?php esc_html_e('Yes', 'wcs');?></label>
                            <label for="zfwcs_settings_options[hide_empty]">
                                <input name="zfwcs_settings_options[hide_empty]" type="radio" id="zfwcs_settings_options[hide_empty]" value="0" <?php checked('0', $options['hide_empty']); ?>>
                                <?php esc_html_e('No', 'wcs');?></label>
                            <p><?php esc_html_e('Will not display empty category. This option only be applied when you chose a taxonomy for category box', 'wcs');?></p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[submit_label]"><?php esc_html_e('Submit label', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Submit label', 'wcs');?></span></legend>
                            <input name="zfwcs_settings_options[submit_label]" type="text" id="zfwcs_settings_options[submit_label]" value="<?php echo esc_attr($options['submit_label']);?>"/>
                            <p><?php esc_html_e('Label of submit button.', 'wcs');?></p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[placeholder_input]"><?php esc_html_e('Placeholder input', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Placeholder input', 'wcs');?></span></legend>
                            <input name="zfwcs_settings_options[placeholder_input]" type="text" id="zfwcs_settings_options[placeholder_input]" value="<?php echo esc_attr($options['placeholder_input']);?>"/>
                            <p><?php esc_html_e('Placeholder of input query.', 'wcs');?></p>
                        </fieldset>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[show_advanced_button]"><?php esc_html_e('Show Advanced button at', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Show Advanced button at', 'wcs');?></span></legend>
                            <select name="zfwcs_settings_options[show_advanced_button]" id="zfwcs_settings_options[show_advanced_button]">
                                <option
                                    value="in"<?php selected($options['show_advanced_button'], 'in'); ?>><?php esc_html_e('In', 'wcs'); ?></option>
                                <option
                                    value="out"<?php selected($options['show_advanced_button'], 'out'); ?>><?php esc_html_e('Out', 'wcs'); ?></option>
                            </select>

                            <p><span><?php esc_html_e('Show open advanced button inside or outside input query', 'wcs');?></span> </p>
                        </fieldset>

                    </td>
                </tr>


                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[advanced_button_type]"><?php esc_html_e('Advanced button type', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Advanced button type', 'wcs');?></span></legend>
                            <select name="zfwcs_settings_options[advanced_button_type]" id="zfwcs_settings_options[advanced_button_type]">
                                <option
                                    value="icon"<?php selected($options['advanced_button_type'], 'icon'); ?>><?php esc_html_e('Icon only', 'wcs'); ?></option>
                                <option
                                    value="text"<?php selected($options['advanced_button_type'], 'text'); ?>><?php esc_html_e('Text only', 'wcs'); ?></option>
                                <option
                                    value="both"<?php selected($options['advanced_button_type'], 'both'); ?>><?php esc_html_e('Icon vs Text', 'wcs'); ?></option>
                            </select>

                            <p><span><?php esc_html_e('Show advanced button with icon or text or both', 'wcs');?></span> </p>
                        </fieldset>

                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[show_subcategories]"><?php esc_html_e('Show Subcategories', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Show Subcategories', 'wcs');?></span></legend>
                            <label for="zfwcs_settings_options[show_subcategories]">
                                <input name="zfwcs_settings_options[show_subcategories]" type="radio" id="zfwcs_settings_options[show_subcategories]" value="1" <?php checked('1', $options['show_subcategories']); ?>>
                                <?php esc_html_e('Show', 'wcs');?></label>
                            <label for="zfwcs_settings_options[show_subcategories]">
                                <input name="zfwcs_settings_options[show_subcategories]" type="radio" id="zfwcs_settings_options[show_subcategories]" value="0" <?php checked('0', $options['show_subcategories']); ?>>
                                <?php esc_html_e('Hide', 'wcs');?></label>
                            <p><?php esc_html_e('Show/Hide subcategories search, when click on a tab/radio item then it will get all child categories of it.', 'wcs');?></p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[show_price]"><?php esc_html_e('Show Price', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Show Price', 'wcs');?></span></legend>
                            <label for="zfwcs_settings_options[show_price]">
                                <input name="zfwcs_settings_options[show_price]" type="radio" id="zfwcs_settings_options[show_price]" value="1" <?php checked('1', $options['show_price']); ?>>
                                <?php esc_html_e('Show', 'wcs');?></label>
                            <label for="zfwcs_settings_options[show_price]">
                                <input name="zfwcs_settings_options[show_price]" type="radio" id="zfwcs_settings_options[show_price]" value="0" <?php checked('0', $options['show_price']); ?>>
                                <?php esc_html_e('Hide', 'wcs');?></label>
                            <p><?php esc_html_e('Show/Hide price search. it can only display if it supported by this plugin, or hook to this plugin by another plugins/themes.', 'wcs');?></p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[show_date]"><?php esc_html_e('Show Date', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Show Date', 'wcs');?></span></legend>
                            <label for="zfwcs_settings_options[show_date]">
                                <input name="zfwcs_settings_options[show_date]" type="radio" id="zfwcs_settings_options[show_date]" value="1" <?php checked('1', $options['show_date']); ?>>
                                <?php esc_html_e('Show', 'wcs');?></label>
                            <label for="zfwcs_settings_options[show_date]">
                                <input name="zfwcs_settings_options[show_date]" type="radio" id="zfwcs_settings_options[show_date]" value="0" <?php checked('0', $options['show_date']); ?>>
                                <?php esc_html_e('Hide', 'wcs');?></label>
                            <p><?php esc_html_e('Show/Hide date range search.', 'wcs');?></p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[show_author]"><?php esc_html_e('Show Author', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Show Author', 'wcs');?></span></legend>
                            <label for="zfwcs_settings_options[show_author]">
                                <input name="zfwcs_settings_options[show_author]" type="radio" id="zfwcs_settings_options[show_author]" value="1" <?php checked('1', $options['show_author']); ?>>
                                <?php esc_html_e('Show', 'wcs');?></label>
                            <label for="zfwcs_settings_options[show_author]">
                                <input name="zfwcs_settings_options[show_author]" type="radio" id="zfwcs_settings_options[show_author]" value="0" <?php checked('0', $options['show_author']); ?>>
                                <?php esc_html_e('Hide', 'wcs');?></label>
                            <p><?php esc_html_e('Show/Hide author search.', 'wcs');?></p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[show_orderby]"><?php esc_html_e('Show Orderby', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Show Orderby', 'wcs');?></span></legend>
                            <label for="zfwcs_settings_options[show_orderby]">
                                <input name="zfwcs_settings_options[show_orderby]" type="radio" id="zfwcs_settings_options[show_orderby]" value="1" <?php checked('1', $options['show_orderby']); ?>>
                                <?php esc_html_e('Show', 'wcs');?></label>
                            <label for="zfwcs_settings_options[show_orderby]">
                                <input name="zfwcs_settings_options[show_orderby]" type="radio" id="zfwcs_settings_options[show_orderby]" value="0" <?php checked('0', $options['show_orderby']); ?>>
                                <?php esc_html_e('Hide', 'wcs');?></label>
                            <p><?php esc_html_e('Show/Hide order by search.', 'wcs');?></p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="zfwcs_settings_options[show_order]"><?php esc_html_e('Show Order', 'wcs');?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Show Order', 'wcs');?></span></legend>
                            <label for="zfwcs_settings_options[show_order]">
                                <input name="zfwcs_settings_options[show_order]" type="radio" id="zfwcs_settings_options[show_order]" value="1" <?php checked('1', $options['show_order']); ?>>
                                <?php esc_html_e('Show', 'wcs');?></label>
                            <label for="zfwcs_settings_options[show_order]">
                                <input name="zfwcs_settings_options[show_order]" type="radio" id="zfwcs_settings_options[show_order]" value="0" <?php checked('0', $options['show_order']); ?>>
                                <?php esc_html_e('Hide', 'wcs');?></label>
                            <p><?php esc_html_e('Show/Hide order(sort).', 'wcs');?></p>
                        </fieldset>
                    </td>
                </tr>

                <!--Hook footer-->
                <?php do_action('zfwcs_footer_setting_page', $custom_post_type, $options );?>
            </tbody>
        </table>
        <p style="margin-top:20px;">
            <?php submit_button(); ?>
        </p>
    </form>

</div>

<script type="text/javascript">

    (function ($) {
        "use strict";
        $('#zfwcs_insert_all_icon').on('click', function (event) {
            event.preventDefault();
            tb_show('<?php esc_html_e("Insert Icon.", 'wcs'); ?>', 'admin.php?zfwcs_insert_icon=1&element_id=tab_all_icon');
        });

    })(jQuery);

</script>


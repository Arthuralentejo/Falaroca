<?php

/**
 * @version    $Version$
 * @package    ZF WordPress Category Search
 * @author     ZuFusion Team
 * @copyright  Copyright (C) 2021 ZuFusion.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
class ZFWCS_Wordpress_Category_Search_Admin_Taxonomy
{

    /**
     * Constructor
     */
    public function __construct()
    {

        global $pagenow;


        $taxonomy = isset($_GET['taxonomy']) ? $_GET['taxonomy'] : '';
        $taxonomy = apply_filters('zfwcs_allow_taxonomy_icon', $taxonomy);
        // Add form
        if ($taxonomy == 'category' || $taxonomy == 'product_cat' || $taxonomy == 'download_category') {

            add_action("create_term", array($this, 'create_term'), 10, 3);
            add_action("delete_term", array($this, 'delete_term'), 10);

            add_action($taxonomy . '_add_form_fields', array($this, 'add_category_fields'), 11);
            add_action($taxonomy . '_edit_form_fields', array($this, 'edit_category_fields'), 10, 2);

        }


        add_action('created_term', array($this, 'save_category_fields'), 10, 3);
        add_action('edit_term', array($this, 'save_category_fields'), 10, 3);
    }

    /**
     * Delete term meta data.
     *
     * Fires when a user deletes a term.
     *
     * @param integer $term_id Term ID.
     * @param integer $tt_id   Taxonomy Term ID.
     */

    public function delete_term($term_id, $tt_id)
    {

        $term_id = (int)$term_id;

        if (!$term_id)
            return;

        $term_meta = get_option('zfwcs_cats_icons', array());

        unset($term_meta['cat_icon' . $term_id]);

        update_option('zfwcs_cats_icons', (array)$term_meta);

    }

    /**
     * Category  fields.
     *
     * @access public
     * @return void
     */
    public function add_category_fields()
    {

        add_thickbox();
        ?>

        <h3><?php esc_html_e('ZF WordPress Category Search', 'wcs'); ?></h3>
        <tr class="form-field ">
            <th scope="row"><label
                    for="cat_icon"><?php esc_html_e('Category icon', 'wcs'); ?></label></th>
            <td>
                <input name="cat_icon" id="cat_icon" type="text" value="" size="40" class="cat_icon"/>
                <input type="button" value="<?php esc_html_e('Insert Icon', 'wcs'); ?>"
                       class="button" id="zfwcs_insert_icon"/>

                <p><?php esc_html_e("Select a font icon from awesome font .", 'wcs'); ?></p>
            </td>
        </tr>


        <script type="text/javascript">
            (function ($) {
                "use strict";
                $('#zfwcs_insert_icon').on('click', function (event) {
                    event.preventDefault();
                    tb_show('<?php esc_html_e("Insert Icon.", 'wcs'); ?>', 'admin.php?zfwcs_insert_icon=1&element_id=cat_icon');
                });
            })(jQuery);
        </script>

    <?php
    }

    /**
     * Edit category  field.
     *
     * @access public
     * @param mixed $term     Term (category) being edited
     * @param mixed $taxonomy Taxonomy of the term being edited
     */
    public function edit_category_fields($term, $taxonomy)
    {

        add_thickbox();

        $term_meta                              = get_option('zfwcs_cats_icons', array());
        $term_meta['cat_icon' . $term->term_id] = isset($term_meta['cat_icon' . $term->term_id]) ? $term_meta['cat_icon' . $term->term_id] : '';

        ?>

        <tr class="form-field ">
            <th scope="row"><label
                    for="cat_icon"><?php esc_html_e('Category icon', 'wcs'); ?></label></th>
            <td>
                <input name="cat_icon" id="cat_icon<?php echo esc_attr($term->term_id); ?>" type="text"
                       value="<?php echo esc_attr($term_meta['cat_icon' . esc_attr($term->term_id)]); ?>" size="40" class="cat_icon"/>
                <input type="button" value="<?php esc_html_e('Insert Icon', 'wcs'); ?>"
                       class="button" id="zfwcs_insert_icon"/>

                <p><?php esc_html_e('Select a font icon from awesome font .', 'wcs'); ?></p>
            </td>
        </tr>


        <script type="text/javascript">

            (function ($) {
                "use strict";
                 $('#zfwcs_insert_icon').on('click', function (event) {
                    event.preventDefault();
                    tb_show('<?php esc_html_e("Insert Icon", 'wcs'); ?>', 'admin.php?zfwcs_insert_icon=1&element_id=cat_icon<?php echo intval($term->term_id);?>');
                 });
            })(jQuery);

        </script>
    <?php
    }

    /**
     * save_category_fields function.
     *
     * @access public
     * @param mixed $term_id  Term ID being saved
     * @param mixed $tt_id
     * @param mixed $taxonomy Taxonomy of the term being saved
     * @return void
     */
    public function save_category_fields($term_id, $tt_id, $taxonomy)
    {
        $term_meta                        = get_option('zfwcs_cats_icons', array());
        $term_meta['cat_icon' . $term_id] = isset($_POST['cat_icon']) ? $_POST['cat_icon'] : '';

        update_option('zfwcs_cats_icons', $term_meta);

    }

}

new ZFWCS_Wordpress_Category_Search_Admin_Taxonomy();

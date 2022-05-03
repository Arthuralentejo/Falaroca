<?php
/**
 * @version    $Version$
 * @package    ZF WordPress Category Search
 * @author     ZuFusion Team
 * @copyright  Copyright (C) 2021 ZuFusion. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

if (!class_exists('ZFWCS_Wordpress_Category_Search')) {

    /**
     * Class ZFWCS_Wordpress_Category_Search base
     */
    class ZFWCS_Wordpress_Category_Search
    {
        private static $initiated = false;

        protected static $instance = null;

        private $footer_extra = '';

        public function run()
        {

            if (!self::$initiated) {
                $this->init();
            }

        }

        /**
         * Return an instance of this class.
         */
        public static function get_instance()
        {

            if (null == self::$instance) {
                self::$instance = new self;
            }

            return self::$instance;
        }

        /**
         * Init
         */
        public function init()
        {
            self::$initiated = true;


            // ajax
            add_action('wp_head', array($this, 'zfwcs_ajaxurl'));
            add_action('wp_ajax_nopriv_get_child_category_url', array($this, 'get_child_category_url'));
            add_action('wp_ajax_get_child_category_url', array($this, 'get_child_category_url'));
            add_action('wp_ajax_nopriv_auto_suggest', array($this, 'auto_suggest'));
            add_action('wp_ajax_auto_suggest', array($this, 'auto_suggest'));
            add_action('wp_ajax_get_custom_post_type_layout', array($this, 'get_custom_post_type_layout'));


            if (is_admin()) {
                add_action('admin_init', array(&$this, 'admin_init'));
                add_action('admin_menu', array(&$this, 'zfwcs_admin_menu'));

                require('admin/taxonomy.php');
            }

            add_action('plugins_loaded', array(&$this, 'load_textdomain'));

            // frontend
            add_action('wp_enqueue_scripts', array(&$this, 'site_assets'), 30);
            // backend
            add_action('admin_enqueue_scripts', array($this, 'admin_assets'));

            add_action('wp_footer', array($this, 'print_footer_extra'), 30);

            // build query
            if (!is_admin()) {
                add_action( 'pre_get_posts', array($this, 'build_query_post'), 100, 1);
            }
            // register widgets
            add_action('widgets_init', array($this, 'register_widgets'));

            // include shortcode
            require('shortcode.php');

        }

        /**
         * Load Localisation files.
         */
        public function load_textdomain()
        {

            $domain = 'zf-wrodpress-category-search';
            $locale = apply_filters('plugin_locale', get_locale(), $domain);

            if ($loaded = load_textdomain($domain, trailingslashit(WP_LANG_DIR) . $domain . '/' . $domain . '-' . $locale . '.mo')) {
                return $loaded;
            } else {
                load_plugin_textdomain('zf-wrodpress-category-search', FALSE, basename(ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_PATH) . '/languages/');
            }

        }

        public function admin_init()
        {

            if (isset($_REQUEST['zfwcs_insert_icon'])) {
                include('icons.php');
            }
        }


        /**
         * Add extra to the footer.
         * @param $js
         */
        public function add_footer_extra($js)
        {
            $this->footer_extra .= "\n" . $js . "\n";
        }

        /**
         * Print extra to footer
         * @return bool
         */
        public function print_footer_extra()
        {

            if ($this->footer_extra) {

                echo wp_kses_normalize_entities($this->footer_extra);

                $this->footer_extra = '';
            }

        }

        /**
         * load assets for plugins
         */
        public function site_assets()
        {
            // css
            // load awesome font
            $options = zfwcs_get_options();

            if ($options['enable_awesome_font'] == 0) {
                wp_register_style('zfwcs-font-awesome', ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_URL . 'assets/lib/font-awesome/css/font-awesome.min.css', array(), '4.2.0');
                wp_enqueue_style('zfwcs-font-awesome');
            }


            wp_register_style('zfwcs-chosen-css', ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_URL . 'assets/lib/chosen/chosen.min.css', array(), false);
            wp_enqueue_style('zfwcs-chosen-css');

            wp_register_style('zfwcs-jquery-ui-css', 'https://code.jquery.com/ui/1.10.0/themes/smoothness/jquery-ui.css', array(), false);
            wp_enqueue_style('zfwcs-jquery-ui-css');


            wp_register_style('zfwcs-global', ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_URL . 'assets/css/global.css', array(), false, 'all');
            wp_enqueue_style('zfwcs-global');

            $skin = $options['skin'];
            wp_register_style('zfwcs-skin-' . $skin . '', ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_URL . 'assets/css/skins/' . $skin . '.css', array(), false, 'all');
            wp_enqueue_style('zfwcs-skin-' . $skin . '');

            // js
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-datepicker');
            wp_enqueue_script('jquery-ui-slider');

            if ($options['enable_autosuggest'] == 1) {
                wp_register_script('zfwcs-typehead-js', ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_URL . 'assets/lib/typeahead.bundle.min.js', array(), '0.10.5', true);
                wp_enqueue_script('zfwcs-typehead-js');
            }

            wp_register_script('zfwcs-chosen-js', ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_URL . 'assets/lib/chosen/chosen.jquery.min.js', array(), '1.2.0', true);
            wp_enqueue_script('zfwcs-chosen-js');

            wp_register_script('zfwcs-multiple', ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_URL . 'assets/lib/multiselect/jquery.multiple.select.min.js', array(), '1.0', true);
            wp_enqueue_script('zfwcs-multiple');

            wp_register_script('zfwcs-category', ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_URL . 'assets/js/category-search.min.js', array(), '1.1', true);
            wp_enqueue_script('zfwcs-category');

        }

        /**
         * Enqueue Assets
         */
        public function admin_assets()
        {

            wp_register_style('zfwcs-font-awesome', ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_URL . 'assets/lib/font-awesome/css/font-awesome.min.css', array(), '4.2.0');
            wp_enqueue_style('zfwcs-font-awesome');

            wp_register_style('zfwcs-admin-css', ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_URL . 'assets/css/admin.css', array(), false, 'all');
            wp_enqueue_style('zfwcs-admin-css');

            wp_register_style('zfwcs-modal-font', ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_URL . 'assets/css/font-modal.css', array(), false, 'all');
            wp_enqueue_style('zfwcs-modal-font');

            // js
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-sortable');

            add_thickbox();

            wp_register_script('zfwcs-admin-js', ZFWCS_WORDPRESS_CATEGORY_SEARCH_PLUGIN_URL . 'assets/js/admin.js', array(), '1.0', true);
            wp_enqueue_script('zfwcs-admin-js');

        }


        /**
         * Admin menu page
         */
        public function zfwcs_admin_menu()
        {
            add_options_page(esc_html__('ZF WordPress Category Search', 'wcs'), '<img class="menu_icon" src="" alt="" />' . esc_html__('ZF WordPress Category Search', 'wcs') . '', 'manage_options', 'zfwcs-settings', array($this, 'zfwcs_admin_options'));
            register_setting('zfwcs_settings_fields', 'zfwcs_settings_options');
        }

        /**
         * Function callback for admin page
         */
        public function zfwcs_admin_options()
        {
            include('admin/options.php');
        }

        /**
         * Search by date
         * @param $query
         * @return mixed
         */
        public function build_query_post($query)
        {
            $options = zfwcs_get_options();
            $custom_post_type = $options['custom_post_type'];

            if(  $query->is_main_query() && ( is_post_type_archive( $custom_post_type ) || ($custom_post_type == 'post') )) {

                // filter by date
                if (isset($_GET['date_from']) || isset($_GET['date_to'])) {

                    $from       = $_GET['date_from'];
                    $to         = $_GET['date_to'];
                    $date_query = $this->build_date_range($from, $to);

                    if (!empty($date_query)) {
                        $query->set('date_query', array_merge($date_query, array(
                            'inclusive' => true,
                        )));
                    }


                }

                // filter by price
                if (isset($_GET['min_price']) || isset($_GET['max_price'])) {

                    $min 	= floatval( $_GET['min_price'] );
                    $max 	= floatval( $_GET['max_price'] );
                    $post__in   = array_unique( $this->price_filter($min, $max) );
                    if ($post__in) {
                        $query->set( 'post__in', $post__in );
                    }

                    // for woocommerce
                    if (function_exists('WC')) {
                        // query object of WooCommerce
                        $wc_query = WC()->query;
                        if (defined('DOING_AJAX') && DOING_AJAX) {

                            // Set a special variable
                            $query->set( 'wc_query', true );
                            // Store variables
                            $wc_query->post__in   = $post__in;
                        } else {

                            if (!is_active_widget(false, false, 'woocommerce_price_filter', true)) {
                                add_filter('loop_shop_post_in', array($wc_query, 'price_filter'), 100);
                            }

                        }
                    }

                }


                // allows the 3rd party hook to build query post
                do_action( 'zfwcs_build_query_post', $query, $this );

            }

        }

        /**
         * Price Filter post filter
         * @return array
         */

        public function price_filter($min, $max) {

            global $wpdb;
            $price_posts = array();
            $post_type = $_GET['post_type'];

            if ($post_type != '') {

                // for woocommerce
                if ($post_type == 'product') {

                    $matched_products = array();
                    $matched_products_query = $wpdb->get_results( $wpdb->prepare("
            SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta ON ID = post_id
            WHERE post_type IN ( 'product', 'product_variation' ) AND post_status = 'publish' AND meta_key = %s AND meta_value BETWEEN %d AND %d
        ", '_price', $min, $max ), OBJECT_K );

                    if ( $matched_products_query ) {
                        foreach ( $matched_products_query as $product ) {
                            if ( $product->post_type == 'product' )
                                $matched_products[] = $product->ID;
                            if ( $product->post_parent > 0 && ! in_array( $product->post_parent, $matched_products ) )
                                $matched_products[] = $product->post_parent;
                        }
                    }

                    // Filter the id's
                    if ( sizeof( $price_posts ) == 0) {
                        $price_posts = $matched_products;
                        $price_posts[] = 0;
                    } else {
                        $price_posts = array_intersect( $price_posts, $matched_products );
                        $price_posts[] = 0;
                    }
                } else if ($post_type == 'download') {

                    // Easy digital download
                    $matched_products_query = $wpdb->get_results( $wpdb->prepare("
            SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta ON ID = post_id
            WHERE post_type = 'download' AND post_status = 'publish' AND (meta_key = %s OR meta_key = %s)
        ", 'edd_price', '_variable_pricing'  ), OBJECT_K );

                    $prices_filter = array();
                    if ( $matched_products_query ) {
                        foreach ( $matched_products_query as $product_id => $product ) {

                            if (edd_has_variable_prices($product_id)) {

                                $price_lowest  = edd_get_lowest_price_option($product_id);
                                $price_highest = edd_get_highest_price_option($product_id);

                                if (($price_lowest >= $min) && ($price_lowest <= $max) || ($price_highest >= $min) && ($price_highest <= $max)) {
                                    $prices_filter[] = $product_id;
                                }

                            } else {
                                $prices_regular = edd_get_download_price($product_id);
                                if (($prices_regular >= $min) && ($prices_regular <= $max)) {
                                    $prices_filter[] = $product_id;
                                }
                            }
                        }

                        $price_posts = $prices_filter;

                    }

                }

            }

            $price_posts = array_unique( apply_filters( 'zfwcs_price_post_in', $price_posts, $post_type, $min, $max ));
            // Get a list of post id's which match the current filters
            return (array) $price_posts ;
        }

        /**
         * Build date query filter
         * @param $from
         * @param $to
         * @return array
         */
        public function build_date_range($from, $to)
        {

            $date_query = array();

            if ($from != '' && $to != '') {
                $from_time  = strtotime($from);
                $to_time    = strtotime($to);
                $date_query = array(
                    'after'  => array(
                        'year'  => date('Y', $from_time),
                        'month' => date('m', $from_time),
                        'day'   => date('d', $from_time),
                    ),
                    'before' => array(
                        'year'  => date('Y', $to_time),
                        'month' => date('m', $to_time),
                        'day'   => date('d', $to_time),
                    ),
                );
            } elseif ($from != '') {

                $from_time  = strtotime($from);
                $date_query = array(
                    'after' => array(
                        'year'  => date('Y', $from_time),
                        'month' => date('m', $from_time),
                        'day'   => date('d', $from_time),
                    )
                );
            } elseif ($to != '') {
                $to_time    = strtotime($from);
                $date_query = array(
                    'before' => array(
                        'year'  => date('Y', $to_time),
                        'month' => date('m', $to_time),
                        'day'   => date('d', $to_time),
                    ),
                );

            }

            return $date_query;
        }

        public function zfwcs_ajaxurl()
        {
            ?>
            <script type="text/javascript">
                var zfwcs_ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            </script>
        <?php
        }

        /**
         * Ajax get child of parent category
         */
        public function get_child_category_url()
        {
            $options = zfwcs_get_options();

            if (!empty($_POST['id'])) {

                $transName = 'child_categories_of_parent_' . (int)$_POST['id'];

                if ($options['enable_category_cache'] == 1) {

                    $cacheTime = (int)$options['cache_time']; // Time in minutes between updates.

                    if (false === ($html = get_transient($transName))) {

                        $html = zfwcs_render_options( 'li_checkbox', 'slug', array(
                            'taxonomy' =>  $_POST['cat_type'],
                            'child_of' => (int)$_POST['id'],
                            'hide_empty'   => false ,
                        ), 'ul' );

                        set_transient($transName, $html, 60 * $cacheTime);
                    }
                    exit($html);

                } else {

                    delete_transient( $transName );

                    $html = zfwcs_render_options( 'li_checkbox', 'slug', array(
                        'taxonomy' =>  $_POST['cat_type'],
                        'child_of' => (int)$_POST['id'],
                        'hide_empty'   => false ,
                    ), 'ul' );

                    exit($html);
                }
            }

        }

        /**
         * Ajax get child of parent category
         */
        public function auto_suggest()
        {
            add_action( 'pre_get_posts', array($this, 'build_query_post'));
            $options = zfwcs_get_options();

            $args = array(
                'numberposts' => (int)$options['limit_suggest'],
                'suppress_filters' => false
            );

            $args = wp_parse_args($_GET, $args);

            $posts = get_posts($args);

            // Initialise suggestions array
             $suggestions = array();

            foreach ($posts as $post): setup_postdata($post);
                // Initialise suggestion array
                $suggestion          = array();
                $suggestion['title'] = esc_html($post->post_title);
                $suggestion['link']  = get_permalink($post->ID);

                // Add suggestion to suggestions array
                $suggestions[] = $suggestion;
            endforeach;

            echo json_encode($suggestions);
            die;
        }

        function  get_custom_post_type_layout() {

            if(isset($_POST['custom_post_type']) && is_admin()) {

                $options = zfwcs_get_options();
                $custom_post_type_data_origin = array();
                $custom_post_type_data = array();
                $custom_post_type = $_POST['custom_post_type'];
                // default data if custom post type doesn't exist
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

                include 'admin/options-custom-post-type.php';

            }

            exit();
        }

        /**
         * register widgets function.
         *
         * @access public
         * @return void
         */
        function register_widgets()
        {
            global $zfwcs_object;
            $zfwcs_object = self::get_instance();

            include_once('widget.php');

            register_widget('ZFWCS_Wordpress_Category_Search_Widget');
        }

    }
}
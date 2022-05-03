<?php

// includes
include('admin/maps.php');
include('admin/pins.php');
include('admin/theme.php');
include('admin/metabox.php');
include('template/ajax.php');

add_action( 'after_setup_theme', 'mapasdevista_setup' );
if ( ! function_exists( 'mapasdevista_setup' ) ):

    function mapasdevista_setup() {

        // Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
        add_theme_support( 'post-formats', array( 'gallery', 'image', 'video' /*, 'audio' */ ) );

        // This theme uses post thumbnailsK
        add_theme_support( 'post-thumbnails' );

        // Make theme available for translation
        // Translations can be filed in the /languages/ directory
        load_theme_textdomain( 'mapasdevista', TEMPLATEPATH . '/languages' );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'mapasdevista_top' => __( 'Map Menu (top)', 'mapasdevista' ),
            'mapasdevista_side' => __( 'Map Menu (side)', 'mapasdevista' )
        ) );
        
        add_image_size('mapasdevista-thumbnail',270,203,true);

    }

endif;

add_action( 'admin_menu', 'mapasdevista_admin_menu' );

function mapasdevista_admin_menu() {

    add_submenu_page('mapasdevista_maps', __('Maps', 'mapasdevista'), __('Maps', 'mapasdevista'), 'manage_maps', 'mapasdevista_maps', 'mapasdevista_maps_page');
    add_menu_page(__('Maps of view', 'mapasdevista'), __('Maps of view', 'mapasdevista'), 'manage_maps', 'mapasdevista_maps', 'mapasdevista_maps_page',null,30);
    add_submenu_page('mapasdevista_maps', __('Pins', 'mapasdevista'), __('Pins', 'mapasdevista'), 'manage_maps', 'mapasdevista_pins_page', 'mapasdevista_pins_page');
    add_submenu_page('mapasdevista_maps', __('Settings', 'mapasdevista'), __('Settings', 'mapasdevista'), 'manage_maps', 'mapasdevista_theme_page', 'mapasdevista_theme_page');

}

add_action( 'init', 'mapasdevista_init' );

function mapasdevista_init() {
    global $pagenow;

    if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
        mapasdevista_activate();
    }
}

function mapasdevista_activate() {
    $adm = get_role('administrator');
    $adm->add_cap( 'manage_maps' );
    $adm->add_cap( 'post_item_on_map' );
}


add_action( 'admin_init', 'mapasdevista_admin_init' );

function mapasdevista_admin_init() {
    global $pagenow;
    
    
    
    if($pagenow === "post.php" || $pagenow === "post-new.php" || (isset($_GET['page']) && $_GET['page'] === "mapasdevista_maps")) {
        
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-resizable');
        wp_enqueue_script('jquery-ui-dialog');
        
        // api do google maps versao 3 direto 
        $googleapikey = get_theme_option('google_key');
        $googleapikey = $googleapikey ? "&key=$googleapikey" : '';
        wp_enqueue_script('google-maps-v3', 'http://maps.google.com/maps/api/js?sensor=true' . $googleapikey);

        wp_enqueue_script('openlayers', 'http://openlayers.org/api/OpenLayers.js');

        wp_enqueue_script('mapstraction', mapasdevista_get_baseurl() . '/js/mxn/mxn-min.js' );
        wp_enqueue_script('mapstraction-core', mapasdevista_get_baseurl() . '/js/mxn/mxn.core-min.js');
        wp_enqueue_script('mapstraction-googlev3', mapasdevista_get_baseurl() . '/js/mxn/mxn.googlev3.core-min.js');
        wp_enqueue_script('mapstraction-openlayers', mapasdevista_get_baseurl() . '/js/mxn/mxn.openlayers.core-min.js');
    }
    
    if (isset($_GET['page']) && $_GET['page'] === "mapasdevista_theme_page") {
        
        wp_enqueue_script('jcolorpicker', mapasdevista_get_baseurl() . '/admin/colorpicker/js/colorpicker.js', array('jquery') );
        wp_enqueue_style('colorpicker', mapasdevista_get_baseurl() . '/admin/colorpicker/css/colorpicker.css' );
        wp_enqueue_script('mapasdevista_theme_options', mapasdevista_get_baseurl() . '/admin/mapasdevista_theme_options.js', array('jquery', 'jcolorpicker') );
    
    }

    if($pagenow === "post.php" || $pagenow === "post-new.php") {
        wp_enqueue_script('metabox', mapasdevista_get_baseurl() . '/admin/metabox.js' );
    } elseif(isset($_GET['page']) && $_GET['page'] === 'mapasdevista_pins_page') {
        wp_enqueue_script('metabox', mapasdevista_get_baseurl() . '/admin/pins.js' );
    }


    wp_enqueue_style('mapasdevista-admin', mapasdevista_get_baseurl('template_directory') . '/admin/admin.css');
}

/* Page Template redirect */
add_action('template_redirect', 'mapasdevista_page_template_redirect');

function mapasdevista_page_template_redirect() {

    if (is_page()) {
        $page = get_queried_object();
        if (get_post_meta($page->ID, '_mapasdevista', true)) {
            mapasdevista_get_template('template/main-template');
            exit;
        }
    }
}

/**************************/


function mapasdevista_get_template($file, $context = null, $load = true) {
    
    $templates = array();
	if ( !is_null($context) )
		$templates[] = "{$file}-{$context}.php";

	$templates[] = "{$file}.php";
    
    if (preg_match('|/wp-content/themes/|', __FILE__)) {
        $found = locate_template($templates, $load, false);
    } else {
        $f = is_null($context) || empty($context) || strlen($context) == 0 ? $file : $file . '-'. $context ;
        $file = $file . '.php';
        $f = $f . '.php';
        
        if (
            file_exists(TEMPLATEPATH . '/' . $f) ||
            file_exists(STYLESHEETPATH . '/' . $f) ||
            file_exists(TEMPLATEPATH . '/' . $file) ||
            file_exists(STYLESHEETPATH . '/' . $file) 
            ) {
            $found = locate_template($templates, $load, false);
        } else {
            $f = WP_CONTENT_DIR . '/plugins/' . plugin_basename( dirname(__FILE__)) . '/' . $f;
            if ($load)
                include $f;
            else
                $found = $f;
        }
            
    }
    
    return $found;
    
}

function mapasdevista_get_baseurl() {
    
    if (preg_match('|[\\\/]wp-content[\\\/]themes[\\\/]|', __FILE__))
        return get_bloginfo('template_directory') . '/';
    else
        return plugins_url('mapasdevista') . '/';
}

function mapasdevista_get_maps() {

    global $wpdb;
    $maps = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = '_mapasdevista'");
    $r = array();
    foreach ($maps as $m) {

        if (!is_serialized($m->meta_value))
            continue;

        $mapinfo = unserialize($m->meta_value);
        $mapinfo['page_id'] = $m->post_id;
        $r[$m->post_id] = $mapinfo;

    }

    return $r;
}

// COMMENTS

if (!function_exists('mapasdevista_comment')): 

function mapasdevista_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;  
    ?>
    <li <?php comment_class("clearfix"); ?> id="comment-<?php comment_ID(); ?>">        

        <p class="comment-meta alignright bottom">
          <?php comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth'])) ?> <?php edit_comment_link( __('Edit', 'mapasdevista'), '| ', ''); ?>          
        </p>
        <div class="comment-entry clearfix">
            <div class="alignleft"><?php echo get_avatar($comment, 66); ?></div>
            <p class="comment-meta bottom">
              <?php printf( __('By <strong>%s</strong> on <strong>%s</strong> at <strong>%s</strong>.', 'mapasdevista'), get_comment_author_link(), get_comment_date(), get_comment_time()); ?>
              <?php if($comment->comment_approved == '0') : ?><br/><em><?php _e('Your comment is awaiting moderation.', 'mapasdevista'); ?></em><?php endif; ?>
            </p>
            <?php comment_text(); ?>
        </div>

    </li>
    <?php
}

endif; 


// IMAGES
function mapasdevista_get_image($name) {
    return mapasdevista_get_baseurl() . '/img/' . $name;
}

function mapasdevista_image($name, $params = null) {
    $extra = '';

    if(is_array($params)) {
        foreach($params as $param=>$value){
            $extra.= " $param=\"$value\" ";		
        }
    }

    echo '<img src="', mapasdevista_get_image($name), '" ', $extra ,' />';
}

function mapasdevista_create_homepage_map($args) {

    /*
    if (get_option('mapasdevista_created_homepage'))
        return __('You have done this before...', 'mapasdevista');
    */
    
    $params = wp_parse_args(
        $args,
        array(
            'name' => __('Home Page Map', 'mapasdevista'),
            'api' => 'openlayers',
            'type' => 'road',
            'coord' => array(
                'lat' => '-13.888513111069498',
                'lng' => '-56.42951505224626'
            ),
            'zoom' => '4',
            'post_types' => array('post'),
            'filters' => array('new'),
            'taxonomies' => array('category')
        )
    );
    
    $page = array(
        'post_title' => 'Home Page',
        'post_content' => __('Page automatically created by Mapas de Vista as a placeholder for your map.', 'mapasdevista'),
        'post_status' => 'publish',
        'post_type' => 'page'
    );
    
    $page_id = wp_insert_post($page);
    
    if ($page_id) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $page_id);
        update_option('page_for_posts', 0);
        
        update_post_meta($page_id, '_mapasdevista', $params);
        
        update_option('mapasdevista_created_homepage', true);
        
        return true;
        
    } else {
        return $page_id;
    }    
    
    
    

}


add_action('comment_post_redirect', 'mapasdevista_handle_comments_ajax', 10, 2);

function mapasdevista_handle_comments_ajax($location, $comment) {
    
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        
        die(mapasdevista_get_post_ajax($comment->comment_post_ID));
        
    } else {
        
        return $location;
        
    }

}

/**
 * 
 * @global WP_Query $MAPASDEVISTA_POSTS_RCACHE
 * @param int $page_id
 * @param array $mapinfo
 * @param array $postsArgs
 * @return WP_Query 
 */
function mapasdevista_get_posts($page_id, $mapinfo, $postsArgs = array()){
    global $MAPASDEVISTA_POSTS_RCACHE;
    
    if(is_object($MAPASDEVISTA_POSTS_RCACHE) && get_class($MAPASDEVISTA_POSTS_RCACHE) === 'WP_Query'){
        
        $MAPASDEVISTA_POSTS_RCACHE->rewind_posts();
        return $MAPASDEVISTA_POSTS_RCACHE;
    }else{
        
        if ($mapinfo['api'] == 'image') {
            
            $postsArgs += array(
                    'posts_per_page'     => -1,
                    'orderby'         => 'post_date',
                    'order'           => 'DESC',
                    'meta_key'        => '_mpv_in_img_map',
                    'meta_value'      => $page_id,
                    'post_type'       => $mapinfo['post_types'],
                    'ignore_sticky_posts' => true
                );


        } else {

            $postsArgs += array(
                        'posts_per_page'     => -1,
                        'orderby'         => 'post_date',
                        'order'           => 'DESC',
                        'meta_key'        => '_mpv_inmap',
                        'meta_value'      => $page_id,
                        'post_type'       => $mapinfo['post_types'],
                        'ignore_sticky_posts' => true
                    );
        }

        if (isset($_GET['mapasdevista_search']) && $_GET['mapasdevista_search'] != '')
            $postsArgs['s'] = $_GET['mapasdevista_search'];
        
        $MAPASDEVISTA_POSTS_RCACHE = new WP_Query($postsArgs); 
        
        return $MAPASDEVISTA_POSTS_RCACHE;
    }
}

add_filter('the_content', 'mapasdevista_gallery_filter');
function mapasdevista_gallery_filter($content){
    return str_replace('[gallery]', '[gallery link="file"]', $content);
}


function title_text_input( $title ){
     return $title = 'Digite aqui o nome da iniciativa';
}
add_filter( 'enter_title_here', 'title_text_input' );

/*******************************
 Permite o colaborador upar midia
 ********************************/
 if ( current_user_can('contributor') && !current_user_can('upload_files') )
 add_action('admin_init', 'allow_contributor_uploads');
 function allow_contributor_uploads() {
 $contributor = get_role('contributor');
 $contributor->add_cap('upload_files');
 }

add_filter('admin_footer_text', 'bl_admin_footer');
function bl_admin_footer() {
  echo '<font color=#000">Obrigado por contribuir com o Mapa Cultural da Rocinha. Caso tenha dúvidas sobre o mapa, <a href="http://www.falaroca.com/fale-conosco/">fale conosco</a>.</font>';
}

function hide_help() {
    echo '<style type="text/css">
            #contextual-help-link-wrap { display: none !important; }
          </style>';
}
add_action('admin_head', 'hide_help');
function change_footer_version() {
  return '';
}
add_filter( 'update_footer', 'change_footer_version', 9999 );

function remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('updates');
	$wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

add_action( 'admin_init', 'my_remove_menu_pages' );
function my_remove_menu_pages() {
global $user_ID;
if ( current_user_can( 'contributor' ) ) {
 remove_menu_page( 'edit.php?post_type=produtos' ); // tipo de post Produtos
 remove_menu_page('link-manager.php'); // Links
 remove_menu_page('edit-comments.php'); // Comentários
 remove_menu_page('edit.php?post_type=page'); // Páginas
 remove_menu_page('plugins.php'); // Plugins
 remove_menu_page('themes.php'); // Aparência
 remove_menu_page('users.php'); // Usuários
 remove_menu_page('tools.php'); // Ferramentas
 remove_menu_page('options-general.php'); // Configurações
 remove_menu_page('wpcf7'); // Página do plugin Contact Form 7
 remove_menu_page('jetpack'); // Página do plugin JetPack
 } 
}

// Saudação customizada
function replace_howdy( $wp_admin_bar ) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $newtitle = str_replace( 'Olá', 'Bem vindx', $my_account->title );            
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle,
    ) );
}
add_filter( 'admin_bar_menu', 'replace_howdy',25 );

// example custom dashboard widget
function custom_dashboard_widget() {
	echo "<p><strong>Como posso marcar um ponto?</strong></br>No menu 'Posts' a esquerda, clique em 'Adicionar novo' e preencha as informações solicitadas.</br></p><p><b>Qual a latitude e longitude do meu ponto?</b></br>Acesse a página do Google Maps e localize. As coordenadas aparecem no rodapé da página.</br></p><p><b>Quantos pontos eu posso mapear?</b></br>Não há limite para mapear.</br></p><p><b>Quantos dias demora para o meu ponto aparecer no mapa?</b></br>O seu ponto mapeado passa por uma revisão antes de ser publicado no mapa. O prazo máximo para o seu ponto ser publicado é de 1 dia útil.</br></p>";
}
function add_custom_dashboard_widget() {
	wp_add_dashboard_widget('custom_dashboard_widget', 'Perguntas frequentes', 'custom_dashboard_widget');
}
add_action('wp_dashboard_setup', 'add_custom_dashboard_widget');


function remove_screen_options(){
    return false;
}
add_filter('screen_options_show_screen', 'remove_screen_options');

/*******************************
Widget personalizado
********************************/
add_action('wp_dashboard_setup', 'custom_dashboard_widgets');
function custom_dashboard_widgets(){
//o primeiro paramentro e a ID da widget (que determina o div da widget)
//o segundo parametro e o titulo exibido na widget
//o terceiro parametro e o nome da funcao que busca o conteudo
wp_add_dashboard_widget('my_custom_widget_id', 'Digite aqui o título da widget', 'my_custom_widget');
}
function my_custom_widget() {
//conteudo da widget
echo '<blockquote>
Teste de caixa
</blockquote>';
}
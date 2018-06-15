<?php
/* ----------------------------------------------------------------------------------- */
# adds the plugin initalization scripts that add styles and functions
/* ----------------------------------------------------------------------------------- */
if(!current_theme_supports('deactivate_layerslider')) require_once( "config-layerslider/config.php" );//layerslider plugin

######## BLOCK CODE NAY LUON O TREN VA KHONG DUOC XOA ##########################
include 'includes/config.php';
include 'libs/HttpFoundation/Request.php';
include 'libs/HttpFoundation/Response.php';
//include 'libs/HttpFoundation/Session.php';
include 'libs/custom.php';
include 'libs/theme_functions.php';
include 'libs/theme_settings.php';
include 'libs/template-tags.php';
######## END: BLOCK CODE NAY LUON O TREN VA KHONG DUOC XOA ##########################
include 'includes/widgets/ads.php';
include 'includes/widgets/category-posts-list.php';
include 'includes/product.php';
include 'includes/addquicktag_cpt.php';
include 'includes/shortcodes.php';

if (is_admin()) {
    $basename_excludes = array('plugins.php', 'plugin-install.php', 'plugin-editor.php', 'themes.php', 'theme-install.php', 'theme-editor.php', 
        'tools.php', 'import.php', 'export.php');
    if (in_array(basename($_SERVER['PHP_SELF']), $basename_excludes)) {
//        wp_redirect(admin_url());
    }
    include 'includes/plugins-required.php';

    // Add filter
    add_filter('acf/settings/show_admin', '__return_false');
    add_filter('acf/settings/show_updates', '__return_false');
    
    // Add action
    add_action('admin_menu', 'custom_remove_menu_pages');
    add_action('admin_menu', 'remove_menu_editor', 102);
}

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' => 'Gallery Settings',
        'menu_title' => 'Gallery Settings',
        'menu_slug' => 'theme-gallery-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

/**
 * Remove admin menu
 */
function custom_remove_menu_pages() {
    remove_menu_page('edit-comments.php');
//    remove_menu_page('plugins.php');
//    remove_menu_page('tools.php');
    remove_menu_page('vc-general');
    remove_menu_page('wpseo_dashboard');
}

function remove_menu_editor() {
    remove_submenu_page('themes.php', 'themes.php');
    remove_submenu_page('themes.php', 'theme-editor.php');
    remove_submenu_page('plugins.php', 'plugin-editor.php');
    remove_submenu_page('options-general.php', 'options-writing.php');
    remove_submenu_page('options-general.php', 'options-discussion.php');
    remove_submenu_page('options-general.php', 'options-media.php');
}

/* ----------------------------------------------------------------------------------- */
# Setup Theme
/* ----------------------------------------------------------------------------------- */
if (!function_exists("ppo_theme_setup")) {

    function ppo_theme_setup() {
//        global $sitepress;
        
        /*
	 * Make theme available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Fourteen, use a find and
	 * replace to change 'twentyfourteen' to the name of your theme in all
	 * template files.
	 */
//	load_theme_textdomain( SHORT_NAME, get_template_directory() . '/languages' );
        
        ## Enable Links Manager (WP 3.5 or higher)
        //add_filter('pre_option_link_manager_enabled', '__return_true');
        
        // This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 
            'assets/css/editor-style.css',
            'assets/css/addquicktag.min.css',
            'assets/css/wp-default.min.css',
            'assets/genericons/genericons.css', 
            'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css',
        ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
        
        /*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * This theme supports all available post formats by default.
	 * See https://codex.wordpress.org/Post_Formats
	 */
//	add_theme_support( 'post-formats', array(
//            'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
//	) );

        ## Post Thumbnails
        if (function_exists('add_theme_support')) {
            add_theme_support('post-thumbnails');
        }
        if (function_exists('add_image_size')) {
//            add_image_size('450x267', 450, 267, true); // Post thumbnail
            add_image_size('300x170', 300, 170, true); // Product thumbnail
            add_image_size('400x278', 400, 278, true); // Gallery thumbnail
        }
        
        ## Declare WooCommerce support
//        add_theme_support( 'woocommerce' );
//        add_theme_support( 'wc-product-gallery-zoom' );
//        add_theme_support( 'wc-product-gallery-lightbox' );
//        add_theme_support( 'wc-product-gallery-slider' );

        ## Register menu location
        register_nav_menus(array(
            'primary' => 'Primary Location',
        ));
        
        // Front-end remove admin bar
        if (!current_user_can('administrator') && !current_user_can('editor') && !is_admin()) {
            show_admin_bar(false);
        }

        // Remove WP Generator Meta Tag
        remove_action('wp_head', 'wp_generator');
//        remove_action( 'wp_head', array( $sitepress, 'meta_generator_tag' ) );
    }

}

add_action('after_setup_theme', 'ppo_theme_setup');

/* ----------------------------------------------------------------------------------- */
# Register main Scripts and Styles
/* ----------------------------------------------------------------------------------- */
add_action('admin_enqueue_scripts', 'ppo_register_scripts');

function ppo_register_scripts(){
    wp_enqueue_media();
    
    ## Get Global Styles
    wp_enqueue_style(SHORT_NAME . '-addquicktag-template', get_template_directory_uri() . '/assets/css/addquicktag.min.css');
    wp_enqueue_style(SHORT_NAME . '-admin-visual-composer', get_template_directory_uri() . '/assets/css/admin.visual-composer.css');
    wp_enqueue_style(SHORT_NAME . '-cropbox-template', get_template_directory_uri() . '/libs/css/cropbox.css');

    ## Get Global Scripts
    wp_enqueue_script(SHORT_NAME . '-colorpicker', get_template_directory_uri() . '/libs/js/colorpicker.js', array('jquery'));
    wp_enqueue_script(SHORT_NAME . '-cropbox', get_template_directory_uri() . '/libs/js/cropbox-min.js', array('jquery'));
    wp_enqueue_script(SHORT_NAME . '-scripts', get_template_directory_uri() . '/libs/js/scripts.js', array('jquery'));
}

/**
 * Enqueue scripts and styles for the front end.
 */
function ppo_enqueue_scripts() {
    // Add Bootstrap stylesheet
    wp_enqueue_style( SHORT_NAME . '-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '3.3.6' );

    // Load our main stylesheet.
    wp_enqueue_style( SHORT_NAME . '-style', get_stylesheet_uri() );

    // Load the Internet Explorer specific stylesheet.
    wp_enqueue_style( SHORT_NAME . '-ie', get_template_directory_uri() . '/assets/css/ie.css', array( SHORT_NAME . '-style' ), THEME_VER );
    wp_style_add_data( SHORT_NAME . '-ie', 'conditional', 'lt IE 9' );

    if ( is_singular() && comments_open() ) {
        // Add Genericons font, used in the main stylesheet.
        wp_enqueue_style( SHORT_NAME . '-genericons', get_template_directory_uri() . '/assets/genericons/genericons.css', array(), '3.0.3' );

        // Add comment stylesheet
        wp_enqueue_style( SHORT_NAME . '-comment', get_template_directory_uri() . '/assets/css/comment.css', array(), THEME_VER );

        // Add comment script
        wp_enqueue_script( 'comment-reply' );
    }

    // Add script references
    wp_deregister_script( 'jquery' );
    wp_deregister_script( 'wp-embed' );
    wp_register_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery.min.js', false, '1.9.1', false );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( SHORT_NAME . '-modernizr', get_template_directory_uri() . '/assets/js/modernizr.js', array( ), THEME_VER, true );
}

add_action( 'wp_enqueue_scripts', 'ppo_enqueue_scripts' );

/* ----------------------------------------------------------------------------------- */
# Widgets init
/* ----------------------------------------------------------------------------------- */
if (!function_exists("ppo_widgets_init")) {

    // Register Sidebar
    function ppo_widgets_init() {
//        register_sidebar(array(
//            'id' => 'sidebar',
//            'name' => __('Sidebar', SHORT_NAME),
//            'before_widget' => '<section id="%1$s" class="widget %2$s">',
//            'after_widget' => '</section>',
//            'before_title' => '<h3 class="widget-title">',
//            'after_title' => '</h3>',
//        ));
        register_sidebar(array(
            'id' => 'footer1',
            'name' => __('Footer Column 1', SHORT_NAME),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'id' => 'footer2',
            'name' => __('Footer Column 2', SHORT_NAME),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'id' => 'footer3',
            'name' => __('Footer Column 3', SHORT_NAME),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'id' => 'footer4',
            'name' => __('Footer Column 4', SHORT_NAME),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
}

add_action('widgets_init', 'ppo_widgets_init');

/* ----------------------------------------------------------------------------------- */
# Custom Login / Logout
/* ----------------------------------------------------------------------------------- */
function change_username_wps_text($text) {
    if (in_array($GLOBALS['pagenow'], array('wp-login.php'))) {
        if ($text == 'Username') {
            $text = 'Username or Email';
        }
    }
    return $text;
}

add_filter('gettext', 'change_username_wps_text');

// remove the default filter
remove_filter('authenticate', 'wp_authenticate_username_password', 20, 3);

// add custom filter
add_filter('authenticate', 'ppo_authenticate_username_password', 20, 3);

function ppo_authenticate_username_password($user, $username, $password) {

    // If an email address is entered in the username box, 
    // then look up the matching username and authenticate as per normal, using that.
    if(is_email($username)){
        if (!empty($username))
            $user = get_user_by('email', $username);

        if (isset($user->user_login, $user))
            $username = $user->user_login;
    }

    // using the username found when looking up via email
    return wp_authenticate_username_password(NULL, $username, $password);
}

function redirect_after_logout() {
    wp_redirect(home_url());
    exit;
}

add_action('wp_logout','redirect_after_logout');

/* ----------------------------------------------------------------------------------- */
# Custom search
/* ----------------------------------------------------------------------------------- */
add_action('pre_get_posts', 'custom_search_filter');

function custom_search_filter($query) {
    if (!is_admin() && $query->is_main_query()) {
        if($query->is_post_type_archive){
            $query->set('posts_per_page', 12);
        } else if($query->is_tax){
            $query->set('posts_per_page', -1);
        }
        if($query->is_post_type_archive or $query->is_tax){
            $query->set('order', 'ASC');
            $query->set('orderby', 'meta_value_num');
            $query->set('meta_key', 'price');
        }
    }
    return $query;
}

## Add css, js into Admin Footer
function ppo_admin_add_custom_footer(){
?>
<style type="text/css">
    .mce-container.mce-panel.mce-floatpanel{z-index: 100101!important}
    .user-profile-picture, #profile-page #wordpress-seo, #profile-page #wordpress-seo+.form-table{display: none;visibility: hidden}
    #duplicate-post-notice, #vc_license-activation-notice{display: none;visibility: hidden}
</style>
<?php
}

add_action('admin_print_footer_scripts', 'ppo_admin_add_custom_footer', 99);

/**
 * Add admin bar items
 */
if(!is_admin()){
    add_action('admin_bar_menu', 'add_toolbar_items', 100);
} else {
    add_action('admin_bar_menu', 'admin_add_toolbar_items', 100);
}

function add_toolbar_items($admin_bar) {
    $admin_bar->remove_menu('wp-logo');
    $admin_bar->remove_menu('customize');
    $admin_bar->remove_menu('updates');
    $admin_bar->remove_menu('comments');
    $admin_bar->remove_menu('wpseo-menu');
    $admin_bar->remove_menu('ubermenu');
    $admin_bar->remove_menu('itsec_admin_bar_menu');
}
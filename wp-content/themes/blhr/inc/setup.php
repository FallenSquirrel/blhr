<?php

define('HT_CSS_VERSION','20150626.06');
define('HT_JS_VERSION','20150626.04');

require_once (TEMPLATEPATH . '/inc/lib/JSMin.php');
require_once (TEMPLATEPATH . '/inc/lib/UriRewriter.php');
require_once (TEMPLATEPATH . '/inc/lib/Compressor.php');
require_once (TEMPLATEPATH . '/inc/lib/CSSCommentPreserver.php');
require_once (TEMPLATEPATH . '/inc/lib/CSS.php');

// -- widgets
require_once (MS_WIDGETPATH . '/article.php');
require_once (MS_WIDGETPATH . '/medien.php');
require_once (MS_WIDGETPATH . '/newsletter.php');
require_once (MS_WIDGETPATH . '/termine.php');
require_once (MS_WIDGETPATH . '/teamspeak.php');
require_once (MS_WIDGETPATH . '/blhr_logo.php');

function head_js_css_scripts()
{
    if (false) {
        $cssVersion = get_option('ht_css_version');
        $cssFilename = 'main.css';
        $cssFilepath = TEMPLATEPATH . '/css/' . $cssFilename;
        $cssFileuri = get_stylesheet_directory_uri() . '/css/' . $cssFilename;

        if (!$cssVersion || $cssVersion != HT_CSS_VERSION) {

            wp_enqueue_style('my-googlefont', 'https://fonts.googleapis.com/css?family=Exo:400,500,600,700|Open+Sans:300,400,500,600,700');
            wp_enqueue_style('my-jquery-ui', get_stylesheet_directory_uri() . '/css/jquery-ui.css');
            wp_enqueue_style('my-boilerplate', get_stylesheet_directory_uri() . '/css/boilerplate.css', array('my-jquery-ui'));
            wp_enqueue_style('my-bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array('my-boilerplate'));
            wp_enqueue_style('my-font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css');
            wp_enqueue_style('my-colorbox', get_stylesheet_directory_uri() . '/css/colorbox.css');
            wp_enqueue_style('my-gallery-slider', get_stylesheet_directory_uri() . '/css/gallery-slider.css');
            wp_enqueue_style('my-pv', get_stylesheet_directory_uri() . '/css/blhr.css', array('my-bootstrap', 'my-font-awesome', 'my-colorbox', 'my-gallery-slider'));
            wp_enqueue_style('my-print', get_stylesheet_directory_uri() . '/css/print.css', array('my-pv'));

            $compressedStylesheet = ht_minify_css();

            $handle = fopen($cssFilepath, 'w');
            fwrite($handle, $compressedStylesheet);
            fclose($handle);

            update_option('ht_css_version', HT_CSS_VERSION);
        } else {
            ht_deregister_unminified_styles();
        }

        $jsVersion = get_option('ht_js_version');
        $jsFilename = 'main.js';
        $jsFilepath = TEMPLATEPATH . '/js/' . $jsFilename;
        $jsFileuri = get_stylesheet_directory_uri() . '/js/' . $jsFilename;

        if (!$jsVersion || $jsVersion != HT_JS_VERSION) {

            wp_enqueue_script('my-bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array('jquery'));
            wp_enqueue_script('my-jquery-ui', get_stylesheet_directory_uri() . '/js/jquery-ui-1.10.4.js', array('jquery'));
            wp_enqueue_script('my-modernizr', get_stylesheet_directory_uri() . '/js/modernizr-2.6.2-respond-1.1.0.min.js', array('jquery'));
            wp_enqueue_script('my-colorbox', get_stylesheet_directory_uri() . '/js/colorbox.js', array('jquery'));
            wp_enqueue_script('my-gallery-slider', get_stylesheet_directory_uri() . '/js/gallery-slider.js', array('jquery'));
            wp_enqueue_script('my-jpaginate', get_stylesheet_directory_uri() . '/js/jPaginate.js', array('jquery'));
            wp_enqueue_script('my-pv', get_stylesheet_directory_uri() . '/js/blhr.js', array('jquery', 'my-gallery-slider', 'my-colorbox', 'my-bootstrap'));
            wp_enqueue_script('my-utils', get_stylesheet_directory_uri() . '/js/Utils.js', array('jquery'));
            wp_enqueue_script('my-oas', get_stylesheet_directory_uri() . '/js/oas.js', array('jquery'));
            wp_enqueue_script('my-modernizr-2', get_stylesheet_directory_uri() . '/js/modernizr.custom.66527.js', array('jquery'));
            wp_enqueue_script('my-iam', 'https://script.ioam.de/iam.js', array('jquery'));

            $compressedScript = ht_minify_js();

            $handle = fopen($jsFilepath, 'w');
            fwrite($handle, $compressedScript);
            fclose($handle);

            update_option('ht_js_version', HT_JS_VERSION);
        } else {
            ht_deregister_unminified_scripts();
        }

        wp_enqueue_script('my-main', $jsFileuri, array(), HT_JS_VERSION);
        wp_enqueue_style('my-main', $cssFileuri, array(), HT_CSS_VERSION);
    } else {
        wp_enqueue_style('my-googlefont', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700');
        wp_enqueue_style('my-jquery-ui', get_stylesheet_directory_uri() . '/css/jquery-ui.css');
        wp_enqueue_style('my-boilerplate', get_stylesheet_directory_uri() . '/css/boilerplate.css', array('my-jquery-ui'));
        wp_enqueue_style('my-bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array('my-boilerplate'));
        wp_enqueue_style('my-font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css');
        wp_enqueue_style('my-colorbox', get_stylesheet_directory_uri() . '/css/colorbox.css');
        wp_enqueue_style('my-gallery-slider', get_stylesheet_directory_uri() . '/css/gallery-slider.css');
        wp_enqueue_style('my-pv', get_stylesheet_directory_uri() . '/css/blhr.css', array('my-bootstrap', 'my-font-awesome', 'my-colorbox', 'my-gallery-slider'));
        wp_enqueue_style('my-print', get_stylesheet_directory_uri() . '/css/print.css', array('my-pv'));
        wp_enqueue_script('my-bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array('jquery'));
        wp_enqueue_script('my-jquery-ui', get_stylesheet_directory_uri() . '/js/jquery-ui-1.10.4.js', array('jquery'));
        wp_enqueue_script('my-modernizr', get_stylesheet_directory_uri() . '/js/modernizr-2.6.2-respond-1.1.0.min.js', array('jquery'));
        wp_enqueue_script('my-colorbox', get_stylesheet_directory_uri() . '/js/colorbox.js', array('jquery'));
        wp_enqueue_script('my-gallery-slider', get_stylesheet_directory_uri() . '/js/gallery-slider.js', array('jquery'));
        wp_enqueue_script('my-jpaginate', get_stylesheet_directory_uri() . '/js/jPaginate.js', array('jquery'));
        wp_enqueue_script('my-pv', get_stylesheet_directory_uri() . '/js/pv.js', array('jquery', 'my-gallery-slider', 'my-colorbox', 'my-bootstrap'));
        wp_enqueue_script('my-utils', get_stylesheet_directory_uri() . '/js/Utils.js', array('jquery'));
        wp_enqueue_script('my-oas', get_stylesheet_directory_uri() . '/js/oas.js', array('jquery'));
        wp_enqueue_script('my-modernizr-2', get_stylesheet_directory_uri() . '/js/modernizr.custom.66527.js', array('jquery'));
        wp_enqueue_script('my-iam', 'https://script.ioam.de/iam.js', array('jquery'));
    }
}
add_action('wp_enqueue_scripts','head_js_css_scripts',100);

// -- admin
add_editor_style();

// -- theme support
add_theme_support('post-thumbnails');
add_theme_support('post-formats', array('aside', 'image', 'gallery', 'link', 'quote', 'status', 'video', 'audio', 'chat'));

// -- contenttypes / taxonomies

function register_contenttype_taxonomy ()
{
    // Neue Taxonomie - hierarchisch
    $labels = array(
        'name' => _x( 'Contentarten', 'taxonomy general name' ),
        'singular_name' => _x( 'Contentart', 'taxonomy singular name' ),
        'search_items' =>  __( 'Contentarten durchsuchen' ),
        'all_items' => __( 'Alle Contentarten' ),
        'parent_item' => __( 'Übergeordnete Contentart' ),
        'parent_item_colon' => __( 'Übergeordnete Contentart:' ),
        'edit_item' => __( 'Contentart bearbeiten' ),
        'update_item' => __( 'Contentart aktualisieren' ),
        'add_new_item' => __( 'Neue Contentart' ),
        'new_item_name' => __( 'Neue Contentart' ),
        'menu_name' => __( 'Contentarten' ),
    );

    register_taxonomy('contenttype',array('post'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'contenttyp' ),
    ));
}
add_action( 'init', 'register_contenttype_taxonomy');

// -- menus
register_nav_menus( array(
    'mainmenu' => 'Hauptmenü',
    'footer' => 'Menü unterer Seitenrand'
));

// -- imagesizes
$customImageSizes = array(
    array( 'name'=>'gallery-thumb', 'width'=>140, 'height'=>100, 'crop'=>true ),
    array( 'name'=>'gallery-large', 'width'=>619, 'height'=>385, 'crop'=>true ),
);

foreach ( $customImageSizes as $customImageSize ){
    add_image_size( $customImageSize['name'], $customImageSize['width'], $customImageSize['height'], $customImageSize['crop'] );
    update_option( $customImageSize['name']."_size_w", $customImageSize['width'] );
    update_option( $customImageSize['name']."_size_h", $customImageSize['height'] );
    update_option( $customImageSize['name']."_crop", $customImageSize['crop'] );
}

add_action( 'widgets_init', function(){
    register_widget( 'ht_Medien_Widget' );
    register_widget( 'ht_Newsletter_Widget' );
    register_widget( 'teamspeak_widget' );
    register_widget( 'blhr_logo_widget' );
});

// -- sidebars
$defaultBeforeWidget = '<aside class="frame widget-container"><div id="%1$s" class="widget %2$s">';
$defaultAfterWidget = '</div><footer class="frame-footer"></footer></aside>';
$defaultBeforeTitle = '<header class="frame-headline"><div class="frame-title"><h4 class="widget-title clearfix">';
$defaultAfterTitle = '</h4></div></header>';

register_sidebar(
    array(
        'name' => 'Homepage Sidebar Links',
        'id' => 'sidebar-left',
        'before_widget' => $defaultBeforeWidget,
        'after_widget' => $defaultAfterWidget,
        'before_title' => $defaultBeforeTitle,
        'after_title' => $defaultAfterTitle
    )
);
register_sidebar(
    array(
        'name' => 'Homepage Sidebar Rechts',
        'id' => 'sidebar-right',
        'before_widget' => $defaultBeforeWidget,
        'after_widget' => $defaultAfterWidget,
        'before_title' => $defaultBeforeTitle,
        'after_title' => $defaultAfterTitle
    )
);

add_action('after_setup_theme', 'add_language');
function add_language(){
    load_theme_textdomain('blhr-theme', get_template_directory() . '/lang');
    load_theme_textdomain('breadcrumb_navxt', get_template_directory() . '/lang/breadcrumbs');
}

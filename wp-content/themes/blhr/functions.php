<?php

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

/**
 * BIC Bootstrap Wordpress Theme Functions
 * Original from BootstrapWP
 * @author original by Rachel Baker <rachel@rachelbaker.me>, modified by Nina Taberski-Besserdich (nina.taberski@besserdich.com)
 * @package WordPress
 * @subpackage BIC Bootstrap Wordpress Theme
 */

define( 'MS_ADDONPATH', TEMPLATEPATH . '/inc/addons' );
define( 'MS_WIDGETPATH', TEMPLATEPATH . '/inc/widgets' );

require_once (TEMPLATEPATH . '/inc/pv_functions.php');
require_once (TEMPLATEPATH . '/inc/setup.php');

//require_once (MS_ADDONPATH . '/breadcrumb.php');
//require_once (MS_ADDONPATH . '/article.php');
require_once (MS_ADDONPATH . '/termine.php');
require_once (MS_ADDONPATH . '/megadropdown.php');
require_once (MS_ADDONPATH . '/menu-walker.php');


function autoexpand_rel_wlightbox ($content) {
    global $post;
    $pattern        = "/(<a(?![^>]*?rel=['\"]lightbox.*)[^>]*?href=['\"][^'\"]+?\.(?:bmp|gif|jpg|jpeg|png)['\"][^\>]*)>/i";
    $replacement    = '$1 rel="colorbox">';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}
add_filter('the_content', 'autoexpand_rel_wlightbox', 99);


/**
 * Remove integrated gallery styles in the content area of standard gallery shortcode.  
 * style in css. 
 */
add_filter('gallery_style', create_function('$a', 'return "<div class=\'gallery\'>";'));

/* prevent scrolling when using more-tag */
function remove_more_link_scroll( $link ) {        
    
    $link = preg_replace( '|#more-[0-9]+|', '', $link );        return $link;
    
} 
add_filter( 'the_content_more_link', 'remove_more_link_scroll' );


/**
 * Display page next/previous navigation links.
 *
 */
if (!function_exists('bootstrapwp_content_nav')):
    function bootstrapwp_content_nav($nav_id) {

        global $wp_query, $post;

        if ($wp_query->max_num_pages > 1) : ?>

        <nav id="<?php echo $nav_id; ?>" class="navigation" role="navigation">
            <h3 class="assistive-text"><?php _e('Post navigation', 'blhr-theme'); ?></h3>
            <div class="nav-previous alignleft"><?php next_posts_link(
                __('<span class="meta-nav">&larr;</span> Older posts', 'blhr-theme')
            ); ?></div>
            <div class="nav-next alignright"><?php previous_posts_link(
                __('Newer posts <span class="meta-nav">&rarr;</span>', 'blhr-theme')
            ); ?></div>
        </nav><!-- #<?php echo $nav_id; ?> .navigation -->

        <?php endif;
    }
endif;



/**
 * Display template for comments and pingbacks.
 *
 */
if (!function_exists('bootstrapwp_comment')) :

    function bootstrapwp_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
                ?>

                <li class="comment media" id="comment-<?php comment_ID(); ?>">
                    <div class="media-body">
                        <p>
                <?php _e('Pingback:', 'blhr-theme'); ?> <?php comment_author_link(); ?>
                        </p>
                    </div><!--/.media-body -->
                            <?php
                            break;
                        default :
                            // Proceed with normal comments.
                            global $post;
                            ?>

                <li class="comment media" id="li-comment-<?php comment_ID(); ?>">
                    <a href="<?php echo $comment->comment_author_url; ?>" class="pull-left">
                <?php echo get_avatar($comment, 64); ?>
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading comment-author vcard">
                <?php
                printf('<cite class="fn">%1$s %2$s</cite>', get_comment_author_link(),
                        // If current post author is also comment author, make it known visually.
                        ($comment->user_id === $post->post_author) ? '<span class="label"> ' . __(
                                        'Post author', 'blhr-theme'
                                ) . '</span> ' : '');
                ?>
                        </h4>

                            <?php if ('0' == $comment->comment_approved) : ?>
                            <p class="comment-awaiting-moderation"><?php
                    _e(
                            'Your comment is awaiting moderation.', 'blhr-theme'
                    );
                    ?></p>
                            <?php endif; ?>

                        <?php comment_text(); ?>
                        <p class="meta">
                        <?php
                        printf('<a href="%1$s"><time datetime="%2$s">%3$s</time></a>', esc_url(get_comment_link($comment->comment_ID)), get_comment_time('c'), sprintf(
                                        __('%1$s at %2$s', 'blhr-theme'), get_comment_date(), get_comment_time()
                                )
                        );
                        ?>
                        </p>
                        <p class="reply">
                            <?php
                            comment_reply_link(array_merge($args, array(
                                'reply_text' => __('Reply <span>&darr;</span>', 'blhr-theme'),
                                'depth' => $depth,
                                'max_depth' => $args['max_depth']
                                            )
                            ));
                            ?>
                        </p>
                    </div>
                    <!--/.media-body -->
                <?php
                break;
        endswitch;
    }

endif;


if (!function_exists('the_article_content')) :
    function the_article_content($more_link_text = null, $strip_teaser = false)
    {
        /*
        $datetime = get_the_date('c');
        $dateContent = '<time class="entry-date" datetime="$datetime">';
        $dateContent .= get_the_date();
        $dateContent .= ' | </time>';
        $content = $dateContent;
        */
        $content = get_the_content( $more_link_text, $strip_teaser );
        $content = apply_filters( 'the_content', $content );
        $content = str_replace( ']]>', ']]&gt;', $content );
        echo $content;
    }
endif;

/**
 * Display template for post meta information.
 *
 */
if (!function_exists('bootstrapwp_posted_on')) :
    function bootstrapwp_posted_on()
    {
	    $options = get_option('bicbswp_theme_options');
	
        if($options['meta_data'] == true ) {
            printf(__('<time class="entry-date" datetime="%1$s">%2$s</time>', 'blhr-theme'),
                esc_attr(get_the_date('c')),
                esc_html(get_the_date())
            );
        }
    }
endif;


/**
 * Display template for post cateories and tags
 *
 */
if (!function_exists('bicbswp_cats_tags')) :

    function bicbswp_cats_tags() {
       
            printf('<span class="cats_tags"><span class="glyphicon glyphicon-folder-open" title="My tip"></span><span class="cats">');
            printf(the_category(', '));
            printf('</span>'); 
        
        if(has_tag()==true){
            printf('<span class="glyphicon glyphicon-tags"></span><span class="tags">');
            printf(the_tags(' '));
            printf('</span>'); 
        }
        
        printf('</span>');
    }

endif;


/**
 * Adds custom classes to the array of body classes.
 *
 */
/* function bootstrapwp_body_classes($classes)
  {
  if (!is_multi_author()) {
  $classes[] = 'single-author';
  }
  return $classes;
  }
  add_filter('body_class', 'bootstrapwp_body_classes'); */

/**
 * Add post ID attribute to image attachment pages prev/next navigation.
 *
 */
function bootstrapwp_enhanced_image_navigation($url) {
    global $post;
    if (wp_attachment_is_image($post->ID)) {
        $url = $url . '#main';
    }
    return $url;
}

add_filter('attachment_link', 'bootstrapwp_enhanced_image_navigation');

/**
 * Checks if a post thumbnails is already defined.
 *
 */
function bootstrapwp_is_post_thumbnail_set() {
    global $post;
    if (get_the_post_thumbnail()) {
        return true;
    } else {
        return false;
    }
}

/**
 * Set post thumbnail as first image from post, if not already defined.
 * NT Bug fixed, wasnt set. 
 */
function bootstrapwp_autoset_featured_img() {
    global $post;

    $post_thumbnail = bootstrapwp_is_post_thumbnail_set();
    if ($post_thumbnail == true) {
        return get_the_post_thumbnail($post->ID, 'thumbnail', array('class' => 'img-responsive'));
    }
    $image_args = array(
        'post_type' => 'attachment',
        'numberposts' => 1,
        'post_mime_type' => 'image',
        'post_parent' => $post->ID,
        'order' => 'desc'
    );
    $attached_images = get_children($image_args, ARRAY_A);
    $first_image = reset($attached_images);
    if (!$first_image) {
        return false;
    }

    set_post_thumbnail($post->ID, $first_image['ID']);
    return get_the_post_thumbnail($post->ID, 'medium', array('class' => 'img-responsive'));
}

/**
 * Define default page titles.
 *
 */
function bootstrapwp_wp_title($title, $sep) {
    global $paged, $page;
    if (is_feed()) {
        return $title;
    }
    // Add the site name.
    $title .= get_bloginfo('name');
    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) {
        $title = "$title $sep $site_description";
    }
    // Add a page number if necessary.
    if ($paged >= 2 || $page >= 2) {
        $title = "$title $sep " . sprintf(__('Page %s', 'blhr-theme'), max($paged, $page));
    }
    return $title;
}

add_filter('wp_title', 'bootstrapwp_wp_title', 10, 2);

function getFirstSentence($string)
{
    // First remove unwanted spaces - not needed really
    $string = str_replace(" .",".",$string);
    $string = str_replace(" ?","?",$string);
    $string = str_replace(" !","!",$string);
    // Find periods, exclamation- or questionmarks with a word before but not after.
    // Perfect if you only need/want to return the first sentence of a paragraph.
    preg_match('/^.*[^\s]\D+(\.|\?|\!)/U', $string, $match);
    $allowedWords = array('(geb.', 'Engl.');
    if (in_array($match[0], $allowedWords)) {
        $sentenceParts = explode('.', $string);
        return $sentenceParts[0].'.'.$sentenceParts[1].'.';
    } else {
        return $match[0];
    }
}

/*-----------------------------------------------------------------------------------*/
/* Shortcodes
/*-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/* Helper for Shortcodes
/*-----------------------------------------------------------------------------------*/

// User shorcodes in sidebars
add_filter('widget_text', 'do_shortcode');

// Replace WP autop formatting
if (!function_exists( "bic_rm_wpautop")) {
     function bic_rm_wpautop($content) {
          $content = do_shortcode( shortcode_unautop( $content ) );
          $content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content);
          //$content = str_replace("</p>", "<br />", $content);
          return $content;
     }
} 




//move wpautop filter to AFTER shortcode is processed
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 99);
add_filter( 'the_content', 'shortcode_unautop',100 );

/*-----------------------------------------------------------------------------------*/
/* Shortcodes for Columns
/*-----------------------------------------------------------------------------------*/

// Two Columns
function bic_shortcode_two_columns_one($atts, $content = null ) {
   return '<div class="col-md-6">' . bic_rm_wpautop($content) . '</div>';
}
add_shortcode( 'two_columns_one', 'bic_shortcode_two_columns_one' );


// Three Columns
function bic_shortcode_three_columns_one($atts, $content = null) {
   return '<div class="col-md-4">' . bic_rm_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_one', 'bic_shortcode_three_columns_one' );


function bic_shortcode_three_columns_two($atts, $content = null) {
   return '<div class="col-md-8">' . bic_rm_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_two', 'bic_shortcode_three_columns_two' );


// Four Columns
function bic_shortcode_four_columns_one($atts, $content = null) {
   return '<div class="col-md-3">' . bic_rm_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_one', 'bic_shortcode_four_columns_one' );


function bic_shortcode_four_columns_two($atts, $content = null) {
   return '<div class="col-md-6">' . bic_rm_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_two', 'bic_shortcode_four_columns_two' );


function bic_shortcode_four_columns_three($atts, $content = null) {
   return '<div class="col-md-9">' . bic_rm_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_three', 'bic_shortcode_four_columns_three' );



/*-----------------------------------------------------------------------------------*/
/* Divide Text Shortcode 
/*-----------------------------------------------------------------------------------*/

function bic_shortcode_divider($atts, $content = null) {
   return '<div class="divider"></div>';
}
add_shortcode( 'divider', 'bic_shortcode_divider' );



/*-----------------------------------------------------------------------------------*/
/* Shortcodes for Buttons 
/*-----------------------------------------------------------------------------------*/

function bic_shortcode_button($atts, $content = null) {

    extract(shortcode_atts(array(
        'type' => 'standard',
        'link'	=> '#',
        'target' => '_self',
        'size'	=> '',
    ), $atts));

	$type = ($type) ? ' btn-'.$type  : '';
	$size = ($size) ? ' btn-'.$size  : '';
        $output = '<a class="btn ' .$type.$size. '" href="' .$link. '" target="'.$target.'"><span>' .do_shortcode($content). '</span></a>';
    return $output;

    
}
add_shortcode( 'button', 'bic_shortcode_button' );

function truncateText($text, $length=40)
{
    if (mb_strlen($text) > $length) {
        $subex = mb_substr($text, 0, $length - 5);
        $exwords = explode(' ', $subex);
        $excut = - (mb_strlen($exwords[count($exwords) - 1]));
        if ($excut < 0) {
            return mb_substr($subex, 0, $excut);
        } else {
            return $subex;
        }
    } else {
        return $text;
    }
}

if (!function_exists('the_homepage_excerpt')) :
    function the_homepage_excerpt()
    {
        $content = get_the_excerpt();
        $tags = array("</p>");
        $myExcerpt = str_replace($tags, "", $content);
        $myExcerpt .= ' <a href="'. get_permalink( get_the_ID() ) . '" class="nv-read-more"><span>' . __('more...', 'blhr-theme') . '</span></a>';
        $myExcerpt .= '</p>';
        echo $myExcerpt;
    }
endif;

function fileExists($path)
{
    return (@fopen($path,"r")==true);
}

function get_the_category_name ($postId)
{
    $categories = get_the_terms($postId, 'contenttype');
    if ($categories && (count($categories) > 0)) {
        foreach ($categories as $cat) {
            return $cat->name;
        }
    } else {
        return 'News';
    }
}

remove_all_actions( 'do_feed_rss2' );
add_action( 'do_feed_rss2', 'ht_nv_feed', 10, 1 );

function ht_nv_feed( $for_comments ) {
    global $wp_query;

    $rss_template = get_template_directory() . '/feeds/feed-rss2.php';
    if( file_exists( $rss_template ) ) {
        load_template( $rss_template );
    } else {
        do_feed_rss2( $for_comments ); // Call default function
    }
}

add_shortcode('gallery', function($atts) {
    $galleryPictures = convertGalleryShortCodeToPictures($atts);
    if(!empty($galleryPictures)) {
        return getGallerySliderHTMLCode($galleryPictures);
    }
    return '';
});

function convertGalleryShortCodeToPictures($galleryShortCodeAtts)
{
    global $wp_query;
    if(is_array($galleryShortCodeAtts) && array_key_exists('ids', $galleryShortCodeAtts)) {
        $galleryPictures = preg_split('/,/', $galleryShortCodeAtts['ids']);
        $i = 0;
        foreach($galleryPictures as &$picture) {
            $i++;
            $picture = wp_get_attachment_image_src(intval(trim($picture)), 'gallery-thumb');
            $picture['link'] = '/'.$wp_query->post->ID.'/'.$wp_query->post->post_name.'/'.$i.'/?view=galerie';
        }
        return $galleryPictures;
    }
    return array();
}

function getGallerySliderHTMLCode($galleryPictures)
{
    $html = '<div class="gallerySlider">';
    $html .= '<div class="previous"><i class="arrow fa fa-chevron-left"></i></div>';
    $html .= '<div class="next"><i class="arrow fa fa-chevron-right"></i></div>';
    $html .= '<div class="images"><div class="slider">';
    foreach ($galleryPictures as $picture):
        $pictureLink = array_key_exists('link', $picture) ? $picture['link'] : 'javascript:void(0)';
        $html .= '<div class="tile">';
        $html .= '<a class="img-magnify" href="'.$pictureLink.'"><img class="thumb" src="'.$picture[0].'" alt="Bild" /></a>';
        $html .= '</div>';
    endforeach;
    $html .= '</div><!--/.slider--></div><!--/.images-->';
    $html .= '</div><!--/.gallerySlider-->';
    return $html;
}

add_filter( 'template_include', 'pageGalleryView', 1 );

function pageGalleryView( $template )
{
    if ( isGalleryView() ) {
        $new_template = locate_template( array( 'single-bildergalerie.php' ) );
        if ( '' != $new_template ) {
            return $new_template ;
        }
    }
    return $template;
}

function isGalleryView()
{
    return array_key_exists('view', $_GET) && $_GET['view'] == 'galerie';
}

function htAdminScriptStyles() {
    wp_enqueue_style('ht-admin-css', get_stylesheet_directory_uri().'/css/admin.css', array(), '0.1');
}
add_action( 'admin_init', 'htAdminScriptStyles' );

// Start session to save if user filtered for german/english articles on index.php or category.php
function kgk_theme_startSession() {
    if(!session_id()) {
        session_start();
    }
}
add_action('init', 'kgk_theme_startSession', 1);

// Disable admin bar for subscribers
function remove_admin_bar() {
    if (is_user_logged_in()) {
        if (current_user_can('subscriber')) {
            show_admin_bar(false);
        }
    }
}
add_action('after_setup_theme', 'remove_admin_bar');

function read_last_visit_cookie() {
    global $lastVisit;

    if (isset($_SESSION['last-visit'])) {
        $lastVisit = $_SESSION['last-visit'];
    } else {
        if (isset($_COOKIE['last-visit'])) {
            $lastVisit = $_COOKIE['last-visit'];
        } else {
            $lastVisit = date('y-m-d');
        }
        $_SESSION['last-visit'] = $lastVisit;
    }
    setcookie('last-visit', date('y-m-d'), time()+60*60*24*365);
}
add_action('init', 'read_last_visit_cookie', 10);

function add_login_logout_link($items, $args)
{
    if ($args->theme_location == 'footer') {
        $loginoutlink = wp_loginout('index.php', false);
        $items .= '<li>'. $loginoutlink .'</li>';
    }

    return $items;
}
add_filter('wp_nav_menu_items', 'add_login_logout_link', 10, 2);

/**
 * @param WP_Query $query
 */
function main_page_limit_to_three($query) {
    if ($query->is_home() && $query->is_main_query()) {
        $query->set('posts_per_page', '3');
    }
}
add_action( 'pre_get_posts', 'main_page_limit_to_three' );
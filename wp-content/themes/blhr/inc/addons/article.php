<?php

/**
 * Registriert neue Contentarten
 *
 */

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

function has_titelstory($heftId)
{
    global $wpdb;
    $meta = $wpdb->get_results("SELECT * FROM `".$wpdb->postmeta."` WHERE meta_key='".$wpdb->escape('_wpcf_belongs_hefte_id')."' AND meta_value='".$wpdb->escape($heftId)."'");

    if (count($meta) > 0 && $meta[0]->post_id != '') {
        $isTitelstory = get_post_meta($meta[0]->post_id, 'wpcf-is_titelstory', true);
        return ($isTitelstory ? true : false);
    } else {
        return false;
    }
}

function the_titelstory_link($heftId)
{
    global $wpdb;
    $meta = $wpdb->get_results("SELECT * FROM `".$wpdb->postmeta."` WHERE meta_key='".$wpdb->escape('_wpcf_belongs_hefte_id')."' AND meta_value='".$wpdb->escape($heftId)."'");

    if (count($meta) > 0 && $meta[0]->post_id != '') {
        $isTitelstory = get_post_meta($meta[0]->post_id, 'wpcf-is_titelstory', true);
        if ($isTitelstory) {
            echo '<a href="'.get_post_permalink($meta[0]->post_id).'">'.get_the_title($meta[0]->post_id).'</a>';
        }
    } else {
        return false;
    }
}

function the_titelstory()
{
    $isTitelstory = get_post_meta(get_the_ID(), 'wpcf-is_titelstory', true);
    if ($isTitelstory) {
        return 'titelstory';
    }
}

function is_the_article_migrated()
{
    global $post;
    return (get_post_meta($post->ID, 'is-migrated', true) ? true : false);
}

function the_article_gallery( $echo = true )
{
    global $post;
    if ($value = get_post_meta($post->ID, 'galleryid', true)) {
        // erst mit den richtigen Bildergalerien versuchen
        $images = get_post_gallery_images($value);
        if (!$images) {
            // schauen, ob es migrierte Bildergalerien gibt
            $images = get_children( 'post_parent='.$value.'&post_type=attachment&post_mime_type=image' );
        }
        $html = "<div class='article-images clearfix'>
            <ul>";
        foreach($images as $img) {
            $html .= "<li><img src='".$img->guid."' alt='".$img->post_title."' /></li>";
        }
        $html .= "</ul>
        </div>";
        if ($echo) echo $html; else return $html;
    } else {
        return false;
    }
}
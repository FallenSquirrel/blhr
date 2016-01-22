<?php
require_once( ABSPATH . 'wp-admin/includes/image.php' );

function generate_post_thumbnail_size_if_not_exist($postId,$imageSize) {
    if($thumbnail_id = get_post_thumbnail_id($postId)) {
        generate_image_size_if_not_exist($thumbnail_id, $imageSize);
    }
}

function generate_image_size_if_not_exist($thumbnailId, $imageSize){
    $the_thumbnail_src = wp_get_attachment_image_src($thumbnailId,$imageSize);
    if(!$the_thumbnail_src || !$the_thumbnail_src[3]) {
        $image = get_post($thumbnailId);
        $fullsizepath = get_attached_file( $image->ID );
        if($fullsizepath && file_exists($fullsizepath)) {
            $metadata = wp_generate_attachment_metadata($image->ID, $fullsizepath);
            if(!is_wp_error($metadata) && !empty($metadata)) {
                wp_update_attachment_metadata($image->ID,$metadata);
            }
        }
    }
}

function minify_css() {
    global $wp_styles;
    $stylesToOrder = array();
    foreach($wp_styles->queue as $styleHandle) {
        $stylesToOrder[$styleHandle] = $wp_styles->registered[$styleHandle];
    }
    $reorderedStyles = reorder_scripts($stylesToOrder,$wp_styles->registered);

    $compressedStylesheet = '';
    foreach ($reorderedStyles as $handle => $style) {
        if($style->src) {
            $src = $style->src;
            if(strpos($src,'/') === 0 && strpos($src,'//') === false) {
                if(substr(get_site_url(),-1) == '/') {
                    $src = substr(get_site_url(),0,-1).$src;
                } else {
                    $src = get_site_url().$src;
                }
            } elseif(strpos($src,'//') === 0) {
                if(isset($_SERVER['HTTPS'])) {
                    $src = 'https:'.$src;
                } else {
                    $src = 'http:'.$src;
                }
            }
            $compressedStylesheet .= Minify_CSS::minify(file_get_contents($src)) . ' ';
        }
        wp_dequeue_style($handle);
        wp_deregister_style($handle);
    }

    return $compressedStylesheet;
}

function deregister_unminified_styles() {
    global $wp_styles;
    $stylesToOrder = array();
    foreach($wp_styles->queue as $styleHandle) {
        $stylesToOrder[$styleHandle] = $wp_styles->registered[$styleHandle];
    }
    $reorderedStyles = reorder_scripts($stylesToOrder,$wp_styles->registered);
    foreach($reorderedStyles as $handle => $reorderedStyle) {
        wp_dequeue_style($handle);
        wp_deregister_style($handle);
    }
}

function minify_js() {
    global $wp_scripts;

    $scriptsToOrder = array();
    foreach($wp_scripts->queue as $scriptHandle) {
        $scriptsToOrder[$scriptHandle] = $wp_scripts->registered[$scriptHandle];
    }
    $reorderedScripts = reorder_scripts($scriptsToOrder,$wp_scripts->registered);

    $compressedScript = '';
    foreach ($reorderedScripts as $handle => $script) {
        if($script->src) {
            $src = $script->src;
            if(strpos($src,'/') === 0 && strpos($src,'//') === false) {
                if(substr(get_site_url(),-1) == '/') {
                    $src = substr(get_site_url(),0,-1).$src;
                } else {
                    $src = get_site_url().$src;
                }
            } elseif(strpos($src,'//') === 0) {
                if(isset($_SERVER['HTTPS'])) {
                    $src = 'https:'.$src;
                } else {
                    $src = 'http:'.$src;
                }
            }
            $compressedScript .= JSMin::minify(file_get_contents($src)) . ';';
        }
        wp_dequeue_script($handle);
        wp_deregister_script($handle);
    }

    return $compressedScript;
}

function deregister_unminified_scripts() {
    global $wp_scripts;

    $scriptsToOrder = array();
    foreach($wp_scripts->queue as $scriptHandle) {
        $scriptsToOrder[$scriptHandle] = $wp_scripts->registered[$scriptHandle];
    }
    $reorderedScripts = reorder_scripts($scriptsToOrder,$wp_scripts->registered);
    foreach($reorderedScripts as $handle => $reorderedScript) {
        wp_dequeue_script($handle);
        wp_deregister_script($handle);
    }
}

function reorder_scripts($scripts,$allscripts) {
    $orderedScripts = array();

    foreach($scripts as $handle => $script) {
        $dependencyScripts = array();
        if($script->deps) {
            foreach ($script->deps as $dependency) {
                $dependencyScripts[$dependency] = $allscripts[$dependency];
            }
        }
        $orderedScripts = array_merge(reorder_scripts($dependencyScripts,$allscripts),$orderedScripts);
        $orderedScripts[$handle] = $script;
    }

    return $orderedScripts;
}

function ht_debug_theme_file_start($filename) {
    if(isset($_GET['debug_theme_mode'])) {
        $debug_theme_mode = $_GET['debug_theme_mode'];
    } else {
        if(isset($_SESSION['debug_theme_mode'])) {
            $debug_theme_mode = $_SESSION['debug_theme_mode'];
        } else {
            $debug_theme_mode = 0;
        }
    }
    $_SESSION['debug_theme_mode'] = $debug_theme_mode;
    if (($debug_theme_mode > 0) && (current_user_can('level_10'))) {
        echo '<p class="debug-theme-file-border-marker">Template file ' . $filename . ' start</p>';
    }
}

function ht_debug_theme_file_end($filename) {
    if(isset($_GET['debug_theme_mode'])) {
        $debug_theme_mode = $_GET['debug_theme_mode'];
    } else {
        if(isset($_SESSION['debug_theme_mode'])) {
            $debug_theme_mode = $_SESSION['debug_theme_mode'];
        } else {
            $debug_theme_mode = 0;
        }
    }
    $_SESSION['debug_theme_mode'] = $debug_theme_mode;
    if (($debug_theme_mode > 0) && (current_user_can('level_10'))) {
        echo '<p class="debug-theme-file-border-marker">Template file ' . $filename . ' end</p>';
    }
}

function ht_force_download_link($url) {
    $parsed = ltrim(parse_url($url, PHP_URL_PATH), '/');
    return '/download?file=' . urlencode($parsed);
}

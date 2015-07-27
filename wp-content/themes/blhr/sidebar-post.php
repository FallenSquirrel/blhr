<?php
/**
 * The Sidebar for Posts.
 *
 * @author Nina Taberski-Besserdich (nina.taberski@besserdich.com)
 * @package WordPress
 * @subpackage BIC Bootstrap Wordpress Theme
 */
?>
<?php ht_debug_theme_file_start(__FILE__); ?>
<section class="sidebar-posts">

    <?php
    if (function_exists('dynamic_sidebar')) {

        dynamic_sidebar("sidebar-post");
        
    }?>

</section>
<?php ht_debug_theme_file_end(__FILE__); ?>
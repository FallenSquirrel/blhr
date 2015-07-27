<?php
/**
 * The Sidebar for Pages.
 *
 * @author Nina Taberski-Besserdich (nina.taberski@besserdich.com)
 * @package WordPress
 * @subpackage BIC Bootstrap Wordpress Theme
 */
?>
<?php ht_debug_theme_file_start(__FILE__); ?>
<section class="sidebar-page">
    <?php
    if (function_exists('dynamic_sidebar')) {
        
        dynamic_sidebar("sidebar-page");
        
    }?>
</section>
<?php ht_debug_theme_file_end(__FILE__); ?>
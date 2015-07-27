<?php
/**
 * The Sidebar for Companies.
 */
?>
<?php ht_debug_theme_file_start(__FILE__); ?>
<section class="sidebar-companies">

    <?php if (function_exists('dynamic_sidebar')) {

        dynamic_sidebar("sidebar-firmen");
        
    } ?>

</section>
<?php ht_debug_theme_file_end(__FILE__); ?>
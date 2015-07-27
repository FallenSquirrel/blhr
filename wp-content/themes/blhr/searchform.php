<?php
/*
 * The Search Form.
 */
?>
<?php ht_debug_theme_file_start(__FILE__); ?>
<form action="/" method="get" class="form-inline" role="form" id="firmensuchbox-head">
    <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="<?php _e('Search for Products, Events etc.', 'blhr-theme'); ?>" class="form-control input-sm"/>
    <input type="submit" class="input-submit" value="Suchen">
</form>
<?php ht_debug_theme_file_end(__FILE__); ?>
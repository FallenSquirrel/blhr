<?php ht_debug_theme_file_start(__FILE__); ?>

<?php
wp_reset_query();
$args = array(
    'post_parent' => get_the_ID(),
    'post_type'   => 'attachment',
    'post_mime_type' => 'application/pdf',
    'numberposts' => -1 );
$children_array = get_children($args);
?>

<?php if (count($children_array) > 0): ?>
    <div class="post-attachments">
        <ul class="clean post-files" style="margin: 0 10px;">
            <?php foreach($children_array as $file): ?>
                <li>
                    <a href="<?php echo wp_get_attachment_url($file->ID); ?>"><i class="fa fa-angle-double-down kgk-color-primary"></i> <strong><?php _e('Download article as pdf', 'blhr-theme'); ?></strong></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<?php ht_debug_theme_file_end(__FILE__); ?>
<?php ht_debug_theme_file_start(__FILE__); ?>
<?php
$authorIds = get_author_ids(get_the_ID());
$migratedAuthor = get_post_meta(get_the_ID(), 'autor', true);
?>

<?php if ($authorIds) {
    if (count($authorIds) === 1) {
        $authorId = $authorIds[0]; ?>
        <div class="author-box content-indent">
            <div class="clearfix">
                <a href="<?php echo get_the_permalink($authorId); ?>"
                   title="<?php echo esc_attr(strip_tags(get_the_title($authorId))); ?>">
                    <?php echo get_the_post_thumbnail($authorId, 'author-thumb', array('class' => 'image')); ?>
                    <h3><?php _e('About the author', 'blhr-theme'); ?></h3>
                    <p class="kgk-color-primary"><strong><?php echo get_the_title($authorId); ?></strong></p>
                </a>
                <p><?php the_excerpt(); ?></p>
            </div>
        </div>
    <?php } else { ?>
        <div class="author-box content-indent">
            <h3><?php _e('About the authors', 'blhr-theme'); ?></h3>
            <?php
            foreach ($authorIds as $authorId) {
                $author = get_post($authorId); ?>
                    <div class="multi-author-line clearfix">
                        <a href="<?php echo get_the_permalink($authorId); ?>"
                           title="<?php echo esc_attr(strip_tags(get_the_title($authorId))); ?>">
                            <?php echo get_the_post_thumbnail($authorId, 'box-thumb-square', array('class' => 'image')); ?>

                            <p class="kgk-color-primary"><strong><?php echo get_the_title($authorId); ?></strong></p>
                        </a>

                        <p><?php the_excerpt(); ?></p>
                    </div>
            <?php } ?>
        </div>
    <?php }
} elseif ($migratedAuthor) { ?>
    <div class="author-box content-indent">
        <div class="clearfix">
            <img src="<?php bloginfo('stylesheet_directory'); ?>/img/no-image.png" class="image bordered-image" />

            <h3><?php _e('About the author', 'blhr-theme'); ?></h3>
            <p class="kgk-color-primary"><strong><?php echo $migratedAuthor; ?></strong></p>
        </div>
    </div>
<?php } ?>
<?php ht_debug_theme_file_end(__FILE__); ?>
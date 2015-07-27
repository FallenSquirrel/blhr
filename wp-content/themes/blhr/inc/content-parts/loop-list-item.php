<?php ht_debug_theme_file_start(__FILE__); ?>
<div id="post-<?php the_ID(); ?>" class="entry clearfix <?php if ( has_post_thumbnail()){echo 'hasimage ';} ?>">
    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute('echo=1'); ?>">
        <?php
        generate_post_thumbnail_size_if_not_exist(get_the_ID(),'article-stream');
        ?>
        <?php if ( has_post_thumbnail() ): ?>
            <?php the_post_thumbnail( 'article-stream', array('class' => 'alignleft', 'title' => the_title_attribute('echo=0')) ); ?>
        <?php endif; ?>
        <h2><?php the_title(); ?></h2>
    </a>
    <p><?php the_homepage_excerpt(); ?></p>
    <p class="meta"><?php echo get_the_date(getDateFormatForCurrentLanguage()) ; ?> - <?php echo get_the_category_name(get_the_ID()) ; ?></p>
</div>
<?php ht_debug_theme_file_end(__FILE__); ?>
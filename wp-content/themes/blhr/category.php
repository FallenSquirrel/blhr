<?php get_header(); ?>
<?php ht_debug_theme_file_start(__FILE__); ?>

<div class="container">
    <div class="row">
        <?php get_template_part('inc/main-columns-pre'); ?>
        <div class="article-loop">
            <?php
            while ( have_posts() ): the_post();
                get_template_part('content', 'single');
            endwhile;
            ?>
        </div>

        <?php if (is_paged()): ?>
            <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
        <?php endif; ?>
        <?php get_template_part('inc/main-columns-post'); ?>
    </div>
</div><!-- container -->

<?php ht_debug_theme_file_end(__FILE__); ?>
<?php get_footer(); ?>
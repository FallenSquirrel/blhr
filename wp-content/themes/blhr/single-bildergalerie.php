<?php get_header(); ?>
<?php ht_debug_theme_file_start(__FILE__); ?>
<div class="container">
    <div class="row">
        <?php get_template_part('inc/main-columns-pre'); ?>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part('content-bildergalerie'); ?>
                <?php endwhile;
            endif; ?>
        <?php get_template_part('inc/main-columns-post'); ?>
    </div>
</div>
<?php ht_debug_theme_file_end(__FILE__); ?>
<?php get_footer(); ?>
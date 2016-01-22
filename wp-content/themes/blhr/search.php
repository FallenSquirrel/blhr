<?php get_header(); ?>
<?php ht_debug_theme_file_start(__FILE__); ?>

    <div class="container">
        <div class="row">
            <?php get_template_part('inc/main-columns-pre'); ?>
            <div class="frame">
                <div class="frame-headline">
                    <div class="frame-title">
                        <h2 class="entry-title">
                            Suchergebnisse:
                        </h2>
                    </div>
                </div>
            </div>

            <div class="article-loop">
                <?php
                while ( have_posts() ): the_post();
                    get_template_part('content', 'single');
                endwhile;
                ?>
            </div>
            <?php get_template_part('inc/main-columns-post'); ?>
        </div>
    </div>

<?php ht_debug_theme_file_end(__FILE__); ?>
<?php get_footer(); ?>
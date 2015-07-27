<?php get_header(); ?>
<?php ht_debug_theme_file_start(__FILE__); ?>


<div class="container">
    <div class="row">
        <?php get_template_part('inc/main-columns-pre'); ?>
        <?php $page = get_page_by_title('Home'); ?>
        <?php if ($page): ?>
            <section class="frame home-welcome-text">
                <header class="frame-headline">
                    <div class="frame-title">
                        <h2 class="entry-title">
                            Willkommen bei den BlueHornets!
                        </h2>
                    </div>
                    <div class="frame-icons">
                        <?php
                        if($editLink = get_edit_post_link()) {
                            echo '<a href="'.$editLink.'"><i class="fa fa-edit"></i></a>';
                        }
                        ?>
                    </div>
                </header>
                <article class="frame-body">
                    <?php echo $page->post_content; ?>
                </article>
                <footer class="frame-footer">
                </footer>
            </section>
        <?php endif; ?>

        <div class="frame">
            <div class="frame-headline">
                <div class="frame-title">
                    <h2 class="entry-title">
                        Aktuelles:
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

        <?php if (is_paged()): ?>
            <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
        <?php endif; ?>
        <?php get_template_part('inc/main-columns-post'); ?>
    </div>
</div>

<?php ht_debug_theme_file_end(__FILE__); ?>
<?php get_footer(); ?>
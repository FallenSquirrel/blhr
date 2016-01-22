<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php get_header(); ?>
<?php ht_debug_theme_file_start(__FILE__); ?>


    <div class="container">
        <div class="row">
            <?php get_template_part('inc/main-columns-pre'); ?>
            <section class="frame home-welcome-text">
                <header class="frame-headline">
                    <div class="frame-title">
                        <h2 class="entry-title">
                            404 - Seite nicht gefunden
                        </h2>
                    </div>
                    <div class="frame-icons"></div>
                </header>
                <article class="frame-body">
                    Sorry, aber diese Seite existiert nicht.
                </article>
                <footer class="frame-footer">
                </footer>
            </section>
            <?php get_template_part('inc/main-columns-post'); ?>
        </div>
    </div>



<?php ht_debug_theme_file_end(__FILE__); ?>
<?php get_footer(); ?>
<?php
/*
Template Name: Ohne Sidebar
*/
?>
<?php get_header(); ?>
<?php ht_debug_theme_file_start(__FILE__); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12" id="site-main">
                <?php if(have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <section class="frame">
                                <header class="frame-headline">
                                    <div class="frame-title">
                                        <h1 class="entry-title"><?php the_title(); ?></h1>
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
                                    <?php the_content('<span class="read-more">' . __('more...', 'blhr-theme') . '</span>');?>
                                </article>
                                <footer class="frame-footer"></footer>
                            </section>
                        </article>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php ht_debug_theme_file_end(__FILE__); ?>
<?php get_footer(); ?>
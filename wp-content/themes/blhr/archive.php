<?php
/**
 * The template for displaying Archive pages.
 * 
 * @author Nina Taberski-Besserdich (nina.taberski@besserdich.com)
 * @package WordPress
 * @subpackage BIC Bootstrap Wordpress Theme
 */
?>
<?php get_header(); ?>
<?php ht_debug_theme_file_start(__FILE__); ?>

<div class="container">
    <div class="row">
        <?php get_template_part('inc/main-columns-pre'); ?>
            <h1 class="bb1"><?php if(is_tag()) { echo single_tag_title(); } else { post_type_archive_title(); } ?></h1>
            <div class="article-loop">
                <?php while ( have_posts() ): the_post(); ?>
                    <?php get_template_part('inc/content-parts/loop', 'list-item'); ?>
                <?php endwhile;  ?>
            </div>
            <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
        <?php get_template_part('inc/main-columns-post'); ?>
    </div>

</div><!-- container -->


<?php ht_debug_theme_file_end(__FILE__); ?>
<?php get_footer(); ?>
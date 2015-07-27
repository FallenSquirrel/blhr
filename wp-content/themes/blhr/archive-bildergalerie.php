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
<script type="text/javascript">
    jQuery(function() {
        gallerySlider('.gallerySlider');
    });
</script>
<div class="container">
    <div class="row">
        <?php get_template_part('inc/main-columns-pre'); ?>
            <h1 class="bb1"><?php post_type_archive_title(); ?></h1>
            <div class="article-loop">
                <?php query_posts(array_merge( $wp_query->query, array('post_parent' => 0))); ?>
                <?php if ( have_posts() ) :?>
                    <div class="article-loop">
                        <?php while ( have_posts() ): the_post(); ?>
                            <div id="post-<?php the_ID(); ?>" class="entry clearfix">
                                <h3 class="entry-subtitle"><time class="entry-date"><?php echo get_the_date(); ?></time></h3>
                                <h2><a href="<?php echo get_permalink( get_the_ID() ); ?>"><?php the_title(); ?></a></h2>

                                <?php
                                $galleryData = get_post_gallery(get_the_ID(), false);
                                $galleryPictures = convertGalleryShortCodeToPictures($galleryData);
                                if(!empty($galleryPictures)):
                                    foreach($galleryPictures as &$picture) {
                                        $picture['link'] = get_permalink(get_the_ID());
                                    }
                                    echo getGallerySliderHTMLCode($galleryPictures);
                                endif;
                                ?>

                            </div>
                        <?php endwhile;  ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ( is_paged()): ?>
                <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
            <?php else: ?>
                <div class="wp-pagenavi-home"><?php next_posts_link(__('More <span>»</span>', 'blhr-theme'), 0); ?></div>
            <?php endif; ?>
        <?php get_template_part('inc/main-columns-post'); ?>
    </div>
</div><!-- container -->

<?php ht_debug_theme_file_end(__FILE__); ?>
<?php get_footer(); ?>
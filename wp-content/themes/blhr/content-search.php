<?php
/**
 * The template for displaying content in the single.php.
 * 
 * @author Nina Taberski-Besserdich (nina.taberski@besserdich.com)
 * @package WordPress
 * @subpackage BIC Bootstrap Wordpress Theme
 */
?>
<?php ht_debug_theme_file_start(__FILE__); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h2>
    </header><!--end .entry-header -->

    <section class="post-content">
        <div class="entry-content">
            <?php the_homepage_excerpt();?>
            <?php global $post; ?>
            <?php if ($post->post_type == 'page'): ?>
                <p class="meta"><?php _e('Page', 'blhr-theme'); ?></p>
            <?php elseif ($post->post_type == 'autor'): ?>
                <p class="meta"><?php _e('Author', 'blhr-theme'); ?></p>
            <?php else: ?>
                <p class="meta"><?php echo get_the_date() ; ?> - <?php echo get_the_category_name(get_the_ID()) ; ?></p>
            <?php endif ?>
        </div>
    </section>

</article><!-- /.post-->
<?php ht_debug_theme_file_end(__FILE__); ?>
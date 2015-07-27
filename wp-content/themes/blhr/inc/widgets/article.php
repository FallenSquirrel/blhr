<?php

class ht_Article_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'ht_artikel_widget', // Base ID
            'Artikel Neu und Meistgelesen' // Name
        );
    }

    function widget( $args, $instance ) {
        extract($args);

        echo $before_widget; ?>
        <?php ht_debug_theme_file_start(__FILE__); ?>

        <?php
        if(function_exists('wmp_get_popular')) {
            $mostPopularPosts = wmp_get_popular();
        }

        wp_reset_query();
        wp_reset_postdata();
        $args = array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 5, 'orderby'=>'post_date', 'order' => 'DESC','ignore_sticky_posts' => true);
        $newarticlequery = new WP_Query($args);
        wp_reset_postdata();

        ?>

        <h4 class="widget-title clearfix tabbed">
            <span class="title"><?php _e('Articles', 'blhr-theme'); ?></span>
            <?php
            if( isset($mostPopularPosts) && !empty($mostPopularPosts) ) {
                ?><span class="title-tab" ref="mostreadarticle-box"><?php _e('Most popular', 'blhr-theme'); ?></span><?php
            }
            ?><span class="title-tab active" ref="newarticle-box"><?php _e('Recent', 'blhr-theme'); ?></span>
        </h4>

        <div class="widget-content clearfix tab-content" refid="newarticle-box">
            <?php if( $newarticlequery->have_posts() ): ?>
                <ul>
                    <?php while ($newarticlequery->have_posts()): $newarticlequery->the_post(); ?>
                        <li class="bb1">
                            <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                                <span class="widget-entry-title"><strong><?php the_title(); ?></strong></span>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>

        <?php
        if( isset($mostPopularPosts) && !empty($mostPopularPosts) ) {
            ?>

            <div class="widget-content clearfix tab-content" style="display:none;" refid="mostreadarticle-box">
                <ul class="clean clearfix">
                    <?php
                    foreach($mostPopularPosts as $mostPopularPost) {
                        ?>
                        <li class="bb1">
                            <a title="<?php echo sanitize_title(get_the_title($mostPopularPost->ID)); ?>" href="<?php echo get_permalink($mostPopularPost->ID); ?>">
                                <span class="widget-entry-title"><strong><?php echo get_the_title($mostPopularPost->ID); ?></strong></span>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>

            <?php
        }
        ?>

        <?php ht_debug_theme_file_end(__FILE__); ?>
        <?php echo $after_widget;
        wp_reset_query();
    }
}
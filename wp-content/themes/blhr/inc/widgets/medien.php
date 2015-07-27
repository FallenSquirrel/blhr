<?php

class ht_Medien_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'ht_medien_widget', // Base ID
            'Medien' // Name
        );
    }

    function widget( $args, $instance ) {
        extract($args);

        $typeB = 'bildergalerie';

        wp_reset_query();
        wp_reset_postdata();

        $argsB = array('post_type' => $typeB, 'post_status' => 'publish', 'posts_per_page' => 4, 'post_parent' => 0);
        $queryB = new WP_Query($argsB);

        echo $before_widget; ?>
        <?php ht_debug_theme_file_start(__FILE__); ?>

        <h4 class="widget-title clearfix">
            <span class="title"><?php _e('Picture galleries', 'blhr-theme'); ?></span>
        </h4>
        <?php if( $queryB->have_posts() ): ?>
            <div class="widget-content clearfix" refid="bilder-box">
                <ul class="clean clearfix">
                    <?php while ($queryB->have_posts()): $queryB->the_post(); ?>
                        <?php
                        $gallery = get_post_gallery(get_the_ID(),false);
                        if(!isset($gallery['ids'])) continue;
                        $ids = explode( ",", $gallery['ids'] );
                        if(!count($ids)) continue;
                        generate_image_size_if_not_exist($ids[0],'box-thumb');
                        $imageData = wp_get_attachment_image_src($ids[0],'box-thumb');
                        ?>
                        <li class="clearfix bb1">
                            <div class="row">
                                <div class="col-xs-4">
                                    <a href="<?php echo get_permalink( get_the_ID() ); ?>">
                                        <img src="<?php echo $imageData[0]; ?>" alt="<?php the_title_attribute(); ?>" />
                                    </a>
                                </div>
                                <div class="col-xs-8">
                                    <a href="<?php echo get_permalink( get_the_ID() ); ?>">
                                        <span class="widget-entry-title"><b><?php the_title(); ?></b></span>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <div class="text-right">
                    <a href="/bildergalerie/"><b><?php _e('More picture galleries', 'blhr-theme'); ?></b></a> <i class="kgk-color-primary fa fa-angle-double-right"></i>
                </div>
            </div>
        <?php endif; ?>
        <?php ht_debug_theme_file_end(__FILE__); ?>
        <?php echo $after_widget;
        wp_reset_query();  // Restore global post data stomped by the_post().
    }
}
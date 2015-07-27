<?php

class ht_Termine_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'ht_termine_widget', // Base ID
            'Termine Widget' // Name
        );
    }

    function widget( $args, $instance ) {
        extract($args);
        wp_reset_query();
        wp_reset_postdata();
        $args = array('post_type' => 'termin', 'post_status' => 'publish', 'posts_per_page' => 3, 'meta_key' => 'wpcf-anfangsdatum', 'meta_compare'=>'>=', 'meta_value'=> time(), 'orderby'=>'meta_value', 'order' => 'ASC');
        $query = new WP_Query($args);
        wp_reset_postdata();

        echo $before_widget; ?>
        <?php ht_debug_theme_file_start(__FILE__); ?>

        <div class="widget-termine">
            <?php echo $before_title; ?>
            <?php _e('Events', 'blhr-theme'); ?>
            <?php echo $after_title; ?>

            <div class="widget-content clearfix">
                <?php if( $query->have_posts() ): ?>
                    <ul class="clean">
                        <?php while ($query->have_posts()): $query->the_post(); ?>
                            <li class="bb1">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="calendar_sheet clearfix">
                                            <span class="month"><?php the_event_startdate ('M'); ?></span>
                                            <span class="day"><?php the_event_startdate ('d'); ?></span>
                                        </a>
                                    </div>
                                    <div class="col-xs-9">
                                        <span class="widget-entry-subtitle"><?php the_event_veranstaltungsort(); ?></span>
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                            <span class="widget-entry-title"><strong><?php the_title(); ?></strong></span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>

                    <div class="text-right">
                        <a href="<?php echo get_post_type_archive_link('termin'); ?>"><b><?php _e('More events', 'blhr-theme'); ?></b></a> <i class="kgk-color-primary fa fa-angle-double-right"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php ht_debug_theme_file_end(__FILE__); ?>
        <?php echo $after_widget;
        wp_reset_query();  // Restore global post data stomped by the_post().
    }
}
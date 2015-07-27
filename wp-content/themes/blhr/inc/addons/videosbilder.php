<?php

function sidebar_videosbilder($args)
{
    extract($args);
    wp_reset_query();
    wp_reset_postdata();
    $typeV = 'video';
    $argsV = array('post_type' => $typeV, 'post_status' => 'publish', 'posts_per_page' => 4);
    $queryV = new WP_Query($argsV);
    wp_reset_query();
    wp_reset_postdata();
    $typeB = 'bildergalerie';
    $argsB = array('post_type' => $typeB, 'post_status' => 'publish', 'posts_per_page' => 4, 'meta_query' => array(
        array('key' => 'is-migrated', 'compare' => 'NOT EXISTS', 'value' => '')));
    $queryB = new WP_Query($argsB);

    echo $before_widget; ?>
    <?php ht_debug_theme_file_start(__FILE__); ?>

    <h4 class="widget-title">
        <?php if( $queryV->have_posts() ): ?>
            <div class="col-xs-6 active" id="box-video-head">
                <span class="title">Videos</span>
            </div>
        <?php endif; ?>
        <?php if( $queryB->have_posts() ): ?>
            <div class="col-xs-6" id="box-bild-head">
                <span class="title">Bilder</span>
            </div>
        <?php endif; ?>
        <!--<i class="fa fa-caret-down"></i>-->
    </h4>
    <div class="widget-content clearfix" id="videos-box" <?php if( !$queryV->have_posts() ): ?>style="display: none;"<?php endif; ?>>
        <?php if( $queryV->have_posts() ): ?>
            <ul class="clean clearfix">
                <?php while ($queryV->have_posts()): $queryV->the_post(); ?>
                    <li class="clearfix">
                        <div class="col-xs-5">
                            <a href="<?php echo get_permalink( get_the_ID() ); ?>">
                                <?php the_post_thumbnail( 'thumbnail' ); ?>
                            </a>
                        </div>
                        <div class="col-xs-7">
                            <a href="<?php echo get_permalink( get_the_ID() ); ?>">
                                <p><strong><?php the_title(); ?></strong> <i class="fa fa-chevron-right"></i></p>
                            </a>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
            <div class="clearfix sidebar-button">
                <a href="/video/" class="nv-btn-grey upper-this color-white">Mehr Videos</a>
            </div>
        <?php endif; ?>
    </div>
    <div class="widget-content clearfix" id="bilder-box"  <?php if( !$queryB->have_posts() || $queryV->have_posts() ): ?>style="display: none;"<?php endif; ?>>
        <?php if( $queryB->have_posts() ): ?>
            <ul class="clean clearfix">
                <?php while ($queryB->have_posts()): $queryB->the_post(); ?>
                    <?php $images = get_post_gallery_images(get_the_ID());
                    if (count(images)>0):
                        $image = $images[0]; ?>
                        <li class="clearfix">
                            <div class="col-xs-5">
                                <a href="<?php echo get_permalink( get_the_ID() ); ?>">
                                    <img src="<?php echo $image; ?>" alt="<?php the_title_attribute('echo=1'); ?>" />
                                </a>
                            </div>
                            <div class="col-xs-7">
                                <a href="<?php echo get_permalink( get_the_ID() ); ?>">
                                    <p><strong><?php the_title(); ?></strong> <i class="fa fa-chevron-right"></i></p>
                                </a>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endwhile; ?>
            </ul>
            <div class="clearfix sidebar-button">
                <a href="/bildergalerie/" class="nv-btn-grey upper-this color-white">Mehr Bildergalerien</a>
            </div>
        <?php endif; ?>
    </div>

    <?php ht_debug_theme_file_end(__FILE__); ?>
    <?php echo $after_widget;
    wp_reset_query();  // Restore global post data stomped by the_post().

}

function register_videosbilder_sidebar()
{
    wp_register_sidebar_widget(
        'sidebar_widget_videosbilder', // eindeutige widget id
        'Videos & Bilder',          // widget name
        'sidebar_videosbilder',  // callback function
        array(                  // options
            'description' => 'Videos und Bilder für die Sidebar'
        )
    );
}
add_action( 'widgets_init', 'register_videosbilder_sidebar');
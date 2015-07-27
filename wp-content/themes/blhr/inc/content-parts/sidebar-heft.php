<?php ht_debug_theme_file_start(__FILE__); ?>
<div class="clearfix">
    <div class="left heftdetails">
        <p>
            <span class="label upper-this"><?php _e('Current issue', 'blhr-theme'); ?></span><br/>
            <span class="field"><?php the_title(); ?></span>
        </p>
        <!--
        <p>
            <span class="label">Titelstory</span><br/>

        </p>
        -->
    </div>

    <div class="left">
        <?php $post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
        $imageArr = wp_get_attachment_image_src($post_thumbnail_id, 'heft-small', false);
        $imageUrl = $imageArr[0];
        ?>
        <a href="<?php echo get_recent_heft_permalink(); ?>">
            <img src="<?php echo $imageUrl; ?>" alt="<?php the_title(); ?>" />
        </a>
    </div>
</div>
<div class="clearfix">
    <span class="label upper-this">Services</span><br/>
    <span class="field service-area">
        <a href="/hefte/"><?php _e('Archive', 'blhr-theme'); ?> <i class="fa fa-chevron-right"></i></a>&nbsp;
        <a href="/probeheft-bestellen/"><?php _e('Test issue', 'blhr-theme'); ?> <i class="fa fa-chevron-right"></i></a>&nbsp;
        <a class="no-padding" href="/abo/"><?php _e('Subscription', 'blhr-theme'); ?>Abo <i class="fa fa-chevron-right"></i></a>
    </span>
</div>
<?php ht_debug_theme_file_end(__FILE__); ?>
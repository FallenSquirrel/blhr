<?php
/**
 * RSS2 Feed Template for displaying RSS2 Posts feed.
 *
 * @package WordPress
 */

header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
$more = 1;

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>

<rss version="2.0"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:wfw="http://wellformedweb.org/CommentAPI/"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:atom="http://www.w3.org/2005/Atom"
     xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
     xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
     xmlns:pvmeta="http://www.kgk-rubberpoint.de/"
    <?php
    /**
     * Fires at the end of the RSS root to add namespaces.
     *
     * @since 2.0.0
     */
    do_action( 'rss2_ns' );
    ?>
    >

    <channel>
        <title><?php bloginfo_rss('name'); wp_title_rss(); ?></title>
        <atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
        <link><?php bloginfo_rss('url') ?></link>
        <description><?php bloginfo_rss("description") ?></description>
        <lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
        <language><?php bloginfo_rss( 'language' ); ?></language>
        <?php
        $duration = 'hourly';
        /**
         * Filter how often to update the RSS feed.
         *
         * @since 2.1.0
         *
         * @param string $duration The update period.
         *                         Default 'hourly'. Accepts 'hourly', 'daily', 'weekly', 'monthly', 'yearly'.
         */
        ?>
        <sy:updatePeriod><?php echo apply_filters( 'rss_update_period', $duration ); ?></sy:updatePeriod>
        <?php
        $frequency = '1';
        /**
         * Filter the RSS update frequency.
         *
         * @since 2.1.0
         *
         * @param string $frequency An integer passed as a string representing the frequency
         *                          of RSS updates within the update period. Default '1'.
         */
        ?>
        <sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', $frequency ); ?></sy:updateFrequency>
        <?php
        /**
         * Fires at the end of the RSS2 Feed Header.
         *
         * @since 2.0.0
         */
        do_action( 'rss2_head');

        while( have_posts()) : the_post();

            ?>
            <item>
                <subtitle><![CDATA[<?php the_subtitle() ?>]]></subtitle>
                <title><![CDATA[<?php the_title_rss() ?>]]></title>
                <link><?php the_permalink_rss() ?></link>
                <comments><?php comments_link_feed(); ?></comments>
                <?php
                if(get_the_post_thumbnail()):
                    $attachmentData = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), "thumbnail");
                    $attachmentUrl = $attachmentData[0];
                    $attachmentHeaders = get_headers($attachmentUrl, 1);
                    if(is_array($attachmentHeaders) && isset($attachmentHeaders['Content-Length'])) {
                        $filesize = $attachmentHeaders['Content-Length'];
                        ?>
                        <enclosure url="<?php echo $attachmentUrl; ?>" length="<?php echo $filesize; ?>" type="<?php echo get_post_mime_type($post->ID); ?>" />
                        <?php
                    }
                endif;

                $isTopArticle = (int)is_sticky(get_the_ID());
                ?>
                <pvmeta:istoparticle><?php echo $isTopArticle; ?></pvmeta:istoparticle>
                <pubDate><?php if(is_post_type_archive("termine")) { $wpcfAnfangsdatum = get_post_meta($post->ID,"wpcf-anfangsdatum",true); if(!strpos($wpcfAnfangsdatum,"-")) {$wpcfAnfangsdatum = date("Y-m-d H:i:s",$wpcfAnfangsdatum); }; echo mysql2date('D, d M Y', $wpcfAnfangsdatum, false); } else { echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); } ?></pubDate>
                <dc:creator><![CDATA[<?php the_author() ?>]]></dc:creator>
                <?php the_category_rss('rss2') ?>

                <guid isPermaLink="false"><?php the_guid(); ?></guid>
                <?php if (get_option('rss_use_excerpt')) : ?>
                    <description><![CDATA[<?php the_excerpt_rss(); ?>]]></description>
                <?php else : ?>
                    <description><![CDATA[<?php the_excerpt_rss(); ?>]]></description>
                    <?php $content = get_the_content_feed('rss2'); ?>
                    <?php if ( strlen( $content ) > 0 ) : ?>
                        <content:encoded><![CDATA[<?php echo $content; ?>]]></content:encoded>
                    <?php else : ?>
                        <content:encoded><![CDATA[<?php the_excerpt_rss(); ?>]]></content:encoded>
                    <?php endif; ?>
                <?php endif; ?>
                <wfw:commentRss><?php echo esc_url( get_post_comments_feed_link(null, 'rss2') ); ?></wfw:commentRss>
                <slash:comments><?php echo get_comments_number(); ?></slash:comments>
                <?php rss_enclosure(); ?>
                <?php
                /**
                 * Fires at the end of each RSS2 feed item.
                 *
                 * @since 2.0.0
                 */
                do_action( 'rss2_item' );
                ?>
            </item>
        <?php endwhile; ?>
    </channel>
</rss>

<?php ht_debug_theme_file_start(__FILE__); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <section class="frame">
        <header class="frame-headline">
            <div class="frame-title">
                <h2 class="entry-title">
                    <?php
                    $categories = wp_get_post_categories(get_the_ID());
                    if (in_array(get_category_by_slug('news')->term_id, $categories)) {
                        echo '<i class="cat-icon fa fa-globe"></i> ';
                    } elseif (in_array(get_category_by_slug('videos')->term_id, $categories)) {
                        echo '<i class="cat-icon fa fa-play"></i> ';
                    }
                    ?>
                    <?php the_title(); ?>
                </h2>
            </div>
            <div class="frame-icons">
                <?php
                if($editLink = get_edit_post_link()) {
                    echo '<a href="'.$editLink.'"><i class="fa fa-edit"></i></a>';
                }
                ?>
                <?php
                    global $lastVisit;
                    if (strtotime(get_the_date('y-m-d')) > strtotime($lastVisit)) {
                        echo '<i class="fa fa-bolt news-alert" title="Neu"></i>';
                    }
                ?>
            </div>
        </header>
        <article class="frame-body">
            <?php the_content('<span class="read-more">' . __('more...', 'blhr-theme') . '</span>');?>
        </article>
        <?php
        $posttags = get_the_tags();
        if(!empty($posttags)) : ?>
            <footer class="frame-tags">
                <?php
                foreach($posttags as $posttag) {
                    echo '<a href="'.get_tag_link($posttag->term_id).'" class="tag">'.$posttag->name.'</a>';
                } ?>
            </footer>
        <?php endif; ?>
        <footer class="frame-footer">
            <?php
            $author = get_the_author();
            if ($author) {
                echo '<div class="article-author">' . $author . '</div>';
            }
            ?>
            <div class="article-date"><?php echo get_the_date(); ?></div>
        </footer>
    </section>
</article>
<?php ht_debug_theme_file_end(__FILE__); ?>

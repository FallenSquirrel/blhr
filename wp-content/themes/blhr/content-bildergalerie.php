<?php ht_debug_theme_file_start(__FILE__); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php echo get_template_part('snippet','sharebar'); ?>
    <div class="article-content">
        <header class="entry-header">
            <aside class="entry-details">
                <?php if(isGalleryView()): ?>
                    <a href="<?php echo '/'.$wp_query->post->ID.'/'.$wp_query->post->post_name; ?>"><?php _e('Back to the article', 'blhr-theme'); ?></a>
                <?php endif; ?>
                <?php
                if($editLink = get_edit_post_link()) {
                    echo '<div class="mb1em print-hidden"><a href="'.$editLink.'" class="btn">' . __('Edit post', 'blhr-theme') . '</a></div>';
                }
                ?>
            </aside>
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header>

        <section class="post-content">
            <?php
            $isPreview = isset($_GET['preview']) && $_GET['preview'] == 'true';
            if($isPreview) {
                if(isset($_GET['page'])) {
                    $currentPage = intval($_GET['page']);
                } else {
                    $currentPage = 1;
                }
            } else {
                $currentPage = preg_split('#/#', $_SERVER['REQUEST_URI']);
                if ($currentPage[count($currentPage) - 1] === "" || substr($currentPage[count($currentPage) - 1], 0, 1) === "?") {
                    $currentPage = $currentPage[count($currentPage) - 2];
                } else {
                    $currentPage = $currentPage[count($currentPage) - 1];
                }
            }

            if(empty($currentPage) || !is_numeric($currentPage)) {
                $currentPage = 1;
            }

            $galleryIds = array();
            if(is_the_article_migrated() && ($post->post_type == 'post')) {
                $galleries = get_children('post_parent=' . get_the_ID() . '&post_type=bildergalerie');

                if ($galleries) {
                    $globalImages = array();
                    foreach ($galleries as $gallery) {
                        $images = get_post_gallery_images($gallery->ID);
                        if (!$images) {
                            // schauen, ob es migrierte Bildergalerien gibt
                            $images = get_children('post_parent=' . $gallery->ID . '&post_type=attachment&post_mime_type=image');
                            foreach ($images as $singleImage) {
                                array_push($globalImages, $singleImage);
                            }
                        }
                    }

                    if (count($globalImages) > 0) {
                        foreach ($globalImages as $img) {
                            $galleryIds[] = $img->ID;
                        }
                    }
                }
            } else {
                $galleryData = get_post_gallery(get_the_ID(), false);
                $galleryIds = preg_split('/,/', $galleryData['ids']);
            }

            $galleryImagePath = wp_get_attachment_image_src($galleryIds[$currentPage - 1], 'gallery-large');
            $galleryImageData = get_post($galleryIds[$currentPage - 1]);
            $totalPages = count($galleryIds);

            $permalink = get_permalink(get_the_ID());

            $nextPageNumber = $currentPage + 1;
            if($nextPageNumber > $totalPages) {
                $nextPageNumber = 1;
            }

            $prevPageLink  = $currentPage - 1;
            if($prevPageLink == 0) {
                $prevPageLink = $totalPages;
            }

            $postfix = '/';
            if(isGalleryView()) {
                $postfix = '?view=galerie';
            }

            if($isPreview) {
                if(strpos($permalink,'?') !== false) {
                    $nextPageLink = $permalink.'&preview=true&page='.$nextPageNumber;
                    $prevPageLink = $permalink.'&preview=true&page='.$prevPageLink;
                } else {
                    $nextPageLink = $permalink.'?preview=true&page='.$nextPageNumber;
                    $prevPageLink = $permalink.'?preview=true&page='.$prevPageLink;
                }
            } else {
                $nextPageLink = $permalink.$nextPageNumber.$postfix;
                $prevPageLink = $permalink.$prevPageLink.$postfix;
            }

            if(!isGalleryView() && has_excerpt(get_the_ID())) { ?>
                <div class="clearfix post-excerpt">
                    <span class="kgk-color-primary"><strong><?php echo get_the_date(getDateFormatForCurrentLanguage()); ?> - </strong></span><?php echo get_the_excerpt(); ?>
                </div>
                <?php
            }
            ?>
            <div class="entry-content row">
                <div class="col-xs-12">
                    <div class="gallery-image-meta">
                        <div class="gallery-image-date"><?php the_date(getDateFormatForCurrentLanguage()); ?></div>
                        <div class="gallery-image-counter"><?php echo str_replace('%1', $currentPage, str_replace('%2', $totalPages, __('Picture <b>%1</b> of %2', 'blhr-theme'))); ?></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="galleryImageContainer">
                        <div class="galleryImage">
                            <?php
                            if($totalPages > 1) {
                                ?>
                                <a href="<?php echo $prevPageLink; ?>" class="previous">
                                    <i class="arrow fa fa-chevron-left"></i>
                                </a>

                                <a href="<?php echo $nextPageLink; ?>" class="next">
                                    <i class="arrow fa fa-chevron-right"></i>
                                </a>
                            <?php
                            }
                            ?>

                            <div class="images">
                                <div class="slider">
                                    <div class="tile singletile">
                                        <img src="<?php echo $galleryImagePath[0]; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if(!empty($galleryImageData->post_excerpt)) {
                            echo '<div class="galleryImageCaption">'.
                                    $galleryImageData->post_excerpt.
                                 '</div>';
                        }
                        ?>
                    </div>

                    <div>
                        <?php
                            if(!isGalleryView()) {
                                $content = get_post_field('post_content', get_the_ID());
                                $content = preg_replace('/\[.*\]/', '', $content);
                                $content = apply_filters('the_content', $content);
                                echo $content;
                            }
                        ?>
                    </div>

                </div>

                <?php get_template_part('inc/content-parts/single', 'author-box'); ?>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <?php if(the_article_company(false)): ?>
                        <div class="company-box mb1em">
                            <h3><?php _e('Company', 'blhr-theme'); ?></h3>
                            <?php the_article_company(); ?>
                        </div>
                    <?php endif; ?>
                    <?php
                    $posttags = get_the_tags();

                    if(!empty($posttags)) {
                        echo '<div class="tag-box print-hidden">';
                        echo '<h3>' . __('Topics', 'blhr-theme') . '</h3>';
                        foreach($posttags as $posttag) {
                            echo '<a href="'.get_tag_link($posttag->term_id).'" class="tag">'.$posttag->name.'</a>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>
</article>
<?php ht_debug_theme_file_end(__FILE__); ?>
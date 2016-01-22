<?php if (is_home() || is_front_page()):
    $title = get_option('blogname');
    $description = get_option('blogdescription');
elseif (is_category() || is_tag()):
    $catName = single_cat_title('', false);
    $title = $catName . ' - ' . get_option('blogname');
    $description = 'Kategorie ' . $catName;
elseif (is_archive()):
    $archiveName = post_type_archive_title('', false);
    $title = $archiveName.' - ' . get_option('blogname');
    $description = '';
elseif (is_search()):
    $search = get_search_query();
    $title = 'Suchergebnisse für '.$search.' - ' . get_option('blogname');
    $description = 'Hier finden Sie Ergebnisse zum Suchbegriff '.$search.' auf ' . get_option('blogname');
elseif (is_404()):
    $title = '404 Fehler - Seite nicht gefunden - ' . get_option('blogname');
    $description = 'Die aufgerufene Seite existiert nicht auf ' . get_option('blogname');
elseif (is_single()):
    $content_post = get_post(get_the_ID());
    $content = $content_post->post_content;
    $excerpt = $content_post->post_excerpt;
    $description = ($excerpt != '' ? $excerpt : $content);

    if ($description != ''):
        $description = wp_strip_all_tags($description);
        //$content = getFirstSentence($content);
        $description = trim(preg_replace('/\[caption.*\]/', '', $description));
        $description = str_replace('"', '', $description);
        if (strlen($description) > 156) $description = substr($description, 0, 153).'...';
    endif;
    $title = $content_post->post_title.' - ' . get_option('blogname');
elseif (is_page()):
    $page = get_queried_object();
    $pageTitle = $page->post_title;
    $title = $pageTitle . ' - ' . get_option('blogname');
    $description = $pageTitle . ' auf ' . get_option('blogname');
else:
    $title = wp_title(' - ', false, 'right');
    $description = get_option('blogdescription');
endif; ?>

<title><?php echo $title; ?></title>
<meta name="description" content="<?php echo $description; ?>">
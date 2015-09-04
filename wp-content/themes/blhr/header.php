<!DOCTYPE html>
<html <?php language_attributes();?>>
    <head>
	    <meta charset="<?php bloginfo('charset');?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <?php get_template_part('/inc/header', 'meta'); ?>

<!--        <link type="image/png" href="--><?php //echo get_stylesheet_directory_uri().'/img/favicon.png'; ?><!--" rel="Shortcut Icon">-->
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

        <?php wp_head(); ?>
        <!--[if lt IE 9]>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/html5shiv.min.js"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body <?php body_class(); ?>>
        <?php ht_debug_theme_file_start(__FILE__); ?>
        <div id="main-part-center">
            <div id="wrapper">
                <div class="container">
                    <header id="site-header">
                        <div class="row posrel">
                            <div class="col-md-12">
                                <div class="col-md-5 header-left">
                                    <a href="<?php bloginfo('url') ?>" class="main-logo-link">
                                        <h1 class="page-title"><span class="blue">Blue</span><span class="hornets">Hornets</span></h1>
                                    </a>
                                </div>
                                <nav class="col-md-7 header-right clearfix">
                                    <?php wp_nav_menu( array( 'container' => '', 'container_class' => '', 'theme_location' => 'mainmenu'));  ?>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function($) {
                                            $('.menu-item-has-children').hover(function() {
                                                var elem = $(this);
                                                var child = elem.find('ul.sub-menu').first();
                                                var left = (elem.width() / 2) - (child.width() / 2);
                                                child.css('left', left);
                                            });
                                        });
                                    </script>
                                </nav>
                            </div>
                        </div>
                    </header>
                </div>
<?php ht_debug_theme_file_end(__FILE__); ?>
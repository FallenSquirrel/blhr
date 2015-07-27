<?php

$entries = array();
$prev_year = null;

ht_debug_theme_file_start(__FILE__);

if ( have_posts() ):
    echo '<div class="row sub-part">';
        echo $GLOBALS['headline'];
        echo '<div class="heftarchiv-other col-xs-12">';
            echo '<ul class="clearfix clean">';
                while ( have_posts() ):
                    the_post();
                    $title = the_title('','',false);
                    $class = substr (trim($title), 3);
                    $class = (int)substr ($class, 0,-5) ;
                    echo '<li class="'.$class.'"><a href="'.get_permalink().'"><i class="fa fa-chevron-right"></i> '.$title.'</a>';
                endwhile;
            echo '</ul></div>' ;
    echo '</div>';
endif; ?>
<?php ht_debug_theme_file_end(__FILE__); ?>
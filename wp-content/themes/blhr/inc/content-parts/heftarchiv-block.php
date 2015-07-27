<?php

$entries = array();
$prev_year = null;

ht_debug_theme_file_start(__FILE__);

if ( have_posts() ):
    //echo $GLOBALS['headline'];
    while ( have_posts() ):
        the_post();

        $this_year = get_the_date('Y');
        $this_date = get_the_date('Y-m-d');
        $entries[$this_year][$this_date] = array (
            'link' =>  get_permalink(),
            'title' =>  the_title('','',false)
        );
    endwhile;
endif;

foreach ($entries as $year => $entry):
    echo '<div class="heftarchiv-jahr col-xs-12"><h3 name="y'.$year.'">'.$year.'</h3>';
    ksort($entry);
    echo '<ul class="clearfix clean">';
    foreach ($entry as $ausgabe)
    {
        $class = substr (trim($ausgabe['title']), 3);
        $class = (int)substr ($class, 0,-5) ;
        echo '<li class="'.$class.'"><a href="'.$ausgabe['link'].'"><span class="kgk-color-primary">&raquo;</span> '.$ausgabe['title'].'</a>';
    }
    echo '</ul></div>' ;
endforeach; ?>
<?php ht_debug_theme_file_end(__FILE__); ?>
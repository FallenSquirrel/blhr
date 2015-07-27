<?php

function the_event_startdate ($format = 'd F, Y', $echo = true)
{
    global $post;
    $date = get_post_meta($post->ID, 'wpcf-anfangsdatum', true);
    if ($date != '') {
        if (!isTimestamp($date))
            $date = strtotime($date);
        $date = date_i18n($format, $date);
        if ($echo) echo $date; else return $date;
    } else
        if ($echo) echo ''; else return false;
}

function has_end_date()
{
    global $post;
    $date = get_post_meta($post->ID, 'wpcf-enddatum', true);
    return $date != '' ? true : false;
}

function isEndNotLikeStart()
{
    global $post;
    $startDate = get_post_meta($post->ID, 'wpcf-anfangsdatum', true);
    $endDate = get_post_meta($post->ID, 'wpcf-enddatum', true);
    return ($startDate == $endDate ? false : true);
}

function the_event_enddate ($format = 'd F, Y', $echo = true)
{
    global $post;
    $date = get_post_meta($post->ID, 'wpcf-enddatum', true);
    if ($date != '') {
        if (!isTimestamp($date))
            $date = strtotime($date);
        $date = date_i18n($format, $date);
        if ($echo) echo $date; else return $date;
    } else
        if ($echo) echo ''; else return false;
}

function isTimestamp( $string ) {
    return ( 1 === preg_match( '~^[1-9][0-9]*$~', $string ) );
}

function the_event_veranstaltungsort( $echo = true )
{
    global $post;
    if($value = get_post_meta($post->ID, 'wpcf-veranstaltungsort', true))
        if ($echo) echo $value; else return $value;
    else
        return false;
}

function the_event_veranstalteradresse( $echo = true )
{
    global $post;
    if ($value = get_post_meta($post->ID, 'wpcf-veranstaltungsadresse', true))
        if ($echo) echo $value; else return $value;
    else
        return false;
}

function the_event_infolink( $echo = true )
{
    global $post;
    if ($value = get_post_meta($post->ID, 'wpcf-info-link', true))
        if ($echo) echo $value; else return $value;
    else
        return false;
}

function the_event_telefon( $echo = true )
{
    global $post;
    if ($value = get_post_meta($post->ID, 'wpcf-anmeldung-telefon', true))
        if ($echo) echo $value; else return $value;
    else
        return false;
}

function the_event_emailanmeldung( $echo = true )
{
    global $post;
    if ($value = get_post_meta($post->ID, 'wpcf-anmeldung-email', true))
        if ($echo) echo $value; else return $value;
    else
        return false;
}

//function the_event_company( $echo = true )
//{
//    global $post;
//    $value = get_post_meta($post->ID, 'firma', true);
//    if (!empty($value))
//    {
//        $companyList = array();
//        $companyController = new CompanyController();
//        $companyIds = preg_split('/,/', $value);
//        foreach($companyIds as $companyId) {
//            $companyItem = array();
//            $companyItem['id'] = $companyId;
//            $companyData = $companyController->getCompanyById($companyId);
//            $companyItem['name'] = $companyController->getCompanyById($companyId)->name1;
//            $companyItem['street'] = $companyData->street;
//            $companyItem['zip'] = $companyData->zip;
//            $companyItem['city'] = $companyData->city;
//            $companyItem['countryname'] = $companyData->countryname;
//            $companyList[] = $companyItem;
//        }
//
//        $html = '';
//        if (count($companyList)) {
//            $odd = false;
//            foreach($companyList as $companyItem) {
//                $marginRight = $odd ? '0' : '2%';
//                $html .= "<div class='event-company col-xs-6' style='width: 48%; margin-right: ".$marginRight."'>
//                    <p><strong>".$companyItem['name']."</strong></p>
//                    <p>
//                    ".$companyItem['street']."<br/>
//                    ".$companyItem['zip']." ".$companyItem['city']."<br/>
//                    ".$companyItem['countryname']."
//                    </p>
//                    <i class='fa fa-chevron-right'></i> <a href='/firma/?f=".$companyItem['id']."'>Zum Firmenprofil</a>
//                </div>";
//                $odd = !$odd;
//            }
//        }
//
//        if ($echo) {
//            echo $html;
//        } else {
//            return $html;
//        }
//    } else {
//        return false;
//    }
//}
/*
function sidebar_termine($args)
{
    extract($args);
    wp_reset_query();
    wp_reset_postdata();
    $type = 'termine';
    $args = array('post_type' => $type, 'post_status' => 'publish', 'posts_per_page' => 3, 'meta_key' => 'wpcf-anfangsdatum', 'meta_compare'=>'>=', 'meta_value'=> time(), 'orderby'=>'meta_value', 'order' => 'ASC');
    $query = new WP_Query($args);
    wp_reset_postdata();

    echo $before_widget; ?>

    <h4 class="widget-title">
        <span class="title">Termine</span>
        <!--<i class="fa fa-caret-down"></i>-->
    </h4>
    <div class="widget-content clearfix" id="termine-box">
        <?php if( $query->have_posts() ): ?>
            <ul class="clean">
                <?php while ($query->have_posts()): $query->the_post(); ?>
                    <li class="clearfix">
                        <div class="calendar_sheet">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute('echo=1'); ?>" class="clearfix">
                                <span class="day"><?php the_event_startdate ('d.'); ?></span>
                                <br/>
                                <span class="month"><?php the_event_startdate ('F'); ?></span>
                                <br/>
                                <span class="year"><?php the_event_startdate ('Y'); ?></span>
                            </a>
                        </div>
                        <p>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute('echo=1'); ?>">
                                <strong><?php the_title(); ?></strong>
                            </a>
                        </p>
                        <p class="event-location"><?php if(the_event_location(false)) { the_event_location(); } else { the_event_veranstaltungsort(); } ?> <a href="<?php echo get_permalink( get_the_ID() ); ?>"><i class="fa fa-chevron-right"></i></a></p>
                    </li>
                <?php endwhile; ?>
            </ul>

            <div class="clearfix">
                <a href="/termine" class="nv-btn-grey upper-this color-white">Mehr Termine</a>
            </div>
        <?php endif; ?>
    </div>

    <?php echo $after_widget;
    wp_reset_query();  // Restore global post data stomped by the_post().

}

function register_sidebar_termine()
{
    wp_register_sidebar_widget(
        'sidebar_widget_termine', // eindeutige widget id
        'Termine',          // widget name
        'sidebar_termine',  // callback function
        array(                  // options
            'description' => 'Bereich um die Termine in der Sidebar anzuzeigen'
        )
    );
}
add_action( 'widgets_init', 'register_sidebar_termine');
*/
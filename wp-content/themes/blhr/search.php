<?php get_header(); ?>
<?php ht_debug_theme_file_start(__FILE__); ?>

<div class="container" id="suche">
    <div class="row">
        <?php get_template_part('inc/main-columns-pre'); ?>
        <?php
            global $wp_query;

            function valid_date($date, $format = 'YYYY-MM-DD')
            {
                if(strlen($date) >= 8 && strlen($date) <= 10){
                    $separator_only = str_replace(array('M','D','Y'),'', $format);
                    $separator = $separator_only[0];
                    if($separator){
                        $regexp = str_replace($separator, "\\" . $separator, $format);
                        $regexp = str_replace('MM', '(0[1-9]|1[0-2])', $regexp);
                        $regexp = str_replace('M', '(0?[1-9]|1[0-2])', $regexp);
                        $regexp = str_replace('DD', '(0[1-9]|[1-2][0-9]|3[0-1])', $regexp);
                        $regexp = str_replace('D', '(0?[1-9]|[1-2][0-9]|3[0-1])', $regexp);
                        $regexp = str_replace('YYYY', '\d{4}', $regexp);
                        $regexp = str_replace('YY', '\d{2}', $regexp);
                        if($regexp != $date && preg_match('/'.$regexp.'$/', $date)){
                            foreach (array_combine(explode($separator,$format), explode($separator,$date)) as $key=>$value) {
                                if ($key == 'YY') $year = '20'.$value;
                                if ($key == 'YYYY') $year = $value;
                                if ($key[0] == 'M') $month = $value;
                                if ($key[0] == 'D') $day = $value;
                            }
                            if (checkdate($month,$day,$year)) return true;
                        }
                    }
                }
                return false;
            }

            function date_german2mysql($datum) {
                list($tag, $monat, $jahr) = explode(".", $datum);
                return sprintf("%04d-%02d-%02d", $jahr, $monat, $tag);
            }

            // Filter für Datumsbereiche
            function filter_where_lastweek ($where = '')
            {
                $where .= " AND post_date > '" . date('Y-m-d', strtotime('-7 days')) . "'";
                return $where;
            }
            function filter_where_lastmonth ($where = '')
            {
                $where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
                return $where;
            }
            function filter_where_lastyear ($where = '')
            {
                $where .= " AND post_date > '" . date('Y-m-d', strtotime('-365 days')) . "'";
                return $where;
            }

            function filter_where_ownrange ($where = '')
            {
                $whereStart = '';
                $whereEnd   = '';

                $dateStart = isset ($_GET['dateStart']) ? wp_strip_all_tags ($_GET['dateStart']): '' ;
                $dateStart =  date_german2mysql ($dateStart);
                if (valid_date ($dateStart))
                    $whereStart = " AND post_date >= '$dateStart'";

                $dateEnd = isset ($_GET['dateEnd']) ? wp_strip_all_tags ($_GET['dateEnd']): '' ;
                $dateEnd =  date_german2mysql ($dateEnd);
                if (valid_date ($dateEnd))
                    $whereEnd = " AND post_date <= '$dateEnd'";

                $where .= $whereStart . $whereEnd;
                return $where;
            }

            // filter in abhängigkeit des date_range parameters aktivieren
            $date_range = (isset($_GET['daterange']) && in_array(trim($_GET['daterange']), array('any', 'last_week', 'last_month', 'last_year', 'own_range')) ) ? trim($_GET['daterange']) : 'any';
            switch ($date_range) {
                case 'last_week':
                    add_filter( 'posts_where', 'filter_where_lastweek' );
                    break;
                case 'last_month':
                    add_filter( 'posts_where', 'filter_where_lastmonth' );
                    break;
                case 'last_year':
                    add_filter( 'posts_where', 'filter_where_lastyear' );
                    break;
                case 'own_range':
                    add_filter( 'posts_where', 'filter_where_ownrange' );
                    break;
                default:
                    // kein Filter
                    break;
            }

            $query_types = isset( $_GET['search_post_type']) ? wp_strip_all_tags($_GET['search_post_type']) : 'any';
            $query_types = in_array ($query_types, array ('any', 'produktbericht', 'news', 'termin', 'fachartikel', 'forschungsergebnis', 'bildergalerie', 'autor')) ? $query_types : 'any';

            // Don't include special pages
            $pagesToExclude = array(
                63,     // Abo-Login
                74,     // Firmen, no static/searchable content
                76,     // Firma, no static/searchable content
                78,     // Neue Firmen, no static/searchable content
                85,     // Abo-Formular
                134,    // Firmensuche, no static/searchable content
                142,    // Firmen-Login
                177,    // Newsletter-Error: Address not found
                180,    // Newsletter abmelden formular
                182,    // Newsletter-Message: Abmeldung erfolgreich
                185,    // Probeheft bestellen Formular (not linked atm)
                208,    // Stellenmarkt, no static/searchable content
                283,    // Themen, no static/searchable content
                12802,  // Download, no static/searchable content
                12849   // Einzelkauf, no static/searchable content
            );

            $mquery_args = array('post_type'=> array('post', 'termin', 'bildergalerie', 'hefte', 'forschung', 'autor', 'page'), 'caller_get_posts' => 1, 'orderby' => 'date','order' => 'DESC', 'post__not_in' => $pagesToExclude);

            if ($query_types != 'any') {
                if ($query_types === 'termin') {
                    $mquery_args['post_type'] = 'termin';
                } elseif ($query_types === 'bildergalerie') {
                    $mquery_args['post_type'] = 'bildergalerie';
                } elseif ($query_types === 'autor') {
                    $mquery_args['post_type'] = 'autor';
                } else {
                    $mquery_args['contenttype'] = $query_types;
                }
            }

            query_posts(array_merge( $wp_query->query, $mquery_args));

            // Filter für Datumsbereiche wieder entfernen...
            remove_filter( 'posts_where', 'filter_where_lastweek' );
            remove_filter( 'posts_where', 'filter_where_lastmonth' );
            remove_filter( 'posts_where', 'filter_where_lastyear' );
            remove_filter( 'posts_where', 'filter_where_ownrange' );
        ?>
        <?php $resultsCount = $wp_query->found_posts; ?>
            <h3 class="subheadline"><?php echo ($resultsCount == 1 ? $resultsCount . ' ' . __('Result', 'blhr-theme') : $resultsCount . ' ' . __('Results', 'blhr-theme')); ?></h3>
            <h1><?php echo str_replace('%1', get_search_query(), __('Search results for <strong>%1</strong>', 'blhr-theme')); ?></h1>
            <hr/>

            <form id="erweitertesuchbox" method="get" action="<?php echo home_url( '/' ); ?>" class="form-inline form-with-searchbox">
                <fieldset>
                    <input type="text" placeholder="<?php _e('Search...', 'blhr-theme'); ?>" value="<?php the_search_query(); ?>" name="s" id="firma-name" />
                    <input type="submit" class="input-submit" value="<?php _e('Search', 'blhr-theme'); ?>">
                </fieldset>

                <hr/>

                <fieldset class="post_types">
                    <div class="control-group">
                        <div class="col-xs-2">
                            <?php _e('Content type:', 'blhr-theme'); ?>
                        </div>
                        <div class="controls col-xs-10">
                            <label class="radio toggleNewsArea">
                                <input onchange="togglePostCategories();" type="radio" <?php if ('any' == $query_types) { echo 'checked="checked"'; } ?> value="any" name="search_post_type">
                                <?php _e('Any', 'blhr-theme'); ?>
                            </label>
                            <label class="radio toggleNewsArea">
                                <input onchange="togglePostCategories();" type="radio" <?php if ('news' == $query_types) { echo 'checked="checked"'; } ?> value="news" name="search_post_type">
                                <?php _e('News', 'blhr-theme'); ?>
                            </label>
                            <label class="radio toggleNewsArea">
                                <input onchange="togglePostCategories();" type="radio" <?php if ('termin' == $query_types) { echo 'checked="checked"'; } ?> value="termin" name="search_post_type">
                                <?php _e('Events', 'blhr-theme'); ?>
                            </label>
                            <label class="radio toggleNewsArea">
                                <input onchange="togglePostCategories();" type="radio" <?php if ('fachartikel' == $query_types) { echo 'checked="checked"'; } ?> value="fachartikel" name="search_post_type">
                                <?php _e('Article', 'blhr-theme'); ?>
                            </label>
                            <label class="radio toggleNewsArea">
                                <input onchange="togglePostCategories();" type="radio" <?php if ('produktbericht' == $query_types) { echo 'checked="checked"'; } ?> value="produktbericht" name="search_post_type">
                                <?php _e('Product Reviews', 'blhr-theme'); ?>
                            </label>
                            <label class="radio toggleNewsArea">
                                <input onchange="togglePostCategories();" type="radio" <?php if ('forschungsergebnis' == $query_types) { echo 'checked="checked"'; } ?> value="forschungsergebnis" name="search_post_type">
                                <?php _e('Research Results', 'blhr-theme'); ?>
                            </label>
                            <label class="radio toggleNewsArea">
                                <input onchange="togglePostCategories();" type="radio" <?php if ('bildergalerie' == $query_types) { echo 'checked="checked"'; } ?> value="bildergalerie" name="search_post_type">
                                <?php _e('Picture galleries', 'blhr-theme'); ?>
                            </label>
                            <label class="radio toggleNewsArea">
                                <input onchange="togglePostCategories();" type="radio" <?php if ('autor' == $query_types) { echo 'checked="checked"'; } ?> value="autor" name="search_post_type">
                                <?php _e('Authors', 'blhr-theme'); ?>
                            </label>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="post_types">
                    <hr />
                    <div class="col-xs-2">
                        <?php _e('Date:', 'blhr-theme'); ?>
                    </div>
                    <div class="control-group col-xs-10">
                        <div class="controls">
                            <label class="radio toggleRangeInput">
                                <input onchange="toggleRangeInput();" type="radio" <?php if ('any' == $date_range) { echo 'checked="checked"'; } ?> value="any" name="daterange">
                                <?php _e('Any', 'blhr-theme'); ?>
                            </label>
                            <label class="radio toggleRangeInput">
                                <input onchange="toggleRangeInput();" type="radio" <?php if ('last_week' == $date_range) { echo 'checked="checked"'; } ?> value="last_week" name="daterange">
                                <?php _e('Last week', 'blhr-theme'); ?>
                            </label>
                            <label class="radio toggleRangeInput">
                                <input onchange="toggleRangeInput();" type="radio" <?php if ('last_month' == $date_range) { echo 'checked="checked"'; } ?> value="last_month" name="daterange">
                                <?php _e('Last month', 'blhr-theme'); ?>
                            </label>
                            <label class="radio toggleRangeInput">
                                <input  onchange="toggleRangeInput();" type="radio" <?php if ('last_year' == $date_range) { echo 'checked="checked"'; } ?> value="last_year" name="daterange">
                                <?php _e('Last year', 'blhr-theme'); ?>
                            </label>
                            <label class="radio toggleRangeInput">
                                <input  onchange="toggleRangeInput();" type="radio" <?php if ('own_range' == $date_range) { echo 'checked="checked"'; } ?> value="own_range" name="daterange">
                                <?php _e('Specify date range', 'blhr-theme'); ?>
                            </label>
                        </div>

                        <div id="rangeinput" class="control-group" >
                            <?php $dateStart = isset ($_GET['dateStart']) ? wp_strip_all_tags ($_GET['dateStart']): '' ;?>
                            <?php $dateEnd = isset ($_GET['dateEnd']) ? wp_strip_all_tags ($_GET['dateEnd']): '' ;?>
                            <div class="controls">
                                <span class="help-inline" style="width:40px;"><?php _e('From:&nbsp;', 'blhr-theme'); ?></span> <input name="dateStart" type="text" value="<?php echo $dateStart; ?>" size="16" id="dateStart" class="span2" />
                            </div>
                            <div class="controls">
                                <span class="help-inline" style="width:40px;"><?php _e('To:&nbsp;', 'blhr-theme'); ?></span> <input name="dateEnd" type="text" value="<?php echo $dateEnd; ?>" size="16" id="dateEnd"  class="span2" />
                            </div>
                            <p class="help-block" style="font-size:11px;padding-left:50px;margin:0;"><?php _e('e.g. 15.2.2015', 'blhr-theme'); ?></p>
                        </div>
                    </div>
                </fieldset>

                <fieldset id="searchgroup_post_categories">
                    <hr />
                    <div class="col-xs-2">
                        <?php _e('Channel', 'blhr-theme'); ?>
                    </div>
                    <div class="control-group col-xs-10">
                        <div class="controls">
                            <?php
                            $mcategories = get_categories();
                            ?>
                            <?php
                            $query_cats = isset( $_GET['cat']) ? wp_strip_all_tags($_GET['cat']) : '' ;
                            $selected_cats = explode(",", $query_cats);
                            ?>
                            <?php foreach ($mcategories as $mcat): ?>
                                <?php if ($mcat->name !== 'Allgemein' && $mcat->parent == 0): ?>
                                    <label class="checkbox toggleRangeInput"><input <?php if (in_array($mcat->cat_ID ,$selected_cats) || $selected_cats[0] == '' ) { echo 'checked="checked"'; } ?> class="check_post_category"  onchange="updateCat();"  type="checkbox" value="<?php echo $mcat->cat_ID; ?>"><?php echo $mcat->name; ?></label>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <input id="extended_search_cat" type="hidden" name="cat" value="<?php echo $query_cats; ?>" />
                </fieldset>

                <hr style="clear:both"/>
            </form>
            <script type="text/javascript">
                // <![CDATA[
                togglePostCategories ();
                toggleRangeInput ();
                function togglePostCategories ()
                {

                    frm = document.forms["erweitertesuchbox"];
                    var vl = getCheckedValue(frm.elements["search_post_type"]);
                    if (vl == "news" || vl == "termin" || vl == "produktbericht" || vl == "fachartikel" || vl == "forschungsergebnis" || vl == "bildergalerie") {
                        document.getElementById("searchgroup_post_categories").style.display = "block";
                        updateCat();
                    } else {
                        document.getElementById('searchgroup_post_categories').style.display = 'none';
                    }
                    document.getElementById('extended_search_cat').value = '';
                }
                function toggleRangeInput ()
                {

                    frm = document.forms["erweitertesuchbox"];
                    var vl = getCheckedValue(frm.elements["daterange"]);
                    if (vl == "own_range")
                    {
                        document.getElementById("rangeinput").style.display = "block";
                        updateCat ();
                    }
                    else
                    {
                        document.getElementById('rangeinput').style.display = 'none';
                    }
                }

                function updateCat ()
                {
                    document.getElementById('extended_search_cat').value = getCheckedValuesByClass ('check_post_category');
                }

                function getCheckedValuesByClass (cl)
                {
                    var array = document.getElementsByTagName("input");
                    var vallist = "";

                    for(var ii = 0; ii < array.length; ii++)
                    {
                        if(array[ii].type == "checkbox" && array[ii].className == cl && array[ii].checked )
                            vallist += array[ii].value + ','
                    }
                    return vallist;
                }

                function getCheckedValue(radioObj) {
                    if(!radioObj)
                        return "";
                    var radioLength = radioObj.length;
                    if(radioLength == undefined)
                        if(radioObj.checked)
                            return radioObj.value;
                        else
                            return "";
                    for(var i = 0; i < radioLength; i++) {
                        if(radioObj[i].checked) {
                            return radioObj[i].value;
                        }
                    }
                    return "";
                }
                // ]]>
            </script>

            <?php if (have_posts()) : ?>

                <div class="content clearfix">
                    <ul class="clean">
                    <?php while (have_posts()) : the_post(); ?>
                        <li><?php get_template_part('content', 'search'); ?></li>
                    <?php endwhile; ?>
                    </ul>
                </div>

            <?php else: ?>
                <header class="post-title">
                    <h3><?php _e('No Results Found', 'blhr-theme'); ?></h3>
                </header>

                <p><?php _e('Sorry, there were no results for your query.', 'blhr-theme'); ?></p>
            <?php endif; ?>

            <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
        <?php get_template_part('inc/main-columns-post'); ?>
    </div>
</div>
<?php ht_debug_theme_file_end(__FILE__); ?>
<?php get_footer(); ?>
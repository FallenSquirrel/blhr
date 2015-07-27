<?php

class Teamspeak_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'teamspeak_widget', // Base ID
            'Teamspeak' // Name
        );
    }

    function widget( $args, $instance ) {
        extract($args);

        echo $before_widget; ?>
        <?php ht_debug_theme_file_start(__FILE__); ?>

        <div class="widget frame-headline" id="widget-teamspeak">
            <h3 class="widget-title">TeamSpeak</h3>
        </div>

        <div class="widget-content frame-body">
            <div class="teamspeak-container" id="ts3viewer_1042667">
            </div>
            <script type="text/javascript" src="http://static.tsviewer.com/short_expire/js/ts3viewer_loader.js">
            </script><script type="text/javascript">
                //<![CDATA[
                var ts3v_url_1 = "http://www.tsviewer.com/ts3viewer.php?ID=1042667&text=cccfd1&text_size=10&text_family=1&js=1&text_s_weight=bold&text_s_style=normal&text_s_variant=normal&text_s_decoration=none&text_s_color_h=525284&text_s_weight_h=bold&text_s_style_h=normal&text_s_variant_h=normal&text_s_decoration_h=underline&text_i_weight=normal&text_i_style=normal&text_i_variant=normal&text_i_decoration=none&text_i_color_h=525284&text_i_weight_h=normal&text_i_style_h=normal&text_i_variant_h=normal&text_i_decoration_h=underline&text_c_weight=normal&text_c_style=normal&text_c_variant=normal&text_c_decoration=none&text_c_color_h=525284&text_c_weight_h=normal&text_c_style_h=normal&text_c_variant_h=normal&text_c_decoration_h=underline&text_u_weight=bold&text_u_style=normal&text_u_variant=normal&text_u_decoration=none&text_u_color_h=525284&text_u_weight_h=bold&text_u_style_h=normal&text_u_variant_h=normal&text_u_decoration_h=none";
                ts3v_display.init(ts3v_url_1, 1042667, 100);
                //]]>
            </script>
        </div>

        <?php ht_debug_theme_file_end(__FILE__); ?>
        <?php echo $after_widget;
    }
}
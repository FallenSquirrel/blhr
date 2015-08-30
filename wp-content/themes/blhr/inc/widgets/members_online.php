<?php

class Members_Online_Widget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            'members_online_widget', // Base ID
            'Members Online' // Name
        );
    }

    public function widget($args, $instance)
    {
        extract($args);

        echo $before_widget; ?>
        <?php ht_debug_theme_file_start(__FILE__); ?>

        <div class="widget frame-headline">
            <h3 class="widget-title">Mitglieder online</h3>
        </div>

        <div class="widget-content frame-body widget-members-online">
            <div id="opStatusDiv">
                <input id="opOutfitID" type="hidden" value="37510799078459750" />
            </div>
            <script src="http://outfitpoints.com/widgets/onlinestatus.js" type="text/javascript">
            </script>
        </div>

        <?php ht_debug_theme_file_end(__FILE__); ?>
        <?php echo $after_widget;
    }
}
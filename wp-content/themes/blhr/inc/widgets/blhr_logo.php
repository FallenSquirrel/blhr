<?php

class BLHR_Logo_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'blhr_logo_widget', // Base ID
            'BLHR Logo' // Name
        );
    }

    public function widget( $args, $instance ) {
        extract($args);

        echo $before_widget; ?>
        <?php ht_debug_theme_file_start(__FILE__); ?>

        <div class="widget frame-headline">
        </div>

        <div class="widget-content frame-body widget-logo">
            <img src="<?php
                $mode = $instance['mode'];
                if ($mode == 3) {
                    $mode = rand(0, 2);
                }
                switch($mode) {
                    case 1:
                        echo get_stylesheet_directory_uri() . '/img/logo/HornetsDecal_red_notext_300x300.png';
                        break;
                    case 2:
                        echo get_stylesheet_directory_uri() . '/img/logo/HornetsDecal_purple_notext_300x300.png';
                        break;
                    default:
                        echo get_stylesheet_directory_uri() . '/img/logo/HornetsDecal_blue_notext_300x300.png';
                        break;
                }
            ?>" />
        </div>

        <?php ht_debug_theme_file_end(__FILE__); ?>
        <?php echo $after_widget;
    }

    public function form($instance) {
        $mode = ! empty( $instance['mode'] ) ? $instance['mode'] : 0;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'mode' ); ?>">Zu zeigendes Logo:</label>
            <select id="<?php echo $this->get_field_id( 'mode' ); ?>" name="<?php echo $this->get_field_name( 'mode' ); ?>">
                <option value="0" <?php if ($mode==0) echo 'selected' ?>>Blue Hornets Logo</option>
                <option value="1" <?php if ($mode==1) echo 'selected' ?>>Red Hornet Logo</option>
                <option value="2" <?php if ($mode==2) echo 'selected' ?>>Spandex Hornets Logo</option>
                <option value="3" <?php if ($mode==3) echo 'selected' ?>>Bei jedem Seitenaufruf zufällig bestimmen</option>
            </select>
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
}
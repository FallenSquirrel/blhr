<?php ht_debug_theme_file_start(__FILE__); ?>
<div class="abohint p10px mt20px mb20px">
    <div id="loginRegisterAdvice">
        <div class="iconContainer">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon-flag-down.png" />
            <i class="icon fa fa-lock"></i>
        </div>
        <h3><?php _e('Subscribers only', 'blhr-theme'); ?></h3>
        <?php
        echo str_replace('%login_link_pre%', '<a href="' . add_query_arg( 'redirect_to', urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"), el_get_login_page () ) . '" class="colored">',
            str_replace('%login_link_post%', '</a>',
                str_replace('%abo_link_pre%', '<a href="' . el_get_abobestellen_page() . '" class="colored">',
                    str_replace('%abo_link_post%', '</a>',
                        __('Only subscribers to the <strong>KGK</strong> magazine can see the full content. Please %login_link_pre%log in%login_link_post% or %abo_link_pre%subscribe%abo_link_post% to our magazine to continue.', 'blhr-theme')))));
        ?>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-6 already-subscriber">
            <h4>LOGIN</h4>
            <p class="already-subscriber-text"><?php _e('You are already a subscriber?', 'blhr-theme'); ?><br />
            <?php _e('Log in here:', 'blhr-theme'); ?></p>
            <?php
                $form = wp_login_form( array('label_log_in' => 'Login', 'remember' => true ,  'echo' => false) );
                $form = str_replace('class="button-primary"', 'class="btn"', $form);
                $form = str_replace('id="user_login"', 'id="user_login" placeholder="' . __('Subscription number', 'blhr-theme') . '"', $form);
                $form = str_replace('id="user_pass"', 'id="user_pass" placeholder="' . __('Postal code', 'blhr-theme') . '"', $form);
                echo '<div id="form-abo-login">'.$form.'</div>';
            ?>
        </div>
        <div class="col-xs-6 no-subscriber" style="border-left:4px solid #cbd2d8;">
            <div class="content-indent pb1em">
                <h4><?php _e('You are not subscribed yet?', 'blhr-theme'); ?></h4>
                <p class="no-subscriber-text"><?php _e('As a subscriber to the <strong>KGK</strong> magazine you have access to all contents of the portal kgk-rubberpoint.de', 'blhr-theme'); ?></p>
                <div class="text-center">
                    <a class="btn bigpad" href="<?php echo el_get_abobestellen_page ();?>"><strong><?php _e('Subscribe now', 'blhr-theme'); ?></strong></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ht_debug_theme_file_end(__FILE__); ?>
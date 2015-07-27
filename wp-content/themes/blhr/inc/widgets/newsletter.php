<?php

class ht_Newsletter_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'ht_newsletter_widget', // Base ID
            'Newsletter' // Name
        );
    }

    function widget( $args, $instance ) {
        global $pagename;
        if($pagename != 'newsletter') {
            extract($args);

            echo $before_widget;
            ?>
            <?php ht_debug_theme_file_start(__FILE__); ?>
            <div class="widget-newsletter">
                <h4 class="widget-title newsletter">
                    Newsletter
                </h4>
                <div class="widget-content clearfix">
                    <div class="row">
                        <div class="col-md-3">
                            <i class="fa fa-envelope-o envelope"></i>
                        </div>
                        <div class="col-md-9">
                            <?php _e('The latest news from <strong>KGK</strong>', 'blhr-theme'); ?><br />
                            <?php _e('sent directly to you', 'blhr-theme'); ?>
                        </div>
                    </div>

                </div>
                <div class="footer">
                    <form method="post" id="newsletter-anmeldung" class="form-inline" action="/newsletter/">
                        <input type="hidden" name="filled_in_form" value="2"/>
                        <input type="hidden" name="filled_in_start" value="1436176330"/>
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" id="newsletter-email" class="textfield full" placeholder="<?php _e('Email address', 'blhr-theme'); ?>" name="newsletter-email" />
                            </div>
                            <div class="col-md-4">
                                <input type="submit" class="btn full" value="<?php _e('Subscribe', 'blhr-theme'); ?>" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php ht_debug_theme_file_end(__FILE__); ?>
            <?php echo $after_widget;
        }
    }
}
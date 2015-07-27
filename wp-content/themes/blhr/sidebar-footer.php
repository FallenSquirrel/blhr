<?php
/**
 * The Sidebar for Footer.
 *
 * @author Nina Taberski-Besserdich (nina.taberski@besserdich.com)
 * @package WordPress
 * @subpackage BIC Bootstrap Wordpress Theme
 */
?>


<?php ht_debug_theme_file_start(__FILE__); ?>
<div class="row footer">
    <div class="col-md-6">
        <div class="clearfix">
            <div class="col-md-6">
                <?php
                if (function_exists('dynamic_sidebar')) {
                    dynamic_sidebar("footer-column-1");
                }
                ?>
            </div>
            <div class="col-md-6">
                <?php
                if (function_exists('dynamic_sidebar')) {
                    dynamic_sidebar("footer-column-2");
                }
                ?>
            </div>
        </div>
        <div class="col-xs-12 clearfix" id="huethig-logo">
            <a href="http://www.huethig.de">
                <img src="<?php echo get_template_directory_uri();?>/img/logo/huethig.png" alt="Hüthig Verlag" width="200" />
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-6">
            <?php
            if (function_exists('dynamic_sidebar')) {
                dynamic_sidebar("footer-column-3");
            }
            ?>
        </div>
        <div class="col-md-6">
            <?php
            if (function_exists('dynamic_sidebar')) {
                dynamic_sidebar("footer-column-4");
            }
            ?>
        </div>
    </div>
</div>
<?php ht_debug_theme_file_end(__FILE__); ?>
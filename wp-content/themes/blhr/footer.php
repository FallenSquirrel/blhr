<?php ht_debug_theme_file_start(__FILE__); ?>
            <div class="container">
                <footer id="site-footer">
                    <div class="col-md-4">
                        <div class="footer-left">
                            &copy; BLHR <?php echo date('Y'); ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <nav class="footer-right">
                            <?php wp_nav_menu( array( 'container' => '', 'container_class' => '', 'depth' => 1, 'theme_location' => 'footer' ) ); ?>
                        </nav>
                    </div>
                </footer>
            </div>
        </div>
    </div><!-- /#main-part-center -->
<?php wp_footer(); ?>

<?php ht_debug_theme_file_end(__FILE__); ?>
</body>
</html>

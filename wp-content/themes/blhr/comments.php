<?php
/**
 * Template for displaying Comments.
 *
 * Display comments and comment form. 
 * The display of comments is handled by a callback to bootstrapwp_comment() in the functions.php file.
 * 
 * @author Nina Taberski-Besserdich (nina.taberski@besserdich.com)
 * @package WordPress
 * @subpackage BIC Bootstrap Wordpress Theme
 */

ht_debug_theme_file_start(__FILE__);

if (post_password_required()) {
    return;
} ?>



<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>

        <ul class="media-list">
            <?php wp_list_comments(array('callback' => 'bootstrapwp_comment')); ?>
        </ul>
    
    

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
    
            <nav id="comment-nav-below" class="navigation" role="navigation">
    
                <div class="nav-previous">
                    <?php previous_comments_link( _e('&larr; Older Comments', 'blhr-theme')); ?>
                </div>
                
                <div class="nav-next">
                    <?php next_comments_link(_e('Newer Comments &rarr;', 'blhr-theme')); ?>
                </div>
                
            </nav>
    
        <?php endif;  ?>

    

    <?php elseif (!comments_open() && '0' != get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
    
            <p class="nocomments"><?php _e('Comments are closed.', 'blhr-theme'); ?></p>
            
    <?php endif; ?>

    <?php comment_form(); ?>
            
            
</div>
<?php ht_debug_theme_file_end(__FILE__); ?>
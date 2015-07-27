<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php get_header(); ?>
<?php ht_debug_theme_file_start(__FILE__); ?>


     <div class="container main">
         
         
         
         
     <div class="row">
         
        <div class="col-md-12">
            
            <?php
            if (function_exists('bootstrapwp_breadcrumbs')) {
                
                bootstrapwp_breadcrumbs();
                
            }
            ?>
            
        </div><!--/.col -->
         
    </div><!--/.row -->
    
    
    
    
    
    <div class="row main-top">
        
        <div class="col-lg-9 col-md-9 col-sm-9 col-9">

            <header>
                       
                <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
            
            </header>

        </div><!--/.col -->
  
    </div><!--/.row -->
    
    
    
     <div class="row main-content">
         
                <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                    
                    <div class="content main">

                   <header class="page-title">
                                        <h1><?php _e('This is Embarrassing', 'blhr-theme'); ?></h1>
                                    </header>

                                    <p class="lead"><?php _e(
                                        'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.',
                                        'blhr-theme'
                                    ); ?></p>

                                   <div class="well">
                                       <?php get_search_form(); ?>
                                   </div>

                        <?php the_widget('WP_Widget_Recent_Posts'); ?>

                   <h2><?php _e('Categories', 'blhr-theme'); ?></h2>
                   <ul>
                       <?php wp_list_categories(
                       array(
                           'orderby' => 'count',
                           'order' => 'DESC',
                           'show_count' => 1,
                           'title_li' => '',
                           'number' => 100
                       )
                   ); ?>
                   </ul>

                    </div> <!-- /.content -->
                    
                </div> <!-- /.col -->
           

          
           
        <div class="col-lg-3 col-md-3 col-sm-3 col-3 sidebar-wrapper"> 
            
            <?php get_sidebar('page'); ?>

        </div><!--/.col -->
    
     </div> <!--/.row -->
        
        
        
        
         
        
    </div><!-- container -->



<?php ht_debug_theme_file_end(__FILE__); ?>
<?php get_footer(); ?>
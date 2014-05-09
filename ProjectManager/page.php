<?php
/**
 * Project Manager
 */

//get template header
get_header();
require_once ( 'includes/body-top.php' );

//start post loop
if (have_posts()) : while (have_posts()) : the_post(); ?>

    <header id="page-heading">
        <h1><?php the_title(); ?></h1>		
    </header><!-- /page-heading -->
    
    <article id="post" class="clearfix">
        <div class="entry clearfix">	
            <?php the_content(); ?>
        </div><!-- /entry -->       
    </article><!-- /post -->
    
	<?php
	//show comments if not disabled
	if($it_data['show_hide_page_comments'] !='disable') { comments_template(); } ?>
    
<?php
//end post loop
endwhile; endif;

//get sidebar template
get_sidebar('pages');

//get footer template
get_footer(); ?>
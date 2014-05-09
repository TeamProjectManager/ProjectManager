<?php
/**
 * Project Manager
 * Template Name: Página Vazia
 */

//get template header
get_header();

//start page loop
if (have_posts()) : while (have_posts()) : the_post();
$pagetitle=get_the_title();
require_once ( 'includes/body-top.php' );

?>

<div id="page-heading">
    <h1><?php the_title(); ?></h1>	
</div><!-- /page-heading -->

<div id="full-width" class="clearfix">

	<article class="entry clearfix">
		<?php the_content(); ?>
	</article><!-- /entry --> 
    
	<?php
	//show comments if not disabled
	if($it_data['show_hide_page_comments'] !='disable') { comments_template(); } ?>
     
</div><!-- /full-width -->

<?php
//end post loop
endwhile; endif;

//get template footer
get_footer(); ?>
<?php
/**
 * ProjectManager
 * Template Name: Calendário
 */


//get template header
get_header();
$pagetitle="Calendário";
require_once ( 'includes/body-top.php' );

//start page loop
if (have_posts()) : while (have_posts()) : the_post();

?>

<div id="page-heading">
    <h1><?php the_title(); ?></h1>	
</div><!-- /page-heading -->

<div id="full-width" class="clearfix">

	<article class="entry clearfix margintop20">
		<?php the_content(); ?>
		
		
							
<style>
tr{
height:90px;
}
td{
width:130px;
}
#wp-calendar caption {
font-size: 23px;
border-top: 0px;
background: #d9edf7;
color: #357ebd;
border-bottom: 5px solid #357ebd;
}
thead{
background: #f8f8f8;
}
</style>		

		<?php

		$post_types = '';

			
			if (isset($user_role) && ($user_role != "client")){

				 projectpress_get_calendar( array ($post_types => 'todos' ), ''); 
//				 projectpress_get_calendar( $post_types, ''); 
			    
			} elseif (isset($user_role) && ($user_role == "client")) {

				 projectpress_get_calendar( array ($post_types => 'projects_cpt'), ''.$current_user_username.''); 
		 
		 	}
		 
		?>


		
	</article><!-- /entry --> 
         
</div><!-- /full-width -->

<?php
//end post loop
endwhile; endif;

//get template footer
get_footer(); ?>
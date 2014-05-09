<?php
 /**
 * ProjectManager
 * Template Name: Minhas Tarefas
 */
 
//get global variables
global $it_data;

//get template header
get_header();
$pagetitle = $it_data['user_my_tasks_title']; 
if ($pagetitle == '') { $pagetitle="My Tasks"; }
require_once ( 'includes/body-top.php' );

//start page loop
if (have_posts()) : while (have_posts()) : the_post();

//posts per page
$template_posts_per_page = get_post_meta($post->ID, 'it_template_posts_per_page', true);

//get post status
$post_status_shown = 'publish';
$post_status_shown = get_post_meta($post->ID, 'it_post_status_shown', true);

//only showing complete?
$completedcourses1 = 'NOT EXISTS';
$completedcourses2 = 'NOT LIKE';
$completedcourses = get_post_meta($post->ID, 'it_show_project_complete', true);
if ($completedcourses == 'yes') { 
$completedcourses1 = 'EXISTS'; 
$completedcourses2 = 'LIKE'; 
} else { 
$completedcourses1 = 'NOT EXISTS'; 
$completedcourses2 = 'NOT LIKE'; 
}

//grid style
//$projects_cpt_grid_style = get_post_meta($post->ID, 'it_grid_style', true); //get grid style meta
//$projects_cpt_grid_class = it_grid($projects_cpt_grid_style); //set grid style

//get meta to set parent category
$projects_cpt_parent = get_post_meta($post->ID, 'it_projects_cpt_parent', true); //get parent post type
$projects_cpt_filter_parent = ''; //declare parent post type variable
($projects_cpt_parent != 'select_projects_cpt_cats_parent') ? $projects_cpt_filter_parent = $projects_cpt_parent : $projects_cpt_filter_parent = NULL;

//show page content if not empty
$content = $post->post_content;
if(!empty($content)) { ?>
	<div id="portfolio-description" class="clearfix">
		<?php the_content(); ?>
	</div><!-- /projects-description -->
<?php }

//end page loop
endwhile; endif;

wp_reset_query();
 ?>

<div id="portfolio-template">
    <div id="portfolio-wrap clearfix">
    	
    	<div class="deadlinediv"><span class="deadlinespan">Filtrado por prazos</span></div>
    	
    	<div id="portfolio-wrap">
    	<?php
    			
    		if (isset($user_role) && ($user_role != "$clientword")){
			
					$args = array(
					    'orderly' => 'title',
					    'show_posts' => '-1', 
					    	    'posts_per_page' => '-1', 
					    'order' => 'ASC',
					    'post_type' => 'todos',
					    'meta_query' => array(
					        array(
					            'key' => 'it_todo_assigned',
					            'value' => $current_user_id,
					            'compare' => '='
					        )
					    )
					);
			
			   }
			   
			   	if (isset($user_role) && ($user_role == "$clientword")){
					
					$args = array(
					    'orderly' => 'title',
					    'show_posts' => '-1', 
					    	    'posts_per_page' => '-1', 
					    'order' => 'ASC',
					    'post_type' => 'todos',
					    'post_status' => 'publish',
					    'meta_query' => array(
					        array(
					            'key' => 'it_todo_assigned',
					            'value' => $current_user_id,
					            'compare' => '='
					        )
					    )
					);
			
				}
			
			
					$wp_query_assigned = new WP_Query($args); 
			
			           if ( $wp_query_assigned->have_posts() ) :
			
						echo '<ul class="portfolio-content" id="">';
						
			            while ($wp_query_assigned->have_posts()) : $wp_query_assigned->the_post();
			            
			            $posttags = get_the_tags();
							if ($posttags) {
								foreach($posttags as $tag) {
									$postbytag = $tag->name . ''; 
								}
						}
			           
			           $proj_title = get_the_title( $postbytag );      
			           $proj_link = get_permalink( $postbytag );
			           $permalink = get_permalink( );
			           
			           
			        	//PROJECT TODO VARIABLES
			        	$tododeadline = get_post_meta($post->ID, 'it_todo_deadline', true);
						$newtododeadline2 = date("F j, Y", strtotime($tododeadline));

					   echo '<li class="portfolio-post grid-3 " id="taskli">
					   <div id="taskdiv">
					   
					   <span class="marginleft0">
					   <a id="tasksel" href="'; echo get_delete_post_link( get_the_ID() ); echo '" class="tasksel1">
					   	<button id="taskbtn" class="button checkbox mytaskbtn paddingleft1"></button> 
					   </a>
					   </span>
					   
					   <span id="taskitem">
					   		
					   		<a class="fontsize20 taskadj3" href="'.$permalink.'"><h2 class="margintop0 marginbottom0 ">'; the_title(); echo '</h2></a>
					   		<a href="'.$proj_link.'" class="projlink1 hiddenphone"><em>'.$proj_title.'</em></a>
					   		
					   	</span>
					   
					   <span class="floatright hiddenphone"><h2 class="margintop15down datadel"><icon class="icon-calendar margintop4down"></icon> 
					   	'.$newtododeadline2.'</h2>
					   </span>
					   
					   </div>';
						
			
						
						?>
						
						</li>
						
						<?php endwhile; ?>
						
			            </ul>
			                
			            <?php else : ?>
			                
			            <p>Você não tem tarefas atribuídas no momento.</p>
			                
			            <?php endif; ?>
			
		</div>
		
        <?php
		//show pagination
        pagination();
		//reset the custom query
		wp_reset_query(); ?>
    </div><!-- /projects-wrap -->
</div><!-- /projects-template -->

<?php

//get template footer
get_footer(); ?>
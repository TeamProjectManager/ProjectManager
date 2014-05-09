<?php
/**
 * Project Manager
 */
 
//get global variables
global $it_data;


if ( ( is_single() || is_front_page() || is_page() ) 
       && !is_page('login') && !is_user_logged_in()){ 
    auth_redirect(); 
} 

//get template header
get_header(); 
$pagetitle = get_bloginfo( 'name' );
require_once ( 'includes/body-top.php' );

?>

<div id="home-wrap" class="clearfix">


	<!-- HOMEPAGE TAGLINE -->

		<?php if($it_data['homepage_tagline']) { ?>
				<?php if(!empty($it_data['homepage_tagline_title'])) { 
					if(!empty($it_data['homepage_tagline_title_url'])) { ?>
						<h2 class="heading"><a href="<?php echo $it_data['homepage_tagline_title_url']; ?>" title="<?php echo $it_data['homepage_tagline_title']; ?>"><span><?php echo $it_data['homepage_tagline_title']; ?></span></a></h2>
					<?php } else { ?>
						<h2 class="heading"><span><?php echo $it_data['homepage_tagline_title']; ?></span></h2>
					<?php } } ?>
				<div id="" class="home-tagline margintop0">
					<?php echo stripslashes(do_shortcode($it_data['homepage_tagline'])); ?>
				</div>
				<!-- /home-tagline -->
				<?php } ?>
			


	<div class="bs-callout bs-callout-info margintop0 dateBar animated fadeInUp"> 
		<h4>Data: <?php echo $today; ?></h4>
	</div>


<div id="bottom-content" class="">
	<article id="post" class="clearfix">
		<div class="row">

			<!-- DISCUSSION AND WIDGET -->
			<div class="discussion col-md-6">

				<?php if (isset($isclient) && ($isclient != true)){ ?>
			
				<div class="well animated flipInY"> 
					<h2 class="alert-title margintop0">Meu Painel</h2>
			  
					<div class="dashstats">
			  
						<?php
			            $numassigned = $i;
			
						//only showing complete?
						$completedcourses1 = 'NOT EXISTS'; 
						$completedcourses2 = 'NOT LIKE'; 
						
			           //get post type ==> projects_cpt
			            query_posts(
							array(
								'post_type'=>'projects_cpt',
								'posts_per_page' => -1,
			                    'post_status'=> 'publish',
								'paged'=>$paged,
								    'meta_query' => array(
								    'relation' => 'OR',
								        array(
								            'key' => 'it_show_project_complete',
								            'value' => 'yes',
								            'compare' => $completedcourses1
								        ),
								        array(
								            'key' => 'it_show_project_complete',
								            'value' => 'yes',
								            'compare' => $completedcourses2					        
								        )
			                        )
			            	)
						);
						
						
						//start loop
			            while (have_posts()) : the_post();
							global $it_data, $it_counter, $projects_cpt_grid_class;
							$it_counter++;
						endwhile; 
						
			
								$count_posts = wp_count_posts('projects_cpt');
								$published_posts = $count_posts->publish;
			 
			 					if (isset($published_posts) && ($published_posts == '')) { $published_posts = 'No'; }
			 
								// TOTTAL PROJECTS
								echo '<span class="indexcounters"><strong>'; echo $it_counter;
								echo '</strong></span><span> Projetos Ativos</span><br/>';
			
								echo '<span class="indexcounters"><strong>';if (($numassigned < '10') && ($numassigned === '0')) {
								
								echo '0';
								
								} 
								
								if (isset($numassigned) && ($numassigned == '0')) { $numassigned = 'No'; }
								if (!isset($numassigned)) { $numassigned = 'No'; }
								
								echo ''. $numassigned. '</strong></span>
								<span> Projetos Atribuidos</span><br/>';
			
								$result = count_users();
													
								echo '<span class="indexcounters"><strong>';if (($result['total_users'] < '10') && ($result['total_users'] === '0')) {
								
								echo '0';
								
								} echo ''. $result['total_users']. '</strong></span>
								<span>Membros de equipe</span><br/>';
								
								?> 
					</div>
				 </div>
			 				

			 
			 				<?php } ?>
			
			
			
			
			<div class="bs-callout bs-callout-info margintop0 animated flipInX">
	
			<h4 class="heading assignedprojects">
				<span class="paddingleft0"><i class="icon-flag margintop5down"></i> Seus Projetos Atribuídos</span>
			</h4>
			 
			<?php
			   if (isset($user_role) && ($user_role != "$clientword")){
			
				   $curuser = ':"';
				   $curuser .= $current_user_id;
				   $curuser .= '";';
					
					$args = array(
					    'orderly' => 'title',
					    'order' => 'ASC',
					    'show_posts' => '-1', 
					    'posts_per_page' => '-1', 
					    'post_type' => 'projects_cpt',
					    'meta_query' => array(
					        array(
					            'key' => 'it_projects_assigned',
					            'value' => $curuser,
					            'compare' => 'LIKE'
					        )
					    )
					);
			
			   }
			   
			   	if (isset($user_role) && ($user_role == "$clientword")){
					
					$args = array(
					    'orderly' => 'title',
					    'order' => 'ASC',
					    'show_posts' => '-1', 
					    	    'posts_per_page' => '-1', 
					    'post_type' => 'projects_cpt',
					    'meta_query' => array(
					        array(
					            'key' => 'it_projects_client',
					            'value' => $current_user_username,
					            'compare' => 'LIKE'
					        )
					    )
					);
			
			
				}
				
				$wp_query_assigned = new WP_Query($args); 
			
			           if ( $wp_query_assigned->have_posts() ) :
			
						echo '<ul class="plainlist">';
						$i = 0;
						
			            while ($wp_query_assigned->have_posts()) : $wp_query_assigned->the_post();
			
						echo '<li><a href="'; the_permalink(); echo '">'; the_title(); echo '</a></li>';
			
						$i++;
						
						endwhile; ?>
						
			            </ul>
			                
			            <?php else : ?>
			                
			            <p>You have no assigned projects.</p>
			                
			            <?php endif; ?>

			 				
	
			
			</div><!-- END DISCUSSION -->
			




		 
			<div class="bs-callout bs-callout-info margintop0 animated flipInY">
			<h4 class="heading assignedtasks margintop0">
				<span class="paddingleft0"><i class="icon-tasks margintop5down"></i> Suas Tarefas Atribuídas</span>
			</h4>
			
			
			<?php
			wp_reset_query();
			
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
			
						echo '<ul class="plainlist">';
						
			            while ($wp_query_assigned->have_posts()) : $wp_query_assigned->the_post();
			            
			            $posttags = get_the_tags();
							if ($posttags) {
								foreach($posttags as $tag) {
									$postbytag = $tag->name . ''; 
								}
						}
			                 
			           $permalink = get_permalink( $postbytag ); 
						
						echo '<li><a href="'.$permalink.'">'; the_title(); echo '</a>';
						
			
						
						?>
						
						</li>
						
						<?php endwhile; ?>
						
			            </ul>
			                
			            <?php else : ?>
			                
			            <p>No momento não há tarefas atribuídas à você.</p>
			                
			            <?php endif; ?>

			
			</div>
			
			
	
				</div>

	
	
			 
			 <div class="col-md-6">
	
	
		<!-- ANNOUNCEMENTS -->

		<?php 
		$hidden = '';
		
		if (isset($isclient) && ($isclient == true)){ 
			if ( (isset($tz_options['show_client_announcements'])) && ($tz_options['show_client_announcements'] == '1' )) { 
		
			} else {
			$hidden = '1';
			} 
		
		} ?>
		
		<?php if (isset($hidden) && ($hidden != '1')) { ?>
		
		 <!-- BLOG AREA --> 
		  <div id="" class="bs-callout bs-callout-warning margintop0 animated flipInX">
		
			  	<h4 class="heading announcements margintop0">
			  		<span class="paddingleft0"><i class="icon-bullhorn margintop5down"></i> Blog Team ProjectManager</span>
			  	</h4>
					

				<div class="row">
		
		<?php  $wp_query_news = new WP_Query( array( 'posts_per_page' => 1 ) ); ?>
		
		<?php // If there are no posts to display, such as an empty archive page  ?>
		<?php if ( ! $wp_query_news->have_posts() ) : ?>
			<div class="alert">
		 	 <strong>Sorry!</strong> You don't have any posts.
			</div>
		<?php endif; ?>
		
		
					<!--BEGIN #home-3-sections-->
			 		<div id="home-sections" class="clearfix col-md-12">
		
					<?php while ( $wp_query_news->have_posts() ) : $wp_query_news->the_post(); ?>
		
					<div class="dashann">
		
					<?php $authoremail = get_the_author_meta( 'user_email' ); ?>
		
						<div id="" class="dashann-pic">
							<?php
							$authpic = get_avatar( $authoremail, 37 );
							//$avatar = get_avatar( $userid, 200 );
				   			echo $authpic;
				   			?>
				   		</div>
		
		
				<div class="dashann-title">
					
		    		<h2 class="post-title marginbottom4 margintop0">
		    		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tz' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		    		</h2>
		 
		         <div class="post-meta marginbottom0">
		
		            <?php printf( __( '<span class="author">por %1$s</span><span class="published"> em %2$s</span>', 'tz' ),
		                    sprintf( '<a class="url fn n" href="%1$s" title="%2$s">%3$s</a>',
		                        get_author_posts_url( get_the_author_meta( 'ID' ) ),
		                        sprintf( esc_attr__( 'View all posts by %s', 'tz' ), get_the_author() ),
		                        get_the_author()
		                    ),
		                    sprintf( '<abbr class="published-time" title="%1$s">%2$s</abbr>',
		                        esc_attr( get_the_time() ),
		                        get_the_date()
		                    )
		                ); ?>
		            
		        </div>
		        
		        <!-- END title and meta -->
		        </div>
		        
		        <div class="clearfix"></div>
		        
		         <div class="post-text">
		            <?php the_excerpt(); 
			            // the_content();
		            ?> <a href="<?php the_permalink(); ?>">Ler Mais &rarr;</a>
		        </div>
		
		
		        
		    <!--END .post-->
		    </div>
		
		<?php endwhile; // End the loop ?>
				<!--END #home-3-sections-->
				</div>	  
		
		
		
		
				</div>
		
			</div>
		 
		<?php } ?>
		
		
				<div class="bs-callout bs-callout-info margintop0 animated flipInY">

			<h4 class="heading recentdiscussions">
				<span class="paddingleft0"><i class="icon-comment margintop5down"></i> Comentários Recentes</span>
			</h4>
			
			 <?php 

			   if (isset($user_role) && ($user_role != "$clientword")){
				   $activity = $wpdb->get_results( "SELECT *
				    FROM $wpdb->comments, $wpdb->posts
				    WHERE $wpdb->comments.comment_post_ID = $wpdb->posts.ID
				    AND $wpdb->posts.post_status = 'publish'
				    AND $wpdb->comments.comment_approved = '1'
				    ORDER BY $wpdb->posts.post_date DESC
				    LIMIT 5", ARRAY_N );
			   }
			   
			   	if (isset($user_role) && ($user_role == "$clientword")){
				    $activity = $wpdb->get_results( "SELECT *
				    FROM $wpdb->comments
				    JOIN $wpdb->posts ON $wpdb->comments.comment_post_ID = $wpdb->posts.ID
				    JOIN $wpdb->postmeta ON $wpdb->comments.comment_post_ID = $wpdb->postmeta.post_ID
				    AND $wpdb->posts.post_status = 'publish'
				    AND $wpdb->comments.comment_approved = '1'
				    AND $wpdb->postmeta.meta_value = '$current_user_username'
				    ORDER BY $wpdb->posts.post_date DESC
				    LIMIT 5", ARRAY_N );
				} 
			 
			  if ( $activity ) {
			    foreach ( (array) $activity as $item ) {
			    
			    $link = get_permalink( $item[15] );
			    $proj_title = get_the_title( $item[15] );
			    $auth_email = $item[3];
			
					//get avatar
					if ($use_user_avatar == 'enable') {
						$avatar = get_wp_user_avatar( $item[15], 171 );
					} else {
						$avatar = get_avatar( $item[3], 171 );
					}
								
					$authpic2 = get_avatar( $auth_email, 30 );
			    
					$comments[] = $item[0];
					echo '<div class="discussion-post">
							<div class="discussion-pic">'; 
								echo $authpic2; 
							echo '</div>
							<span><strong>';  echo $item[2]; echo '</strong></span> 
							comentou em <a href="'.$link.'">'; echo $proj_title; echo '</a>';
			      	echo '</div>';
			    			    
			    }
			  } else {
			    $comments = array();
			  }
			 
			
			?>
			

			</div>
					
	
 			 

			 </div><!-- END COLUMN -->
			
			
			
				
			
			
		</div><!-- / END ROW -->


		<div class="clearfix"></div>
		<br/>








</div> 
</article>




</div>
<!-- END home-wrap -->   
<?php
//get template footer
get_footer(); ?>
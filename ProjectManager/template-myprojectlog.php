<?php
/**
 * IcarusThemes
 * Template Name: Log dos projetos
 */
 
//get global variables
global $it_data;
$added = false;

//get template header
get_header();
$pagetitle = $it_data['user_my_log_title']; 
if ($pagetitle == '') { $pagetitle="My Project Log"; }
require_once ( 'includes/body-top.php' );


$demo = false;

if ($demo == true){ } else {
	
	if(isset($_POST['timelogsubmitted'])){
	
	$timelogpostTitleError = '';
	
	if(isset($_POST['timelogsubmitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
	
	
		if(trim($_POST['timelogspostTitle']) === '') {
			$timelogpostTitleError = 'Please enter a title to your log entry.';
			$hasError = true;
		} else {
			$timelognewposttitle = trim($_POST['timelogpostTitle']);
		}
		
		if(trim($_POST['timelogpostproject']) === '') {
		} else {
			$timelogspostproject = trim($_POST['timelogpostproject']);
		}
		
		if(trim($_POST['userid']) === '') {
		} else {
			$timeloguserid = trim($_POST['userid']);
		}
		
		
		$timelogpost_information = array(
			'post_title' => esc_attr(strip_tags($_POST['timelogpostTitle'])),
			'post_type' => 'timelog',
			'tags_input' => esc_attr(strip_tags($timeloguserid)),
			'post_status' => 'publish',
			'comment_status' => 'open'
		);
	
	//	$inv = "no";
	
		$timelogpost_id = wp_insert_post($timelogpost_information);
	
		if($timelogpost_id)
		{
		
	        update_post_meta( $timelogpost_id, 'it_timelogspostproject', $timelogspostproject );	
	//        update_post_meta( $timelogpost_id, 'it_invoiced', $inv );	
			
			//wp_redirect($_SERVER['REQUEST_URI']);
			//exit;		
			
			$added = true;
			
		}
	
	}
	
	
	} // END timelog
	

} // end if demo



//start page loop
if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php
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


    	
<div class="well clearfix col-md-12 welladj2">
	<h4 class="margintop0"><span>Adicionar</span></h4>

					<form action="" name="timelogsubmitted" id="timelogPostForm" method="POST" class="marginbottom0">
					 
					 	<div class="one-fourth column-">
	    					<div class="form-section" id="project-tasks-form-section">
	  	 				 		<fieldset class="marginbottom20">
		  	 				 		<label class="clearfix labeladj" for="timelogpostTitle"><?php _e('Número de horas:', 'framework') ?></label>
		  	 				 		<input name="timelogpostTitle" id="timelogpostTitle" class="span2 required inpadj3" value="" placeholder="" type="text">
		  	 				 	</fieldset>
	  						</div>
						</div><!-- END COLUMN 1 -->


						<div class="one-half column-last">
		  	 				<label class="clearfix labeladj" for="timelogpostproject"><?php _e('A qual projeto se refere?', 'framework') ?></label>
							<div class="form-section">
							<fieldset>

							 <select name="timelogpostproject">
				                <?php
				                //get post type ==> projects_cpt
				                query_posts(array(
				                    'post_type'=>'projects_cpt',
				                    'posts_per_page' => -1
				                ));
				                
				                //start loop
				                while (have_posts()) : the_post();
				                ?>
				                    <option value="<?php echo $post->ID; ?>"><?php the_title(); ?></option>
				                <?php  
				                endwhile; wp_reset_query(); ?>
				            </select><!-- /projects-content -->
						
						</fieldset> 
  	  					</div>

						</div><!-- END COLUMN 2 -->

						<!-- END DEADLINE ROW -->	
						<div class="clear"></div>



						<div class="form-actions margintop60 marginbottom0">
						  	<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
						 	<input type="hidden" name="userid" id="userid" value="<?php echo $current_user_id; ?>" />
						  	<input type="hidden" name="timelogsubmitted" id="timelogsubmitted" value="true" />
						    <button name="timelogsubmitted" id="projsubmit" type="submit" class="button giant blue height50"><span class="button-inner bordertop0"><?php _e( 'Adicionar', 'framework'); ?></span></button>
						  </div>
  						</form>


</div> <!-- /add entry box-->



<?php /*

<div class="well clearfix col-md-6" style="margin-top:-2px;min-height: 350px;">
	<h4 class="" style="margin-top:0px;"><span>Project Totals</span></h4>






	<!-- END DEADLINE ROW -->	
	<div class="clear"></div>

</div> <!-- /add entry box-->



<div class="well clearfix col-md-6" style="margin-top:-2px;min-height: 350px;">
	<h4 class="" style="margin-top:0px;"><span>Send Combined Invoice</span></h4>

					<form action="" name="timelogsubmitted" id="timelogPostForm" method="POST" class="marginbottom0">
					 
					<!-- BEGIN CATEGORY -->
		      				<p style="font-size: 11px;
font-style: italic;">Select as many log entries as you want to invoice for to send 1 combined invoice.<br/>(All hours will be totaled).</p>
							<div class="span5" >
									<div class="form-section">
									<fieldset>
				

									<select name="invoices[]" multiple="multiple" style="width: 100%;
font-size: 14px;">
									<?php 
						                //get post type ==> projects_cpt
						                query_posts(array(
						                    'post_type'=>'timelog',
						                    'posts_per_page' => -1,
						                ));
											
						                //start loop
						                while (have_posts()) : the_post();
			                                
											//get post by id
											$timelogspostproject = get_post_meta($post->ID, 'it_timelogspostproject', true);
											$project_title = get_the_title($timelogspostproject);
											$invdate = get_the_date();
										?>
											<option value="<?php echo $post->ID; ?>"><?php echo $project_title; ?> - <?php echo $post->ID; ?> hours on <?php echo $invdate; ?></option>

			                           <?php     
										endwhile; wp_reset_query(); ?>
									</select>
			
								</fieldset>
							</div>
						</div>
					<!-- END CATEGORY -->

						<div class="form-actions margintop40 marginbottom0">
						  	<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
						 	<input type="hidden" name="userid" id="userid" value="<?php echo $current_user_id; ?>" />
						  	<input type="hidden" name="timelogsubmitted" id="timelogsubmitted" value="true" />
						    <button name="timelogsubmitted" id="projsubmit" type="submit" class="button giant blue height50"><span class="button-inner bordertop0"><?php _e( 'Add New Entry', 'framework'); ?></span></button>
						  </div>
  						</form>


</div> <!-- /add entry box-->


*/ ?>

<div class="clearfix"></div>


	   <!-- UPDATE ALERTS -->
	   <?php if ($added == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Success!</strong> Você atualizou o log do projeto.
		</div>
		<?php } ?>





<div class="clearfix">
	<h4 class="heading"><span>Log do Projeto</span></h4>

					<?php 
					$i = '';
					
    	            $my_query = new WP_Query( array( 'post_type' => 'timelog', 'posts_per_page' => '-1', 'post_status' => 'publish', 'tag' => ''.$current_user_id.'', 'orderby' => 'date', 'order' => 'DESC' ) ); 
    	                $i == 0;
    	               
					if ( $my_query->have_posts() ) : 
					
					?>

     	 			<!--BEGIN #home-testimony-->		
					<table class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>Hours</th>
							<th>Project</th>
							<th>Date Added</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
					
					<?php
					while ( $my_query->have_posts() ) : $my_query->the_post();

					$timelogspostproject = get_post_meta($post->ID, 'it_timelogspostproject', true);
					$timelogpost_id = $post->ID;
				//	$timeloginvoiced = get_post_meta($post->ID, 'it_invoiced', true);
				//	if ($timeloginvoiced == "no") { $timeloginvoiced = "No"; }
				//	if ($timeloginvoiced == "yes") { $timeloginvoiced = "Yes"; }
        	        ?>
            	    <tr>
                	
                	<?php $pid = get_the_ID(); ?>
					<td><?php the_title(); ?></td>
					<td><?php echo get_the_title($timelogspostproject); ?></td>
					<td><?php echo get_the_date(); ?></td>
					<td><a onclick="return confirm('Are you sure you wish to delete these hours?')" href="<?php echo get_delete_post_link( $timelogpost_id ); ?>"><i class="icon-trash"></i></a></td>

            	    </tr>
            	    <?php $i++; ?>
            	    <?php endwhile; ?>

					</tbody>
					</table>	

					<?php else: ?>
					
					<p>Não há log de projetos no momento.</p>

					<?php endif; ?>
				

</div> <!-- /log box-->


 
		
        <?php
		//reset the custom query
		wp_reset_query(); ?>
    </div><!-- /projects-wrap -->
</div><!-- /projects-template -->

<?php

//get template footer
get_footer(); ?>
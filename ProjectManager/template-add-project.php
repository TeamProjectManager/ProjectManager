<?php
/**
 * Project Manager
 * Template Name: Adicionar Projeto
 */

	
$demo = false;

if ($demo == true){ } else {

$assigned = '';
$postTitleError = '';

if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

	$hasError = false;

	if(trim($_POST['postTitle']) === '') {
		$postTitleError = 'Digite um título por favor.';
		$hasError = true;
	} else {
		$postTitle = trim($_POST['postTitle']);
	}


	if($_POST['postContent'] === '') {
	} else {
		$postContent = $_POST['postContent'];
	}


		if(($_POST['it_projects_assigned']) === '') {
		} else {
			$users = $_POST['it_projects_assigned'];
		}


		if(($_POST['cats']) === '') {
		} else {
			$cat = $_POST['cats'];
		}



	if(trim($_POST['it_projects_client']) === '') {
	} else {
		$projectclient = trim($_POST['it_projects_client']);
	}


	if (isset($hasError) && ($hasError == true)){ } else {

	$post_information = array(
		//'ID' => esc_attr(strip_tags($_POST['postid'])),
		'post_title' => esc_attr(strip_tags($_POST['postTitle'])),
		'post_content' => $_POST['postContent'],
		'post_type' => 'projects_cpt',
		'post_status' => 'publish'
	);

	$post_id = wp_insert_post($post_information);


	if ($_FILES) {
		foreach ($_FILES as $file => $array) {
		$newupload = insert_attachment($file,$post_id, true);
		// $newupload returns the attachment id of the file that
		// was just uploaded. Do whatever you want with that now.
		}
	} 


	if ($post_id)
	{

		// Update Custom Meta
		update_post_meta($post_id, 'it_projects_deadline', esc_attr(strip_tags($_POST['deadline_date'])));
		update_post_meta($post_id, 'it_projects_assigned', $users);
		update_post_meta($post_id, 'it_projects_client', esc_attr(strip_tags($_POST['it_projects_client'])));

		//add categories
		wp_set_post_terms($post_id, $cat, 'projects_cpt_cats' );
	
	
	set_post_thumbnail( $post_id, $newupload );

	$url = get_permalink( $post_id );
	
	//get blog name
	$blogname = get_bloginfo('name');
	//get admin email	
	$adminemail = get_bloginfo('admin_email');
	$headers = 'From: '.$blogname.' <'.$adminemail.'>' . "\r\n";



	foreach ($users as $user){
		// GET ASSIGNED USER'S EMAIL (& EMAIL THEM)
		$assigned_email = get_the_author_meta( 'user_email', $user->ID );
		$assigned_subject = 'New Project Assignment';
		$assigned_message = 'A new project has been assigned to you - you can view the project here: '.$url.'';
		wp_mail($assigned_email, $assigned_subject, $assigned_message, $headers);
	}

	wp_redirect($url);
	exit;

	} // end if post
	
	} // end if no error

} // end if post

} // end if demo



//get template header
get_header();
$pagetitle = $it_data['user_add_projects_title']; 
if ($pagetitle == '') { $pagetitle="Add a Project"; }
require_once ( 'includes/body-top.php' );

//add_action( 'enqueue_scripts', array( $this, 'register_scripts' ) );
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

?>
	<script>
		jQuery(document).ready(function() {
		    jQuery('.MyDate').datepicker({
		        dateFormat : 'dd-mm-yy'
		    });
		});	
	</script>
<?php


	
    
    if ( current_user_can( 'manage_options' ) ) {
    	$isadmin = true;
	} else {
		 wp_redirect(home_url());
		 exit;
		
		// for demo
		//$isadmin = true;

	}

//start post loop
if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="home-wrap" class="clearfix">

    <article id="post" class="clearfix animated fadeInUp">
        <div class="entry clearfix">	
            
         
            
         <div id="contact-form" class="formadj">		
		<form action="" id="primaryPostForm" method="POST" enctype="multipart/form-data">

			<!-- TITLE -->
			<fieldset>
				<h2 class=""><span>Título</span></h2>
				<input type="text" name="postTitle" id="postTitle" value="<?php if(isset($_POST['postTitle'])) echo $_POST['postTitle'];?>" class="required width100 height50 inpadj"/>
			</fieldset>
			

			<!-- DESCRIPTION -->
			<?php if(isset($postTitleError) && ($postTitleError != '')) { ?>
				<div class="alert alert-danger"><?php echo $postTitleError; ?></div>
				<div class="clearfix"></div>
			<?php } ?>

			<fieldset>
				<h3 class="marginbottom0"><span>Descrição do Projeto</span></h3>
			<?php 
			$args = array(
				'media_buttons'			=> false,
			    'textarea_rows'         => 20 // integer
			); 
			$postCont = '';
			if(isset($_POST['postContent'])) { $postCont = $_POST['postContent']; }
			wp_editor( $postCont, 'postContent', $args ); ?> 
 			</fieldset>


			<!-- COVER ART -->
			<fieldset class="images">
				<h3 class=""><span>Capa do Projeto</span></h3>
				<input type="file" name="project_img" id="project_img" size="50" class="picinput uploadbg">
			</fieldset>

 		
 		

	<!-- BEGIN ASSIGNMENT -->	
	<div class="one-half column-">
			<h3 class=""><span>Atribuir projeto para:</span></h3>
			<label class="marginbottom15">* Segure o ctrl enquanto clica para adicionar mais de uma pessoa</label>
		
			<div class="span5">
					<div class="form-section">
						<fieldset>
				
									<select name="it_projects_assigned[]" multiple="multiple multisel2">
									<?php $clientargs = array(
										'role'         => 'client',
										'fields'       => 'ID',
									 ); 
									 
									 $clientarr = get_users( $clientargs );
									 $clientids = implode(',', $clientarr);
									
										$args1 = array(
										    'show_option_all'         => null, // string
										    'show_option_none'        => null, // string
										    'hide_if_only_one_author' => null, // string
										    'orderly'                 => 'display_name',
										    'order'                   => 'ASC',
										    'include'                 => null, // string
										    'exclude'                 => ''.$clientids.'',
										    //'multi'                   => true,
										    'show'                    => 'display_name',
										    'echo'                    => true,
										    //'selected'                => ''.$assigned.'',
										    //'include_selected'        => false,
										    //'name'                    => 'it_projects_assigned', // string
										    //'id'                      => null, // integer
										    //'class'                   => null, // string 
										    //'blog_id'                 => $GLOBALS['blog_id'],
										    //'who'                     => null // string
										);
									
											$projectusers=get_users($args1); 

		                                if ($projectusers){
			                                
			                                foreach ($projectusers as $user){
													echo "<option value='$user->ID' />";    
													echo $user->display_name;
													echo '<br>';    
			                                }
			                                
		                                }
		                                
		                                ?> 
									</select>
			
						</fieldset>
						
					</div>
			</div>
	</div>
	<!-- END ASSIGNMENT -->	
	
	

	<!-- BEGIN CLIENT -->
	<div class="one-half column-last">
  	  
  	  	<h3 class=""><span>Cliente do Projeto</span></h3>
				<fieldset>
						
                        <select name="it_projects_client">
                        <option>Selecione um cliente</option>
					<?php
					$users = get_users('role=client');
							foreach ($users as $option) {					
							// Loop through each option in the array
							$user_info = get_userdata( $option->ID );
								echo '<option '; 
								if ( isset($projectclient) && ($projectclient == $option->user_login) ) {
								echo 'selected="selected" ';
								}
								echo 'value="' . $option->user_login . '">' . $option->user_login . '</option>';
						}
						
						echo	'</select>';
						
						?>
						
				</fieldset>

	</div>
	<!-- END CLIENT -->	
	
	
	

	<div class="clearfix"></div>



	<!-- BEGIN DEADLINE -->
	<div class="one-half column-">

	  	  	<h3 class=""><span>Prazo do Projeto</span></h3>
				<fieldset class="width100px floatleft">
				  <input type="text" name="deadline_date" id="deadline_date" value="<?php if (isset($deadline)){ echo $deadline;} ?>" placeholder="enter deadline here" class="MyDate inpadj2"/>				
				  </fieldset>
	</div>
	<!-- END DEADLINE -->


<div class="clearfix"></div>



	<!-- BEGIN CATEGORY -->
	<div class="one-half column-last">

		<h3 class=""><span>Categoria</span></h3>
			<div class="span5">
					<div class="form-section">
						<fieldset>
				
									<select name="cats[]" multiple="multiple multisel2">
									<?php 
										$args3 = array(
											'orderby'                  => 'name',
											'order'                    => 'ASC',
											'hide_empty'               => 0,
											'hierarchical'             => 1,
											'exclude'                  => '',
											'include'                  => '',
											'number'                   => '',
											'taxonomy'                 => 'projects_cpt_cats',
											'pad_counts'               => false 
											);
											
											$projectcats=get_categories($args3); 

		                                if ($projectcats){
			                                
			                                foreach ($projectcats as $cat){
													echo "<option value='$cat->term_id' />";    
													echo $cat->cat_name;
													echo '<br>';    
			                                }
			                                
		                                }
		                                
		                                ?> 
									</select>
			
								</fieldset>
					</div>
		</div>
	</div>
	<!-- END CATEGORY -->
	
	
		<div class="clearfix"></div>


		<div class="form-actions margintop40">
			<fieldset>
				<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
				<input type="hidden" name="submitted" id="submitted" value="true" />
				<button type="submit" class="button giant blue height50"><span class="bordertop0" class="button-inner"><?php _e('Adicionar Projeto', 'framework') ?></span></button>
			</fieldset>
		</div>

		</form>
	</div>       
            
            
            
            <div class="addnote">
            
            <?php if($post->post_content=="") : ?>

			<!-- Do stuff with empty posts (or leave blank to skip empty posts) -->
                    
            
			<?php else : ?>
			
			<!-- Do stuff to posts with content -->
                    <div class="bs-callout bs-callout-info margintop0">
                     <?php the_content(); ?>
					</div>

			
			<?php endif; ?>
			            
            </div>
            
            
            
            
            
        </div><!-- /entry -->       
    </article><!-- /post -->
    
	<?php
	//show comments if not disabled
	if($it_data['show_hide_page_comments'] !='disable') { comments_template(); } ?>
    
<?php
//end post loop
endwhile; endif;

//get footer template
get_footer(); ?>
<?php
/**
 * Project Manager
 */

//get theme options
global $it_data;
$assignedupdate = false;
$dateupdate = false;
$clientupdate = false;
$tagupdate = false;
$editproject = false;
$imageupdate = false;
$fileadded = false;
$projectlive = false;	
$projectdraft = false;	
$projectdeleted = false;	
$projectcompleted = false;	
$projectuncompleted = false;	
$taskadded = false;
$taskcompleted = false;
$taskuncompleted = false;
$commentadded = false;

$assigned = '';

$today = date(get_option('date_format'));


/* SUBMITS */

$demo = false;

if ($demo == true){ 
	
/* SUGGESTIONS */

$suggestions_tasks = array("e.g., Contact the People From Marketing","e.g., Get the store supplies","e.g., Call David about the thing","e.g., Rent the venue", "e.g., Rule the world", "e.g., Email team reminders", "e.g., Bacon. More bacon.", "e.g., Find the right playlist for event", "e.g., Book the speaker", "e.g., Print brochures", "e.g., Post to Facebook", "e.g., Get the website up", "e.g., Buy this theme", "e.g., Call mom");
$rand_tasks = array_rand($suggestions_tasks);

/* END SUGGESTIONS */

	
} else {


if(isset($_POST['postsubmitted'])){

$postTitleError = '';

if(isset($_POST['postsubmitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {


	if(trim($_POST['postTitle']) === '') {
		$postTitleError = 'Please enter a title.';
		$hasError = true;
	} else {
		$newposttitle = trim($_POST['postTitle']);
	}

	$post_information = array(
		'ID' => esc_attr(strip_tags($_POST['postid'])),
		'post_title' => esc_attr(strip_tags($_POST['postTitle'])),
		'post_content' => $_POST['postContent'],
		'post_type' => 'projects_cpt',
		'post_status' => 'publish'
	);

	$post_id = wp_update_post($post_information);

		wp_redirect($_SERVER['REQUEST_URI']);
		exit;	
	
	$editproject = true;

}

} // END POST




if(isset($_POST['clientproject_form'])){

if(isset($_POST['clientproject_form']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

		$post_id = $_POST['postid'];
		
		// Update Custom Meta
		update_post_meta($post_id, 'it_projects_client', esc_attr(strip_tags($_POST['it_projects_client'])));

		//wp_redirect($_SERVER['REQUEST_URI']);
		//exit;	

		$clientupdate = true;

}

} // END POST






if(isset($_POST['imageproject_form'])){

if(isset($_POST['imageproject_form']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

		$post_id = $_POST['postid'];
		
		if ($_FILES) {
			foreach ($_FILES as $file => $array) {
			$newupload = insert_attachment($file,$post_id, true);
			// $newupload returns the attachment id of the file that
			// was just uploaded. Do whatever you want with that now.
			}
	
			set_post_thumbnail( $post_id, $newupload );
	
		} 
	
		//wp_redirect($_SERVER['REQUEST_URI']);
		//exit;	

		$imageupdate = true;

}

} // END POST





if(isset($_POST['assignproject_form'])){

if(isset($_POST['assignproject_form']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

		$post_id = $_POST['postid'];
		
		if(($_POST['it_projects_assigned']) === '') {
		} else {
			$users = $_POST['it_projects_assigned'];
		}

	if(trim($_POST['url']) === '') {
		$postTitleError = 'Please enter a title.';
		$hasError = true;
	} else {
		$url = trim($_POST['url']);
	}

		// Update Custom Meta
		update_post_meta($post_id, 'it_projects_assigned', $users);

	//get blog name
	$blogname = get_bloginfo('name');
	//get admin email	
	$adminemail = get_bloginfo('admin_email');
	$headers = 'From: '.$blogname.' <'.$adminemail.'>' . "\r\n";


if(!empty($it_data['projects_add_subject'])) { $subject = $it_data['projects_add_subject']; } else { $subject = 'Novo Projeto Atribuido'; }

if(!empty($it_data['projects_add_message'])) { $message = $it_data['projects_add_message']; } else { $message = 'Um novo projeto foi atribuido para você - você poderá ver o projeto aqui: '.$url.''; }



		// GET ASSIGNED USER'S EMAIL (& EMAIL THEM)
		foreach ($users as $user){
			// GET ASSIGNED USER'S EMAIL (& EMAIL THEM)
			$assigned_email = get_the_author_meta( 'user_email', $user->ID );
			wp_mail($assigned_email, $subject, $message, $headers);
		}

		//wp_redirect($_SERVER['REQUEST_URI']);
		//exit;	

		$assignedupdate = true;


}

} // END POST




if(isset($_POST['deadlineproject_form'])){

if(isset($_POST['deadlineproject_form']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

		$post_id = $_POST['postid'];
		$deadline = $_POST['deadline_date'];
		
		$newdeadline2 = date("Y-m-d", strtotime($deadline));
	
		
		update_post_meta($post_id, 'it_projects_deadline', esc_attr(strip_tags($newdeadline2)));

		//wp_redirect($_SERVER['REQUEST_URI']);
		//exit;	
		
		$dateupdate = true;	

}

} // END POST





if(isset($_POST['categoryproject_form'])){

if(isset($_POST['categoryproject_form']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

		$post_id = $_POST['postid'];

	
		if(($_POST['cats']) === '') {
		} else {
			$cat = $_POST['cats'];
		}

	
		//add categories
		wp_set_post_terms($post_id, $cat, 'projects_cpt_cats' );

		//wp_redirect($_SERVER['REQUEST_URI']);
		//exit;	

		$tagupdate = true;

}

} // END POST







if(isset($_POST['filesubmitted'])){

if(isset($_POST['filesubmitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

if ($_FILES) {
	foreach ($_FILES as $file => $array) {

	$attach_id = insert_attachment( $file, $_POST['id'], false ); 
	//$newupload = insert_attachment($file,$_POST['id']);
	// $newupload returns the attachment id of the file that
	// was just uploaded. Do whatever you want with that now.
	
	
	}
}

		//wp_redirect($_SERVER['REQUEST_URI']);
		//exit;	
		
		$fileadded = true;
		
}

} // END POST





if(isset($_POST['postlive'])){


	if(trim($_POST['postid']) === '') {
		$postTitleError = 'Please enter a title.';
		$hasError = true;
	} else {
		$id = trim($_POST['postid']);
	}


		wp_update_post( array ('ID' => $id, 'post_status' => 'publish') ) ;

		//wp_redirect($_SERVER['REQUEST_URI']);
		//exit;	
		
		$projectlive = true;	

}



if(isset($_POST['postdraft'])){


	if(trim($_POST['postid']) === '') {
		$postTitleError = 'Please enter a title.';
		$hasError = true;
	} else {
		$id = trim($_POST['postid']);
	}


		wp_update_post( array ('ID' => $id, 'post_status' => 'draft') ) ;

		//wp_redirect($_SERVER['REQUEST_URI']);
		//exit;	
		
		$projectdraft = true;	
	

}




if(isset($_POST['postdeleted'])){


	if(trim($_POST['id']) === '') {
		$postTitleError = 'Please enter a title.';
		$hasError = true;
	} else {
		$id = trim($_POST['id']);
	}


	if(trim($_POST['url']) === '') {
		$postTitleError = 'Please enter a title.';
		$hasError = true;
	} else {
		$url = trim($_POST['url']);
	}


		wp_update_post( array ('ID' => $id, 'post_status' => 'trash') ) ;

		//wp_redirect($_SERVER['REQUEST_URI']);
		//exit;	

		$projectdeleted = true;	

}


if(isset($_POST['projectcompleted'])){


	if(trim($_POST['postid']) === '') {
	} else {
		$post_id = trim($_POST['postid']);
	}
	
	if($post_id)
	{
		
		// Update Custom Meta
		update_post_meta($post_id, 'it_show_project_complete', 'yes');

		//wp_redirect($_SERVER['REQUEST_URI']);
		//exit;	

		$projectcompleted = true;	

		
	}

}


if(isset($_POST['projectuncompleted'])){


	if(trim($_POST['postid']) === '') {
	} else {
		$post_id = trim($_POST['postid']);
	}
	
	if($post_id)
	{
		
		// Update Custom Meta
		update_post_meta($post_id, 'it_show_project_complete', 'no');

		//wp_redirect($_SERVER['REQUEST_URI']);
		//exit;	
		
		$projectuncompleted = true;	
	
		
	}

}



if(isset($_POST['todossubmitted'])){

$todospostTitleError = '';

if(isset($_POST['todossubmitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {


	if(trim($_POST['todospostTitle']) === '') {
		$todospostTitleError = 'Please enter a title.';
		$hasError = true;
	} else {
		$todosnewposttitle = trim($_POST['todospostTitle']);
	}

	$todospost_information = array(
		'post_title' => esc_attr(strip_tags($_POST['todospostTitle'])),
		'post_content' => esc_attr(strip_tags($_POST['todospostContent'])),
		'post_type' => 'todos',
		'tags_input' => esc_attr(strip_tags($_POST['postid'])),
		'post_status' => 'publish',
		'comment_status' => 'open'
	);

	$todospost_id = wp_insert_post($todospost_information);

	$tododeadline = $_POST['todo_deadline_date'];

	$newdeadline2 = date("Y-m-d", strtotime($tododeadline));


	if($todospost_id)
	{

		// Update Custom Meta
		update_post_meta($todospost_id, 'it_todo_deadline', esc_attr(strip_tags($newdeadline2)));
		update_post_meta($todospost_id, 'it_todo_assigned', esc_attr(strip_tags($_POST['it_todo_assigned'])));

	//get blog name
	$blogname = get_bloginfo('name');
	//get admin email	
	$adminemail = get_bloginfo('admin_email');
	$headers = 'From: '.$blogname.' <'.$adminemail.'>' . "\r\n";

	if(trim($_POST['url']) === '') {
		$postTitleError = 'Please enter a title.';
		$hasError = true;
	} else {
		$url = trim($_POST['url']);
	}

if(!empty($it_data['projects_add_task_subject'])) { $subject = $it_data['projects_add_task_subject']; } else { $subject = 'New Task Assignment: '.$_POST['todospostTitle'].''; }

if(!empty($it_data['projects_add_task_message'])) { $message = $it_data['projects_add_task_message']; } else { $message = 'A new project task assignment has been given to you - you can view the project here: '.$url.''; }


		// GET ASSIGNED USER'S EMAIL (& EMAIL THEM)
		if (isset($_POST['it_todo_assigned'])){
			$assigned_email = get_the_author_meta( 'user_email', $_POST['it_todo_assigned'] );
			wp_mail($assigned_email, $subject, $message, $headers);
		}

		//wp_redirect($_SERVER['REQUEST_URI']);
		//exit;	
		
		$taskadded = true;
		
	}

}


} // END TODO




if(isset($_POST['todorestore'])){

	if(trim($_POST['postid']) === '') {
	} else {
		$todospost_id = trim($_POST['postid']);
	}

	if($todospost_id)
	{
		
		// Update Custom Meta
		wp_update_post( array ('ID' => $todospost_id, 'post_status' => 'publish') ) ;

		//wp_redirect($_SERVER['REQUEST_URI']);
		//exit;	
		
		$taskuncompleted = true;	
		
	}

} // END TODO




if(isset($_POST['todocomplete'])){

	if(trim($_POST['postid']) === '') {
	} else {
		$todospost_id = trim($_POST['postid']);
	}

	if($todospost_id)
	{
		
		// Update Custom Meta
		wp_update_post( array ('ID' => $todospost_id, 'post_status' => 'trash') ) ;

		//wp_redirect($_SERVER['REQUEST_URI']);
		//exit;	
		
		$taskcompleted = true;	
		
	}

} // END TODO



} // END IF DEMO


/* END SUBMITS */



wp_reset_query();


//get header
get_header();

	
//start post loop
if (have_posts()) : while (have_posts()) : the_post();

			//get client meta
			$projectsclient = '';
			$projectsclient = get_post_meta($post->ID, 'it_projects_client', true);
			if (isset($projectsclient) && ($projectsclient != 'Selecione um Cliente')) {
			$clientarray = get_user_by('login', $projectsclient);
			$clientid = $clientarray->ID;
			$clientname = $clientarray->user_login;
			$clientavatar = get_avatar($clientid, 31);
		//	$projectsclient = get_post_meta($post->ID, 'it_projects_client', true);
			}
			
			
			//get deadline meta
			$deadline = get_post_meta($post->ID, 'it_projects_deadline', true);
			$newdeadline2 = date("F j, Y", strtotime($deadline));
			
			//get the date
			$postdate = get_the_date();
	
			$strtoday = strtotime($today);
			$strdeadline = strtotime($newdeadline2);
			$stdate = strtotime($postdate);
						
			if ($strtoday > $strdeadline) { $overdue = '1'; } else { $overdue = '2'; }		
			
			//get total number days
			$diff = abs($strtoday - strtotime($deadline));
			
			//get days from today to deadline
			$todate = (strtotime($today) - $stdate) / (60 * 60 * 24);
			
			//get total days - strtime
			$totaldays = (strtotime($deadline) - $stdate) / (60 * 60 * 24);
			
			//get strtime todate
			$strtodate = strtotime($todate);
			
			// TOTAL SUM
			$complete = ceil(($todate / $totaldays) * 100);					
									
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

			//get the project owner
			$ownerid = array();
			$ownerid = get_post_meta($post->ID, 'it_projects_assigned', true);

			if (!isset($ownerid)){$assignedname = "Assign To";}
			
			//set post id
			$postid = $post->ID;
			$posttitle = get_the_title();
			$postcontent = get_the_content();
			$projectstatus = $post->post_status;
			$projlive = get_permalink( $post->ID );
			
			//get complete status
			$iscomplete = '';
			$iscomplete = get_post_meta($post->ID, 'it_show_project_complete', true);
			
			//set comments open
			//update_post_meta($postid, 'comment_status', 'open');
			//wp_update_post( array ('ID' => $postid, 'comment_status' => 'open') ) ;
			
			$terms = get_the_terms( $post->ID, 'projects_cpt_cats' );
						
			if ( $terms && ! is_wp_error( $terms ) ) : 
				$term_links = array();
				foreach ( $terms as $term ) {
					$term_links[] = $term->name;
				}
				$projects_links = join( ", ", $term_links );
			endif;



$pagetitle = $posttitle;

require_once ( 'includes/body-top.php' );
$today = date(get_option('date_format'));


   	$editdeadline = $it_data['client_edit_deadline'];
   	$editdescription = $it_data['client_edit_description'];
   	$addtasks = $it_data['client_add_tasks'];
   	$addfiles = $it_data['client_add_files'];

	
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


?>
     
<style>
#single-meta img {
	float: left;
	width: 31px;
	margin-right: 0px;
	margin-top: -1px;
	border-radius: 0px;
}
</style>
<style>
#single-meta .client img {
	float: left;
	border-radius: 0px;
     margin-top: -9px;
	 margin-bottom: -8px;
	 padding-bottom: 0px;
	 margin-right: 10px;
	 width: 32px;
}
</style>


  <div class="clearfix"></div>
   <!-- PROJECT DETAILS -->
   <section id="single-meta" class="meta clearfix">
        <ul>
        
            <?php 
            
			if (isset($ownerid) && ($ownerid !== '') && ($ownerid !== 'Array')) { ?>
			
			<!-- PROJECT FILES -->
			<li class="projfilestop">
				
				<?php
				
				if (!is_array($ownerid)){
				
							$assignedname = get_the_author_meta( 'display_name', $ownerid );
							$assignedavatar = get_avatar($ownerid, 31);
							
							?>
								<a data-toggle="modal" href="<?php if ($isclient == true) {} else { echo '#assignproject'; } ?>">
								<div class="discussion-pic picadj1">
									<?php echo $assignedavatar; ?>
								</div>
								<span><strong><?php echo $assignedname; ?></strong></span>
								</a>
							
				<?php
				} else {
				
						$i = 0;
						$c = count($ownerid);
						
						while ($i < $c){
						
							$assignedname = get_the_author_meta( 'display_name', $ownerid[$i] );
							$assignedavatar = get_avatar($ownerid[$i], 31);
							
							?>	<div class="filediv2">
								<a data-toggle="modal" href="<?php if ($isclient == true) {} else { echo '#assignproject'; } ?>">
								<div class="discussion-pic picadj1">
									<?php echo $assignedavatar; ?>
								</div>
								<span><strong><?php echo $assignedname; ?></strong></span>
								</a>
							</div>
							<?php
							$i++;			
						}
						
						
				} // end if multiple 	?>
						
						
				</li>
			<?php } else { ?>
				
				<a data-toggle="modal" href="<?php if ($isclient == true) {} else { echo '#assignproject'; } ?>"><li>Atribuir Projeto</li></a>
				
			<?php } ?>


        
           <a data-toggle="modal" href="<?php if (($isclient == true) && ($editdeadline == 'disable')) {} else { echo '#deadlineproject'; } ?>"><li class="projassigned_menu"><i class="icon-calendar icon-margintop marginbottom1"></i> <?php if (isset($newdeadline2)) { echo $newdeadline2; } ?></li></a>
           
           <div class="filediv"><a data-toggle="modal" href="<?php if ($isclient == true) {} else { echo '#clientproject'; } ?>" class="client"><li class="projclient_menu"><?php if (isset($clientavatar)) { echo $clientavatar; } ?>  <?php if (isset($clientname)) { echo $clientname; } else { echo 'Selecione um Cliente'; } ?></li></a></div>
           <a data-toggle="modal" href="<?php if ($isclient == true) {} else { echo '#categoryproject'; } ?>"><li><i class="icon-tags icon-margintop"></i> <?php if (isset($projects_links)) { echo $projects_links; } ?></li></a>
           <a data-toggle="modal" href="<?php if (($isclient == true) && ($editdescription == 'disable')) {} else { echo '#editproject'; } ?>"><li><i class="icon-ok icon-margintop"></i> Editar Projeto</li></a>
		   <a data-toggle="modal" href="<?php if ($isclient == true) {} else { echo '#imageproject'; } ?>"><li><i class="icon-picture icon-margintop"></i> Editar Imagem do Projeto </li></a>



        </ul>
        
        
	</section><!-- /meta -->

   
	
	<article id="post" class="single-portfolio clearfix"> 


	   <!-- UPDATE ALERTS -->
	   <?php if ($assignedupdate == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Sucesso!</strong> Você atualizou a quem o projeto está atribuído.
		</div>
		<?php } ?>

	   <?php if ($dateupdate == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Sucesso!</strong> Você mudou a data deste projeto.
		</div>
		<?php } ?>

	   <?php if ($clientupdate == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Sucesso!</strong> Você mudou o cliente que esse projeto pertence.
		</div>
		<?php } ?>

	   <?php if ($tagupdate == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Sucesso!</strong> Você editou a categoria deste projeto.
		</div>
		<?php } ?>

	   <?php if ($editproject == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Sucesso!</strong> Você editou esse projeto.
		</div>
		<?php } ?>

	   <?php if ($imageupdate == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Sucesso!</strong> Você editou a imagem do projeto.
		</div>
		<?php } ?>

	   <?php if ($fileadded == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Sucesso!</strong> Você adicionou um arquivo ao projeto.
		</div>
		<?php } ?>

	   <?php if ($projectlive == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Sucesso!</strong> Você ativou o projeto.
		</div>
		<?php } ?>

	   <?php if ($projectdraft == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Pronto!</strong> Você fez deste projeto um rascunho.
		</div>
		<?php } ?>

	   <?php if ($projectdeleted == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Pronto!</strong> Você deletou esse projeto.
		</div>
		<?php } ?>

	   <?php if ($projectcompleted == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Sucesso!</strong> Você completou esse projeto.
		</div>
		<?php } ?>

	   <?php if ($projectuncompleted == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Pronto!</strong> Você não completou este projeto.
		</div>
		<?php } ?>

	   <?php if ($taskadded == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Sucesso!</strong> Você adicionou uma tarefa à esse projeto.
		</div>
		<?php } ?>
  
	   <?php if ($taskcompleted == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Sucesso!</strong> Você completou uma tarefa deste projeto.
		</div>
		<?php } ?>

	   <?php if ($taskuncompleted == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Pronto!</strong> Você não completou uma tarefa desse projeto.
		</div>
		<?php } ?>

	   <?php if ($commentadded == true) { ?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Pronto!</strong> Você deixou um comentário neste projeto.
		</div>
		<?php } ?>
  
  	   <!-- / UPDATE ALERTS -->



	   <!-- PROJECT DESCRIPTION -->
	    <article id="single-portfolio-info" class="clearfix">
	    
	    
	    
	    
	    	<div class="leftbox">
	    
			
			
	
			   
		   
		  <?php if (($overdue == '1') && ($iscomplete !== 'yes')) { ?>
		
			<div class="bs-callout bs-callout-danger margintop0">
			   		<h2 class="alert-title marginbottom0 margintop0">Project Atrasado!
						
		  <?php } elseif (($overdue == '1') && ($iscomplete == 'yes')) { ?>
			   
			<div class="bs-callout bs-callout-success margintop0">
			   		<h2 class="alert-title marginbottom0 margintop0">Projeto Completo!

		  <?php } elseif (($overdue !== '1') && ($iscomplete !== 'yes')) { ?>

			<div class="bs-callout bs-callout-info margintop0">
			   		<h2 class="alert-title marginbottom0 margintop0">Projeto em Andamento!
	
		  <?php } elseif (($overdue !== '1') && ($iscomplete == 'yes')) { ?>
		
			<div class="bs-callout bs-callout-success margintop0">
			   		<h2 class="alert-title marginbottom0 margintop0">Projeto Completo!
		
		  <?php } ?>
				
				
				
			<?php if ($isclient == true) { } else { ?>
				<span class="complbutton"> 
			
					<?php if ($iscomplete == 'yes'){ ?>
					
							<form action="" method="POST" name="projectuncompleted" id="projectuncompleted" class="marginbottom0">
							<input type="hidden" name="projectuncompleted" id="projectuncompleted" value="true" />
							<input type="hidden" name="postid" id="postid" value="<?php echo $postid; ?>" />
							<button type="submit" class="button blue normal opacity3"><span class="button-inner bordertop0"><i class="icon-ok icon-white margintop1up marginright4"></i> <?php _e('Desmarcar como Completo', 'framework') ?></span></button>
							</form>    
							
					<?php } else { ?>
					
							<form action="" method="POST" name="projectcompleted" id="projectcompleted" class="marginbottom0">
							<input type="hidden" name="projectcompleted" id="projectcompleted" value="true" />
							<input type="hidden" name="postid" id="postid" value="<?php echo $postid; ?>" />
							<button type="submit" class="button normal"><span class="button-inner bordertop0"><i class="icon-ok icon-white margintop1up marginright4"></i> <?php _e('Marcar como Completo', 'framework') ?></span></button>
							</form>    
							
					<?php } ?>
							
				</span><!-- /post-navigation -->
			<?php } ?>
			

			   		</h2>
			</div>
   <!-- /PROJECT STATUS -->    
			
			
			
			
			
   <!-- PROJECT DESCRIPTION -->    
            <?php if($post->post_content=="") : ?>

			<!-- Do stuff with empty posts (or leave blank to skip empty posts) -->
                    
            
			<?php else : ?>
			
			<!-- Do stuff to posts with content -->
                    <div class="bs-callout bs-callout-info margintop0 overflowauto">
                    
                
   <!-- PROJECT IMAGE -->    
            <?php
                
            //get featured image url
            $thumb = get_post_thumbnail_id();
            $img_url = wp_get_attachment_url($thumb,'full'); //get full URL to image
                
            $featured_image = aq_resize( $img_url, 300, 9999, false );
            
            if($featured_image) {
            ?>
        <div id="single-portfolio-media" class="projfeatimg"> 
                <div class="post-thumbnail">
                    <a href="<?php echo $img_url; ?>" title="<?php the_title(); ?>" class="prettyphoto-link">
                        <img class="" src="<?php echo $featured_image; ?>" alt="<?php echo the_title(); ?>" />
                    </a>
                </div><!-- /post-thumbnail -->
        </div><!-- /single-projects-media -->
            <?php
                } //no featured image
            ?>

                    <?php the_content(); ?>
					</div>

			
			<?php endif; ?>
			            
			
			
			
			
			
	    	</div>            
			            
			            
						<!-- PROJECT FILES -->
						<div id="projsection" class="well welladj3">
							<h4 class="margintop0 projfileh4"><span><i class="icon-upload margintop3down"></i> Arquivos do Projeto</span></h4>
							<div class="textwidget">

								<div id="projfiles" class="overflowauto">
								
									<?php	
										if (has_image_attachment($post->ID)) {

											$args = array(
											'post_type' => 'attachment',
											'numberposts' => null,
											'show posts' => '-1', 
											'posts_per_page' => '-1', 
											'post_status' => null,
											'exclude' => get_post_thumbnail_id(),
											'post_parent' => $post->ID
											);
											$attachments = get_posts($args);
																						
											if ($attachments) {
											
												foreach ($attachments as $attachment) {
											
													echo '<div id="profile" class="projfileitem">';
											
														if ($attachment->post_mime_type == "application/pdf"){
															
															echo '<div class="projfilediv">
															<div class="projfileadj">
															<a href="'.$attachment->guid.'">
																<img src="'; echo get_template_directory_uri() . '/images/pdficon.png">
															</a></div>';
															
															echo '
															<div class="floatleft">
															<a href="'.$attachment->guid.'">';
																the_title();
															echo '</a></div></div>';
															
														} elseif ($attachment->post_mime_type == "image/jpeg") {
															
															echo '<div class="projfilediv">
															<div class="projfileadj">';
															echo the_attachment_link($attachment->ID, false); 

															echo '</div>
															<div class="floatleft">
															<a href="'.$attachment->guid.'">';
																the_title();
															echo '</a></div></div>';
															
														} elseif ($attachment->post_mime_type == "image/png") {
															
															echo '<div class="projfilediv">
															<div clas="projfileadj"></div>';
															echo the_attachment_link($attachment->ID, false); 

															echo '</div>
															<div class="floatleft">
															<a href="'.$attachment->guid.'">';
																the_title();
															echo '</a></div></div>';
															
														} else {
															
															echo '<div class="projfilediv">
															<div class="projfileadj2">
															<icon class="icon-file margintop5down"></icon> </div>';
															// echo the_attachment_link($attachment->ID, false); 											
															echo '<div class="floatleft">
															<a href="'.$attachment->guid.'">';
																the_title();
															echo '</a></div></div>';
															
														}
																								
													echo '</div>';
													
													}//end for each
											
											}// end if


										} else {
				
											echo 'No files attached.';
				
										}

									?>

							</div><!-- /project files -->
		
		
		<?php if (($isclient == true) && ($addfiles == 'disable')) {} else { ?>
							<div id="contact-form">		
								<form action="" id="primaryPostForm" method="POST" enctype="multipart/form-data" class="marginbottom0">

									<br/>

 
					<div class="testimony-content uploadbg">
									<!-- images -->
									<fieldset class="images floatleft">
										<label for="images">Upload File</label>
										<input type="file" name="project_img" id="project_img" size="50" class="picinput lineheight16 fileinput">
										</fieldset>										
					<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
					<input type="hidden" name="filesubmitted" id="filesubmitted" value="true" />
					<input type="hidden" name="id" id="id" value="<?php echo $postid; ?>" />
					<input type="hidden" name="url" id="url" value="<?php echo $projlive; ?>" />
					<button type="submit" class="button green small picbtn"><span class="button-inner"><?php _e('Adicionar Arquivo', 'framework') ?></span></button>
					</div>

								</form>
							</div>

		<?php } ?>
		
								</div><!-- /textwidget -->
							</div> <!-- /sidebar box-->


			<?php wp_reset_query(); ?>

			            
			            
			            
	    </article><!-- /single-projects-info -->
	
	  

 
  
  <!-- EDIT PROJECT Modal -->
  <div class="modal fade" id="editproject">
    <div class="modal-dialog">
       <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Editar Informações do Projeto</h4>
        </div>
        <div class="modal-body">
          
		    <!--BEGIN CONTACT FORM-->
		    <div id="contact-form">
			<form action="" name="primaryPostForm" id="primaryPostForm" method="POST" enctype="multipart/form-data">
		      
		 
			<!-- BEGIN TITLE -->
		    <div class="form-section">
		  	  <fieldset>
		  	      <label for="postTitle"><?php _e( 'Project Title:', 'framework' ); ?></label>
		  	      <input type="text" name="postTitle" id="postTitle" value="<?php if(isset($posttitle)) echo $posttitle; ?>" class="required width97 editprojadj"/>
		  	  </fieldset>
		  	</div>
	  	  <?php if (isset($postTitleError) &&  ($postTitleError != '' )) { ?>
	  	      <span class="error"><?php echo $postTitleError; ?></span>
	  	      <div class="clear"></div>
	  	  <?php } ?>
		  	<!-- END TITLE -->
		  		
    
			    
		  	<!-- BEGIN DESC -->
			<?php $args = array(
				'media_buttons'			=> false,
			    'textarea_rows'         => 20 // integer
			); ?>

			      <div class="form-section">
			  	  <fieldset class="height320">
			  	      <label for="postContent"><?php _e( 'Conteúdo do Projeto:', 'framework' ); ?></label>
			  	     <?php wp_editor( $postcontent, 'postContent', $args ); ?>
			  	  </fieldset>
			  	  </div>
		  	<!-- END DESC -->

  	  	  
		  	<!-- END CONTACT FORM -->
			</div>
          
        </div>
        <div class="modal-footer">
  	      <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
  	      <input type="hidden" name="postid" id="postid" value="<?php if(isset($postid)) echo $postid; ?>" />
  	      <input type="hidden" name="postsubmitted" id="postsubmitted" value="true" />
  	      <button name="primaryPostForm" class="button blue clearfix floatright" type="submit"><?php _e( 'Atualizar Projeto', 'framework'); ?></button>
  		  </form>
        
        <?php 
			if (isset($isadmin) && ($isadmin == true)){// if admin
			
			 if (isset($projectstatus) && ($projectstatus == 'publish')) { ?>
	
				<form action="" class="marginbottom0 floatright marginright20" name="postdraft" id="postdraft" method="POST">
					<input type="hidden" name="postid" id="postid" class="marginbottom0" value="<?php echo $postid; ?>" />
					<input type="hidden" name="postdraft" id="postdraft" value="true" />
					<button name="postdraft" class="button gray" type="submit"><?php _e( 'Definir como Rascunho', 'framework'); ?></button>
				</form>
	 		
	 		<?php } if (isset($projectstatus) && ($projectstatus == 'draft')) { ?>
	 		
				<form action="" class="marginbottom0 floatright marginright20" name="postlive" id="postlive" method="POST">
					<input type="hidden" name="postid" id="postid" class="marginbottom:0" value="<?php echo $postid; ?>" />
					<input type="hidden" name="postlive" id="postlive" value="true" />
					<button name="postlive" class="button gray" type="submit"><?php _e( 'Definir como Ativo', 'framework'); ?></button>
				</form>
	 		
 		<?php } ?>

				<form action="" class="marginbottom0 floatleft" name="postdeleted" id="delete" method="POST">
					<button class="btn btn-danger" name="delete" type="submit"><?php _e( 'Excluir', 'framework'); ?></button>
					<input type="hidden" name="postdeleted" id="postdeleted" value="true" />
					<input type="hidden" name="id" id="id" value="<?php echo $postid; ?>" />
					<input type="hidden" name="url" id="url" value="<?php echo $projlive; ?>" />
				</form>			

		<?php } // end if admin ?>
        
        </div><!-- /.modal-footer -->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  
  
  
  
  
  
  
  
    <!-- IMAGE PROJECT Modal -->
  <div class="modal fade" id="imageproject">
    <div class="modal-dialog">
       <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Substituir Imagem</h4>
        </div>
        <div class="modal-body">
          
		    <!--BEGIN CONTACT FORM-->
		    <div id="contact-form">
			<form action="" name="imageproject_form" id="imageproject_form" method="POST" enctype="multipart/form-data">
		      
		 		   
	
			<!-- COVER ART -->
			<fieldset class="images">
				<h3 class="heading margintop40"><span>Imagem de Capa - Se selecionada, irá substituir a atual</span></h3>
				<input type="file" name="project_img" id="project_img" size="50" class="picinput">
			</fieldset>

 			  		
  	
 		  	  
		  	<!-- END CONTACT FORM -->
			</div>
          
        </div>
        <div class="modal-footer">
  	      <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
  	      <input type="hidden" name="postid" id="postid" value="<?php if(isset($postid)) echo $postid; ?>" />
  	      <input type="hidden" name="imageproject_form" id="imageproject_form" value="true" />
  	      <button name="primaryPostForm" class="button blue clearfix" type="submit"><?php _e( 'Salvar Mudanças', 'framework'); ?></button>
  		  </form>
        
        </div><!-- /.modal-footer -->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  




  
  
  
  
    <!-- CLIENT PROJECT Modal -->
  <div class="modal fade" id="clientproject">
    <div class="modal-dialog">
       <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Selecione um Cliente</h4>
        </div>
        <div class="modal-body">
          
		    <!--BEGIN CONTACT FORM-->
		    <div id="contact-form">
			<form action="" name="clientproject_form" id="clientproject_form" method="POST">
		      
		 		   
		  	<!-- BEGIN CLIENT -->
			<div class="form-section">
			  	  <fieldset>
			  	      <label for="it_projects_client" class="clearfix"><?php _e( 'Cliente do Projeto:', 'framework' ); ?></label>
			  	      
			  	      <select name="it_projects_client" id="it_projects_client" class="required">
			  	      	<option>Select a Client</option>
			  	      	<?php
								$users = get_users('role=client');
										foreach ($users as $option) {					
										// Loop through each option in the array
										$user_info = get_userdata( $option->ID );
											echo '<option '; 
											if ( isset($projectsclient) && ($projectsclient == $option->user_login) ) {
											echo 'selected="selected" ';
											}
											echo 'value="' . $option->user_login . '">' . $option->user_login . '</option>';
									}
									
									echo	'</select>';
									
									?>
					</select>
			  	  
			  	  </fieldset>
			</div>
		  	<!-- END CLIENT -->
		  		
 		  	  
		  	<!-- END CONTACT FORM -->
			</div>
          
        </div>
        <div class="modal-footer">
  	      <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
  	      <input type="hidden" name="postid" id="postid" value="<?php if(isset($postid)) echo $postid; ?>" />
  	      <input type="hidden" name="clientproject_form" id="clientproject_form" value="true" />
  	      <button name="primaryPostForm" class="button blue clearfix" type="submit"><?php _e( 'Salvar Mudanças', 'framework'); ?></button>
  		  </form>
        
        </div><!-- /.modal-footer -->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  




  
  
  <!-- CATEGORY PROJECT Modal -->
  <div class="modal fade" id="categoryproject">
    <div class="modal-dialog">
       <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Editar Categoria</h4>
        </div>
        <div class="modal-body">
          
		    <!--BEGIN CONTACT FORM-->
		    <div id="contact-form">
			<form action="" name="categoryproject_form" id="categoryproject_form" class="marginbottom0" method="POST">
		      
		 		   
					<!-- BEGIN CATEGORY -->
		      				<p class="smallfont">Selecione a categoria que este projeto melhor se enquadra.</p>
							<div class="span5" >
									<div class="form-section">
									<fieldset>
				
									<select name="cats[]" multiple="multiple" class="multisel">
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
					<!-- END CATEGORY -->

		  		
 		  	  
		  	<!-- END CONTACT FORM -->
			</div>
          
        </div>
        <div class="modal-footer">
  	      <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
  	      <input type="hidden" name="postid" id="postid" value="<?php if(isset($postid)) echo $postid; ?>" />
  	      <input type="hidden" name="categoryproject_form" id="categoryproject_form" value="true" />
  	      <button name="primaryPostForm" class="button blue clearfix" type="submit"><?php _e( 'Salvar Mudanças', 'framework'); ?></button>
  		  </form>
        
        </div><!-- /.modal-footer -->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  
  
   
  
  
    <!-- ASSIGN PROJECT Modal -->
  <div class="modal fade" id="assignproject">
    <div class="modal-dialog">
       <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Atribuir Projeto</h4>
        </div>
        <div class="modal-body">
          
		    <!--BEGIN CONTACT FORM-->
		    <div id="contact-form">
			<form action="" name="assignproject_form" id="assignproject_form" method="POST">
		      
		 		   
		  	<!-- BEGIN ASSIGNED -->
			<div class="form-section">
			
			
				<p class="smallfont">Você pode selecionar mútiplos membros para atribuí-los à esse projeto. <strong>Isso irá substituir as atuais atribuições.</strong></p>
				
			
				<fieldset>
				
									<select name="it_projects_assigned[]" multiple="multiple" class="multisel">
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
		  	<!-- END ASSIGNED -->
		  		
		  	<!-- END CONTACT FORM -->
			</div>
          
        </div>
        <div class="modal-footer">
  	      <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
  	      <input type="hidden" name="postid" id="postid" value="<?php if(isset($postid)) echo $postid; ?>" />
  	      <input type="hidden" name="assignproject_form" id="assignproject_form" value="true" />
  					<input type="hidden" name="url" id="url" value="<?php echo $projlive; ?>" />
	      <button name="primaryPostForm" class="button blue clearfix" type="submit"><?php _e( 'Salvar Mudanças', 'framework'); ?></button>
  		  </form>
        
        </div><!-- /.modal-footer -->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  

   
   
  
  
    <!-- DEADLINE PROJECT Modal -->
  <div class="modal fade" id="deadlineproject">
    <div class="modal-dialog">
       <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Mudar Deadline</h4>
        </div>
        <div class="modal-body">
          
		    <!--BEGIN CONTACT FORM-->
		    <div id="contact-form">
			<form action="" class="marginbottom0" name="deadlineproject_form" id="deadlineproject_form" method="POST">
		      
		 		   
		  	<!-- BEGIN DEADLINE -->
			<div class="clearfix">    	  
	  		<label for="it_projects_deadline_month" class="clearfix"><?php _e('Deadline:', 'framework') ?></label>	  
		      <div class="form-section">
				<fieldset class="width100px floatleft">

  	    	<input type="text" name="deadline_date" id="deadline_date" value="<?php if (isset($deadline)){ echo $deadline;} ?>" placeholder="enter deadline here" class="MyDate deadlineadj"/>				
				
				</fieldset>
				</div>		  		
		  	<!-- END DEADLINE -->	
		  	</div>
	
	
		  		
		  	<!-- END CONTACT FORM -->
			</div>
          
        </div>
        <div class="modal-footer">
  	      <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
  	      <input type="hidden" name="postid" id="postid" value="<?php if(isset($postid)) echo $postid; ?>" />
  	      <input type="hidden" name="deadlineproject_form" id="deadlineproject_form" value="true" />
  	      <button name="primaryPostForm" class="button blue clearfix" type="submit"><?php _e( 'Salvar Mudanças', 'framework'); ?></button>
  		  </form>
        
        </div><!-- /.modal-footer -->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  






  
     <!-- PROJECT TASKS -->
			<div class="clearfix" id="projsection">
				<h4 class="heading h4adj"><i class="icon-tasks margintop6down"></i> Tarefas do Projeto <span class="floatright"><a href="<?php if (($isclient == true) && ($addtasks == 'disable')) {} else { echo '#addtodo'; } ?>" data-toggle="modal" class="fontsize15"><i class="icon-plus-sign margintop2down"></i> Adicionar</a></span></h4>

 			<div class="" id="project-tasks">
 		
 	 		<!--BEGIN #home-testimony-->		
			<ul class="testimony-3-list clearfix uladj" id="project-tasks-list-ul">
			
			<?php
    	    $my_query = new WP_Query( array( 
    	    'post_type' => 'todos', 
    	    'show posts' => '-1', 
    	    'posts_per_page' => '-1', 
    	    'post_status'	=> array('trash', 'publish'),
    	    'tag' => ''.$postid.'' ) ); 
    	               
    	    $i = '';
    	    $i == 0;
    	               
			if ( $my_query->have_posts() ) : while ( $my_query->have_posts() ) : $my_query->the_post();
        	            			
        	//PROJECT TODO VARIABLES
        	$tododeadline = get_post_meta($post->ID, 'it_todo_deadline', true);
			$newtododeadline2 = date("F j, Y", strtotime($tododeadline));

        	$todoassigned = get_post_meta($post->ID, 'it_todo_assigned', true);
			if (isset($todoassigned)) { $todoassignedname = get_the_author_meta( 'display_name', $todoassigned ); }
			$status = $post->post_status;
        	            
   ?>
   <li class="clearfix taskli" id="taskli<?php if ($status == 'trash') { echo '-complete'; } ?>" style="<?php if ($status == 'trash') { echo 'background: honeydew;padding-bottom:0px;'; } ?> ">
   <?php $pid = get_the_ID(); ?>
   
   <div id="taskdiv">
   
   <?php if ($status == 'trash') { ?>
     
    <span id="taskchk">
    <input id="tasksel" checked="checked" disabled="disabled" class="margintop1up height12 displaynone" type="checkbox">
    </span>
               	
   <span id="taskitemdel" class="disabledtext"><del class="marginright10"><?php the_title(); ?> </del><span class="taskitemdel"><?php if ($todoassigned == ''){} else {  echo 'due by '.$newtododeadline2.''; } ?>  <?php if ($todoassigned == ''){} else { echo 'Assigned to:  <a href="">'.$todoassignedname.'</a>'; }  ?></span></span>

 	<span id="taskrest">
   
    	<form action="" class="marginbottom0 floatleft" name="todorestore" id="todosPostForm" method="POST">
    	<input type="hidden" name="postid" id="postid" class="marginbottom0" value="<?php echo $pid; ?>" />
  	    <input type="hidden" name="todorestore" id="todorestore" value="true" />
  	    <button name="todorestore" id="restore" class="button checkbox todorestore todoadj" type="submit"><i class="icon-ok todorestoreicon btnadj"></i></button>
  	    </form>
                	 
    </span>
    
    <?php } else { ?>
                	
    <span class="marginleft0">

   	<form action="" class="marginbottom0 floatleft" name="todocomplete" id="todoscompleteForm" method="POST">
    	<input type="hidden" name="postid" id="postid" class="marginbottom0" value="<?php echo $pid; ?>" />
  	    <input type="hidden" name="todocomplete" id="todocomplete" value="true" />
  	    <button name="todocomplete" id="taskbtn" class="button checkbox taskselbtn taskcompadj" type="submit"><i class="icon-ok todorestoreicon btnadj2"></i></button>
  	    </form>

    </span>
    
    <span id="taskitem"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <span class="badge badge-info"><?php comments_number( '0', '1', '%' ); ?> Comments</span>
     <span class="taskitem"><?php if ($todoassigned == ''){} else { echo 'due by '.$newtododeadline2.''; } ?> <?php if ($todoassigned == ''){} else { echo 'Assigned to: <a href="">'.$todoassignedname.'</a><br/>'; }  ?></span></span>
 	

                	
    <?php } ?>
                	
                	
                	</div>			 
            	    </li>
            	    <?php $i++; ?>
            	    <?php endwhile; ?>
					</ul>
	
					<?php else: ?>
					
					<p class="margintop15down">Não há tarefas registradas ainda.</p>

					<?php endif; ?>
				
	</div>	
			</div>					


  
    <!-- DEADLINE PROJECT Modal -->
  <div class="modal fade" id="addtodo">
    <div class="modal-dialog">
       <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Adicionar Tarefa</h4>
        </div>
        <div class="modal-body">
          
		    <!--BEGIN CONTACT FORM-->
		    <div id="contact-form">
			<form action="" class="marginbottom0" name="todossubmitted" id="todossubmitted" method="POST">
		      
		 		   
		  	
   				<div id="project-tasks-form">
 
    					<div class="form-section" id="project-tasks-form-section">
  	 				 	<fieldset>
						<label for="todospostTitle"><?php _e('Nova tarefa:', 'framework') ?></label>
 	 					<input name="todospostTitle" id="todospostTitle" class="span4 required height30" value="" placeholder="New Task" type="text">

  	  					</fieldset>
  						</div>
    
  	 	 				<?php if ( isset($todospostTitleError) && ($todospostTitleError != '' )) { ?>
  	      					<span class="error"><?php echo $todospostTitleError; ?></span>
  	      					<div class="clear"></div>
  	  					<?php } ?> 
  	
  	
 	 					<div class="form-section" id="project-tasks-form-section">
  	 				 	<fieldset>
  	      				<label for="todospostContent"><?php _e( 'Observações:', 'framework' ); ?></label>
  	      				<textarea name="todospostContent" id="todospostContent" class="width97 height60" id="wysiwyg" rows="8" cols="30"><?php if(isset($todospostcontent)) echo $todospostcontent; ?></textarea>
  	  					</fieldset>
  	  					</div>
  						
  						<div class="clearfix">
 						<div class="one-half column-">
 						<!-- BEGIN DEADLINE -->
						<div class="clearfix">    	  
				  		<label for="it_todo_deadline" class="clearfix"><?php _e('Deadline:', 'framework') ?></label>	  
					      <div class="form-section">
							<fieldset class="width100px floatleft">
			
			  	    	<input type="text" name="todo_deadline_date" id="todo_deadline_date" value="<?php if (isset($tododeadline)){ echo $tododeadline;} ?>" placeholder="enter deadline here" class="MyDate height30"/>				
							
							</fieldset>
							</div>		  		
					  	<!-- END DEADLINE -->	
					  	</div>
 						</div>
	
	
						<div class="one-half column-last">
	    				<span class="clearfix">Para quem essa tarefa será atribuída?</span>
						<div class="form-section">
						<fieldset>

							<?php $args = array(
							    'show_option_all'         => null, // string
							    'show_option_none'        => null, // string
							    'hide_if_only_one_author' => null, // string
							    'orderly'                 => 'display_name',
							    'order'                   => 'ASC',
							    'include'                 => null, // string
							    'exclude'                 => ''.$clientids.'',
							    'multi'                   => false,
							    'show'                    => 'display_name',
							    'echo'                    => true,
							    'selected'                => false,
							    'include_selected'        => false,
							    'name'                    => 'it_todo_assigned', // string
							    //'id'                      => null, // integer
							    'class'                   => null, // string 
							    //'blog_id'                 => $GLOBALS['blog_id'],
							    'who'                     => null // string
							); ?>


						<?php wp_dropdown_users( $args ); ?>
						</fieldset> 
  	  					</div>
  	  					</div>
  						</div>
  	  					

   				</div>
		  		
		  	<!-- END CONTACT FORM -->
			</div>
          
        </div>
        <div class="modal-footer">
  	      <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
  	      <input type="hidden" name="postid" id="postid" value="<?php if(isset($postid)) echo $postid; ?>" />
  	      <input type="hidden" name="todossubmitted" id="todossubmitted" value="true" />
  					<input type="hidden" name="url" id="url" value="<?php echo $projlive; ?>" />
  	      <button name="todossubmitted" class="button blue clearfix" type="submit"><?php _e( 'Adicionar', 'framework'); ?></button>
  		  </form>
        
        </div><!-- /.modal-footer -->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  

  


<?php wp_reset_query(); ?>

 			 
 			 <hr/>

 			 <div class="post-text well" id="projsection">
             <h3 id="projsub" class="margintop0"><i class="icon-comment margintop2down"></i> Comentários </h3>
     
             <?php comments_template(); ?>

 			 </div>


    
</article><!-- /post -->
   
  
<?php
//end post loop
endwhile; endif;

//get template footer
get_footer(); ?>
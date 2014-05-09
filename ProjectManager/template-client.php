<?php
/**
 * Project Manager
 * Template Name: Clientes
 */

//get theme options
global $it_data;

//get template header
get_header();
$pagetitle = $it_data['user_client_title']; 
if ($pagetitle == '') { $pagetitle="Clients"; }
require_once ( 'includes/body-top.php' );

//posts per page
$template_posts_per_page = get_post_meta($post->ID, 'it_template_posts_per_page', true);

//get meta data
$clienturl = $it_data['user_client_profile_page'];
$use_user_avatar = $it_data['use_user_avatar'];
$passwordgenerator = $it_data['password_generator'];

//grid style
$staff_grid_style = get_post_meta($post->ID, 'it_grid_style', true); //get grid style meta
$staff_grid_class = it_grid($staff_grid_style); //set grid style

//grid image height
$staff_grid_image_height_meta = get_post_meta($post->ID, 'it_grid_image_height', true);
($staff_grid_image_height_meta) ? $staff_grid_image_height = 450 * str_replace('%', '', $staff_grid_image_height_meta) / 100 : $staff_grid_image_height = 450;


$new = false;
$demo = false;

if ($demo == true){ } else {



if(isset($_POST['addclient']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {


	// first name
	if(trim($_POST['first-name']) === '') {
		$postFirstNameError = 'Please enter a first name.';
		$hasError = true;
	} else {
		$firstname = trim($_POST['first-name']);
		$display = $firstname;
		$user_name1 = $firstname;
		$user_name = preg_replace('/\s+/', '', $user_name1);
	}


	// email
	if(trim($_POST['email']) === '') {
		$postEmailError = 'Please enter an email address.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}


	// password 1
	if(trim($_POST['pass1']) === '') {
		$postNameError = 'Please enter a name.';
		$hasError = true;
	} else {
		$pass1 = trim($_POST['pass1']);
	}


	// password 2
	if(trim($_POST['pass2']) === '') {
		$postNameError = 'Please enter a name.';
		$hasError = true;
	} else {
		$pass2 = trim($_POST['pass2']);
	}


	// if they match - set password
	if ($pass1 == $pass2){ $password = $pass1; }


$user_id = username_exists( $user_name );

if ( !$user_id and email_exists($email) == false ) {
	//$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
	$user_id = wp_create_user( $user_name, $password, $email );
	
	
if($user_id)
	{
		
	update_user_meta( $user_id, 'first_name', $firstname );
	wp_update_user( array ('ID' => $user_id, 'role' => 'client', 'display_name' => $display) ) ;
	

	//wp_redirect(home_url());
	//exit;
	
	$new = true;
	$firstname = '';
	$display = '';
	$user_name = '';
	$email = '';
	
}
	
} else {
	//$random_password = __('User already exists.  Password inherited.');
	
		$postNameError = 'Please enter a new client name, that one already exists.';
		$hasError = true;
	
}

} // END IF


} // end if demo

?>

<div id="post">



	<div class="btnadj3">

<?php if ($isadmin == true){ ?>
		<a href="<?php echo $addclientpage; ?>" class="btn btn-primary">Adicionar Cliente</a>
<?php } ?>
	</div>


<?php

if ($new == true) {
	
	?>
		<div class="alert alert-success alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Pronto!</strong> Você adicinou um cliente novo!
		</div>
	<?php
	
}

//show page content if not empty
$content = $post->post_content;
if(!empty($content)) { ?>
	<div id="staff-description">
    	<?php the_content(); ?>
    </div><!-- /staff-description -->
<?php }?>

<div id="staff-template" class="clearfix">

	<div class="grid-container clearfix">
		<?php
        //get posts ==> staff
        $args = array(
			'role' => 'client',
			'meta_key' => '',
			'meta_value' => '',
			'meta_compare' => '',
			'include' => array(),
			'exclude' => array(),
			'search' => '',
			'orderby' => 'login',
			'order' => 'ASC',
			'offset' => '',
			'number' => '',
			'count_total' => true,
			'fields' => 'all',
			'who' => ''	
		);

		// The Query
		$user_query = new WP_User_Query( $args );     

		// User Loop
		if ( !empty( $user_query->results ) ) { ?>
		
		<?php
		foreach ( $user_query->results as $user ) {

			global $it_staff_counter, $staff_grid_class, $staff_grid_image_height; //global variables
			$staff_grid_image_width = '';
			
			//setup counter to use for clearing floats
			$staff_column_number = str_replace('grid-','',$staff_grid_class);
			
			//start counting
			$it_staff_counter++;
						
			//featured image
			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url($thumb,'full'); //get full URL to image	
			
			//set image width
		//	($staff_grid_class == 'grid-2') ? $staff_grid_image_width = 450 : $staff_grid_image_width = 390;

			//get user role
	//		$user_wp_capabilities = get_the_author_meta( 'wp_capabilities', $user->ID );
	//		$user_role = array_search('1', $user_wp_capabilities); 			
			
			//resize & crop image
			$featured_image = aq_resize( $img_url, $staff_grid_image_width, $staff_grid_image_height, true );
			
			if ($use_user_avatar == 'enable') {
				
			//	$avatar = get_wp_user_avatar( $user->ID, 232 );
				$avatar = get_avatar( $user->user_email, 232 );
			
			} else {
			
				$avatar = get_avatar( $user->user_email, 232 );

			}

			

			?>
			<div class="col-md-3">
			    <a href="<?php echo $clienturl; ?>/?user_id=<?php echo $user->ID; ?>" title="<?php the_title(); ?>" class="staff-entry-img-link">
			        <?php echo $avatar; ?>
			    </a>
				<div class="staff-entry-description">
			    	<div class="staff-entry-header">
			            <h3 class="margintop0"><a href="<?php echo $clienturl; ?>/?user_id=<?php echo $user->ID; ?>" title="<?php echo ''.$user->display_name.''; ?>"><?php echo ''.$user->display_name.''; ?></a></h3>
			        </div><!-- /staff-entry-header -->
			        <?php
/*
					//show description if not empty
					if(!empty($user->user_description)) { ?>
			            <div class="staff-entry-excerpt">
			                <?php echo $user->user_description; ?>
			            </div><!-- /staff-entry-excerpt -->
						<?php

			        	} //no excerpt
*/
					?>
				</div><!-- /staff-entry-description -->
			</div><!-- /staff-entry -->
			<?php if($it_staff_counter == $staff_column_number) { echo '<div class="clear"></div>'; $it_staff_counter=0; } ?>
			

<?php

		} //end for each
			
		} else {
			?>
		<div class="alert alert-warning alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <strong>Desculpe!</strong> Você ainda não tem clientes cadastrados.
		</div>
			<?php

		}
        
?>

   	</div><!--/grid-container -->
    <?php
	//show page pagination
	pagination();
	//reset custom query
	wp_reset_query(); ?>
</div><!-- /staff-wrap -->

</div>
<?php

//get template footer
get_footer(); ?>
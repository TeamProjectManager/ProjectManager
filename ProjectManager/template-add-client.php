<?php
/**
 * Template Name: Adicionar Cliente
 */
 
//get theme options
global $it_data;

//get meta data
$clienturl = $it_data['user_client_profile_page'];
$clientpage = $it_data['user_client_page'];
$use_user_avatar = $it_data['use_user_avatar'];
$passwordgenerator = $it_data['password_generator'];	

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
	

	wp_redirect($clientpage);
	exit;
	
	$new = true;
	$firstname = '';
	$display = '';
	$user_name = '';
	$email = '';
	
}
	
} else {
	//$random_password = __('User already exists.  Password inherited.');
	
		$postNameError = 'Por favor insira um novo nome do cliente, pois esse já existe.';
		$hasError = true;
	
}

} // END IF


} // end if demo


//get template header
get_header();
$pagetitle = $it_data['user_add_clients_title']; 
if ($pagetitle == '') { $pagetitle="Add a Client"; }
require_once ( 'includes/body-top.php' );


    
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

    <header id="page-heading">
        <h1><?php the_title(); ?></h1>		
    </header><!-- /page-heading -->
    
    <article id="post" class="clearfix">
        <div class="entry clearfix">	
            <?php the_content(); ?>
            
            
           
    <div id="contact-form" class="margintop20">
                <form method="post" id="addclient" action="<?php the_permalink(); ?>">
                    <p class="form-username marginbottom10">
                        <label for="first-name"><?php _e('Nome do Cliente', 'profile'); ?></label>
                        <input class="text-input width50 largeform" name="first-name" type="text" id="first-name" value="" required/>
                    </p><!-- .form-username -->
 
 
 			<?php if(isset($postNameError) && ($postNameError != '')) { ?>
				<span class="error"><?php echo $postNameError; ?></span>
				<div class="clearfix">There is something wrong with your name.</div>
			<?php } ?>
 
                    <p class="form-email marginbottom10">
                        <label for="email"><?php _e('E-mail *', 'profile'); ?></label>
                        <input class="text-input width50 largeform" name="email" type="text" id="email" value="" required/>
                    </p><!-- .form-email -->
 
 <?php 	if ($passwordgenerator == 'enable') { } else { ?>

                  <p class="form-password marginbottom10">
                        <label for="pass1"><?php _e('Senha *', 'profile'); ?> </label>
                        <input class="text-input width50 medform" name="pass1" type="password" id="pass1" required/>
                    </p><!-- .form-password -->
                    <p class="form-password">
                        <label for="pass2"><?php _e('Repita a Senha *', 'profile'); ?></label>
                        <input class="text-input width50 medform" name="pass2" type="password" id="pass2" required/>
                    </p><!-- .form-password -->

<?php } // end if password ?>

                    
		 <div class="form-actions">
					<fieldset>
						<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
						<input type="hidden" name="addclient" id="submitted" value="true" />
						<button class="btn" type="submit"><?php _e('Adicionar Cliente', 'framework') ?></button>
					</fieldset>
			</div>
 
                </form><!-- #adduser -->
		</div>
     			 
            
            
            
            
            
        </div><!-- /entry -->       
    </article><!-- /post -->
    
   
<?php
//end post loop
endwhile; endif;


//get footer template
get_footer(); ?>
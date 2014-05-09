<?php
/**
 *  ProjectManager
 * Template Name: Adicionar Membro
 */

//get theme options
global $it_data;

$passwordgenerator = $it_data['password_generator'];
$staffurl = $it_data['user_profile_page'];
	
$demo = false;

if ($demo == true){ } else {


if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {


	// first name
	if(trim($_POST['first-name']) === '') {
		$postFirstNameError = 'Please enter a first name.';
		$hasError = true;
	} else {
		$newuser_firstname = trim($_POST['first-name']);
	}


	// last name
	if(trim($_POST['last-name']) === '') {
		$postLastNameError = 'Please enter a last name.';
		$hasError = true;
	} else {
		$newuser_lastname = trim($_POST['last-name']);
		
		$newuser_user_name = $newuser_firstname;
		//$user_name .= ' ';
		$newuser_user_name .= $newuser_lastname;
		
		$newuser_display = $newuser_firstname;
		$newuser_display .= ' ';
		$newuser_display .= $newuser_lastname;
	}


	// email
	if(trim($_POST['email']) === '') {
		$postEmailError = 'Please enter an email address.';
		$hasError = true;
	} else {
		$newuser_email = trim($_POST['email']);
	}


	if ($passwordgenerator == 'enable') {
		
		$password = wp_generate_password(12,false );
		
	} else {

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

	} // end password generator


	// description
	if(trim($_POST['description']) === '') {
	} else {
		$description = trim($_POST['description']);
	}


	// userrole
	$role = "administrator";


	$newuser_id = username_exists( $newuser_user_name );


	if ( !$newuser_id and email_exists($email) == false ) {
		$newuser_id = wp_create_user( $newuser_user_name, $password, $newuser_email );
	
		if($newuser_id)
			{
				
			update_user_meta( $newuser_id, 'first_name', $newuser_firstname );
			update_user_meta( $newuser_id, 'last_name', $newuser_lastname );
			update_user_meta( $newuser_id, 'description', $description );
			wp_update_user( array ('ID' => $newuser_id, 'role' => $role, 'display_name' => $newuser_display) ) ;
			
			$redirect = $staffurl;
			$redirect .= '/?user_id=';
			$redirect .= $newuser_id;
			
			wp_redirect(''.$redirect.'');
			exit;
			
			$new = true;
			
		}
	
	} else {
	
		$postNameError = 'Please enter a new user name, that one already exists.';
		$hasError = true;
	
	}


} // END IF

} // end if demo



//get template header
get_header();
$pagetitle = $it_data['user_add_users_title']; 
if ($pagetitle == '') { $pagetitle="Add a Team Member"; }
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


    
    <article id="post" class="clearfix">
        <div class="entry clearfix">	
            <?php the_content(); ?>
            
            
            
            
         <div id="contact-form">		
                <form method="post" id="adduser" action="<?php the_permalink(); ?>">

			<!-- TITLE -->
			<h3><span>Informações do Perfil</span></h3>
			
			<fieldset>
                <label for="first-name"><?php _e('Nome', 'profile'); ?></label>
				<input type="text" name="first-name" id="first-name" value="<?php if(isset($_POST['first-name'])) echo $_POST['first-name'];?>" class="required width50 bigform"/>
				
                <label for="last-name"><?php _e('Sobrenome', 'profile'); ?></label>
	            <input class="width50 bigform" name="last-name" type="text" id="last-name" value="<?php if(isset($_POST['last-name'])) echo $_POST['last-name'];?>" />
			
			</fieldset>
			
 			<?php if(isset($postNameError) && ($postNameError != '')) { ?>
				<span class="error"><?php echo $postNameError; ?></span>
				<div class="clearfix">There is something wrong with your name.</div>
			<?php } ?>
			
						
			<!-- EMAIL -->
                     <p class="form-email">
                        <label for="email"><?php _e('E-mail *', 'profile'); ?></label>
                        <input class="text-input width50 bigform" name="email" type="text" id="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" required/>
                    </p><!-- .form-email -->
 
 					<p class="form-textarea">
                        <label for="description"><?php _e('Descrição do Usuário', 'profile') ?></label>
                        <textarea class="width50" name="description" id="description"  rows="3" cols="50"><?php if(isset($_POST['description'])) echo $_POST['description'];?></textarea>
                    </p><!-- .form-textarea -->


<?php 	if ($passwordgenerator == 'enable') { } else { ?>
			<h3><span>Senha</span></h3>

                   <p class="form-password">
                        <label for="pass1"><?php _e('Senha *', 'profile'); ?> </label>
                        <input class="text-input width50 largeform" name="pass1" type="password" id="pass1"/>
                    </p><!-- .form-password -->
                    <p class="form-password">
                        <label for="pass2"><?php _e('Repita a Senha *', 'profile'); ?></label>
                        <input class="text-input width50 largeform" name="pass2" type="password" id="pass2"/>
                    </p><!-- .form-password -->

<?php } // end if password ?>

                    <br/>
                    <br/>
                    
 <div class="form-actions">
			<fieldset>
				<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
				<input class="width50" type="hidden" name="submitted" id="submitted" value="true" />
				<button type="submit" class="button giant blue height50"><span class="button-inner bordertop0"><?php _e('Adicionar', 'framework') ?></span></button>
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
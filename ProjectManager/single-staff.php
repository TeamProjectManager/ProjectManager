<?php
ob_flush();
/**
 * Project Manager
 * Template Name: Membro do time - Single
 */

//global variables
global $it_data;

//get template header
get_header();
$pagetitle = $it_data['user_profile_title']; 
if ($pagetitle == '') { $pagetitle="Team Member"; }
require_once ( 'includes/body-top.php' );


    if ( current_user_can( 'manage_options' ) ) {
    	$isadmin = true;
	} else {
    	$isadmin = false;
    			// for demo
		// $isadmin = true;

	}

$demo = false;

if ($demo == true){ } else {



if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {


  //  if ( !empty( $_POST['id'] ) ){ $userid = $_POST['id']; }
	if (isset($_GET['user_id'])) { $userid = $_GET['user_id']; }
	if (isset($_GET['oldemail'])) { $oldemail = $_GET['oldemail']; }

//	echo $userid;
//	exit();


    // Update user password. 
    if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
        if ( $_POST['pass1'] == $_POST['pass2'] )
            wp_update_user( array( 'ID' => $userid, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
        else
            $error[] = __('The passwords you entered do not match.  Your password was not updated.', 'profile');
    }
    
//    get_the_author_meta( $field, $userID );

    // Update user information. 
    if ( !empty( $_POST['url'] ) )
        update_user_meta( $userid, 'user_url', esc_url( $_POST['url'] ) );
        
    if ( !empty( $_POST['email'] ) ){
        if (!is_email(esc_attr( $_POST['email'] ))){
            $error[] = __('The Email you entered is not valid.  please try again.<br/>', 'profile');
        } elseif( isset($oldemail) && (email_exists(esc_attr( $_POST['email'] )) != $oldemail )) {
//        elseif(email_exists(esc_attr( $_POST['email'] )) !== $userid )
//            $error[] = __('This email is already used by another user.  try a different one.<br/>', 'profile');
        } else{
            wp_update_user( array ('ID' => $userid, 'user_email' => esc_attr( $_POST['email'] )));
        }
    }


    $role="administrator";

    if ( !empty( $_POST['first-name'] ) )
        update_user_meta( $userid, 'first_name', esc_attr( $_POST['first-name'] ) );
    if ( !empty( $_POST['last-name'] ) )
        update_user_meta($userid, 'last_name', esc_attr( $_POST['last-name'] ) );

	   	$displayname = $_POST['first-name'];
		$displayname .= " ";
	    $displayname .= $_POST['last-name'];
	   	$nickname = $_POST['first-name'];
	    $nickname .= $_POST['first-name'];
    	
    	wp_update_user( array ('ID' => $userid, 'display_name' => $displayname ));
    	wp_update_user( array ('ID' => $userid, 'user_nicename' => $nickname ));
        update_user_meta( $userid, 'nickname', $nickname );


    if ( !empty( $_POST['description'] ) )
        update_user_meta( $userid, 'description', esc_attr( $_POST['description'] ) );



        if (empty($_FILES['user_img']['name'])) {} else {
        
	        foreach ($_FILES as $file => $array) {
		    $attach_id = insert_attachment( $file, 'none', '' ); 
		    update_user_meta( $userid, $wpdb->get_blog_prefix($blog_id).'user_avatar', $attach_id );
		    		    
		    }
		
		}
		
		

    // Redirect so the page will show updated info
    if ( count($error) == 0 ) {
        //action hook for plugins and extra fields saving
        do_action('edit_user_profile_update', $userid);
      //  wp_redirect( get_permalink() );
      //  exit;
      wp_redirect($_SERVER['REQUEST_URI']);
		exit;
    }

}





} // end if demo

//get post data from URL
$userid = $_GET['user_id'];
$oldemail = '';
if (isset($_GET['oldemail'])) { $oldemail = $_GET['oldemail']; }

//set error array
$error = array();    

//get meta data

		$user_loginname = get_the_author_meta( 'user_login', $userid );
		$user_name = get_the_author_meta( 'display_name', $userid );
		$user_firstname = get_the_author_meta( 'first_name', $userid );
		$user_lastname = get_the_author_meta( 'last_name', $userid );
		$user_description = get_the_author_meta( 'description', $userid );
		$user_email = get_the_author_meta( 'user_email', $userid );
		$user_admin_color = get_the_author_meta( 'admin_color', $userid );
		$user_status = get_the_author_meta( 'user_status', $userid );
		$user_user_description = get_the_author_meta( 'user_description', $userid );
		$user_url = get_the_author_meta( 'user_url', $userid );
		$avatar	= get_avatar( $user_email, 256 );

?>

<header>
    <h1 class="header margintop20"><?php echo $user_name; ?></h1>	
</header><!-- /post-meta -->


<div id="post" class="staff-post clearfix">

    <article id="staff-entry" class="entry clearfix">

        <div id="staff-post-thumbnail">
           <?php echo $avatar; ?>
        </div><!-- /staff-post-thumbnail -->

        <?php
		//show user content
        echo '<div class="clearfix marginbottom20">
			
		<h3 class="marginbottom0">'.$user_loginname.'</h3>
		<span>'.$user_email.'</span> 
		<br/><br/>
		<strong class="blacktext">About '.$user_firstname.':</strong><p>'.$user_description.'</p>
		</div>';
	
        
        ?>


<h3><?php echo $user_firstname; ?>'s Assigned Projects</h3>
 

 
<?php

						
				   $curuser = ':"';
				   $curuser .= $userid;
				   $curuser .= '";';
					
					
					$args = array(
					    'orderly' => 'title',
					    'order' => 'ASC',
					    'show posts' => '-1', 
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

$wp_query_assigned = new WP_Query($args); 

           if ( $wp_query_assigned->have_posts() ) :

			echo '<ul class="plainlist">';
			
            while ($wp_query_assigned->have_posts()) : $wp_query_assigned->the_post();

			echo '<li><a href="'; echo !empty( $custom['_portfolio_link'][0] ) ? $custom['_portfolio_link'][0] : the_permalink(); echo '">'; the_title(); echo '</a></li>';
			
			endwhile; ?>
			
            </ul>
                
            <?php else : ?>
                
            <p><?php echo $user_firstname; ?> has no assigned projects.</p>
                
            <?php endif; 





if ($current_user_email == $user_email){// if user is the one logged in
?>

<div class="clearfix"></div>


	<div class="span6">

	<h3 class="margintop20">Edit User</h3>

    <div id="contact-form">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>">
        <div class="entry-content entry">
            <?php the_content(); ?>
            <?php if ( !is_user_logged_in() ) : ?>
                    <p class="warning">
                        <?php _e('You must be logged in to edit your profile.', 'profile'); ?>
                    </p><!-- .warning -->
            <?php else : ?>
                
                <?php if ( count($error) > 0 ) echo '<p class="error">' . implode("<br />", $error) . '</p>'; ?>
                
                <form method="post" id="adduser" action="" enctype="multipart/form-data">
                <p class="edituserp">Username: <?php echo $user_loginname; ?> <span><em>(You cannot change this)</em></span></p>
                    <p class="form-username marginbottom10">
                        <label for="first-name"><?php _e('First Name', 'profile'); ?></label>
                        <input class="text-input bigform" name="first-name" type="text" id="first-name" value="<?php echo $user_firstname; ?>"/>
                    </p><!-- .form-username -->
                    <p class="form-username marginbottom10">
                        <label for="last-name"><?php _e('Last Name', 'profile'); ?></label>
                        <input class="text-input bigform" name="last-name" type="text" id="last-name" value="<?php echo $user_lastname; ?>"/>
                    </p><!-- .form-username -->
                    <p class="form-email marginbottom10">
                        <label for="email"><?php _e('E-mail *', 'profile'); ?></label>
                        <input class="text-input bigform" name="email" type="text" id="email" value="<?php echo $user_email; ?>"/>
                    </p><!-- .form-email -->


                    <p class="form-textarea width360 marginbottom10">
                        <label for="description"><?php _e('Biographical Information', 'profile') ?></label>
                        <textarea name="description" id="description" rows="3" cols="50" class="extraform"><?php echo $user_user_description; ?></textarea>
                    </p><!-- .form-textarea -->

					<h4>Update Password <em>(optional)</em></h4>

                    <p class="form-password marginbottom10">
                        <label for="pass1"><?php _e('Password *', 'profile'); ?> </label>
                        <input class="text-input largeform" name="pass1" type="password" id="pass1"/>
                    </p><!-- .form-password -->
                    <p class="form-password marginbottom10">
                        <label for="pass2"><?php _e('Repeat Password *', 'profile'); ?></label>
                        <input class="text-input largeform" name="pass2" type="password" id="pass2"/>
                    </p><!-- .form-password -->
                    
                    
                    <?php 
                    $use_user_avatar = $it_data['use_user_avatar'];
                    if ($use_user_avatar == 'disable') { } else {
                    ?>
                    
                    <h4 class="heading"><span>Current Avatar</span></h4>
                    <?php
                    
                    echo get_wp_user_avatar($userid, '96', 'left');
                    
                    ?>
                    
                    <div id="contact-form" class="clear">		

					<br/>

					<div class="testimony-content height20">
									<!-- images -->
									<fieldset class="images">
										<label for="images">Upload File</label>
										<input type="file" name="user_img" id="project_img" size="50" class="picinput">
										</fieldset>
										
										<br/>
					</div>

							</div>

					<?php } // end use user avatar ?>
                                        
                    <div class="clearfix"></div>
                    <br/>
                    <br/>

                    
                    <p class="form-actions width100 margintop40">

                        <input name="update user" type="submit" id="update user" class="submit button blue normal" value="<?php _e('Update User Profile', 'profile'); ?>" />
                        <?php wp_nonce_field( 'update-user' ) ?>
                        <input name="action" type="hidden" id="oldemail" value="<?php echo $user_email; ?>" />
                        <input name="action" type="hidden" id="id" value="<?php echo $userid; ?>" />
                        <input name="action" type="hidden" id="action" value="update-user" />
                    </p><!-- .form-submit -->
                </form><!-- #adduser -->
           <?php endif; ?>
        </div><!-- .entry-content -->
    </div><!-- .hentry .post -->
    <?php endwhile; ?>
<?php else: ?>
    <p class="no-data">
        <?php _e('Sorry, no page matched your criteria.', 'profile'); ?>
    </p><!-- .no-data -->
<?php endif; ?>
</div>

	</div>
<?php
} // end if user is the one logged in
		

?>
      
    </article><!-- /entry -->
    
    
    
    
    
    
</div><!-- /post -->

<?php
  
//get template footer
get_footer(); ?>
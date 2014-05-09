<?php
/**
 * ProjectManager
 * Template Name: Página do Time
 */

//get theme options
global $it_data;

//get template header
get_header();
$pagetitle = $it_data['user_team_title']; 
if ($pagetitle == '') { $pagetitle="My Team"; }
require_once ( 'includes/body-top.php' );

//posts per page
$template_posts_per_page = get_post_meta($post->ID, 'it_template_posts_per_page', true);

//get meta data
$staffurl = $it_data['user_profile_page'];
$adduserurl = $it_data['user_add_users'];
$use_user_avatar = $it_data['use_user_avatar'];

//grid style
$staff_grid_style = get_post_meta($post->ID, 'it_grid_style', true); //get grid style meta
$staff_grid_class = it_grid($staff_grid_style); //set grid style

//grid image height
$staff_grid_image_height_meta = get_post_meta($post->ID, 'it_grid_image_height', true);
($staff_grid_image_height_meta) ? $staff_grid_image_height = 450 * str_replace('%', '', $staff_grid_image_height_meta) / 100 : $staff_grid_image_height = 450;

?>

<div id="post">
<?php
//show page content if not empty
$content = $post->post_content;
if(!empty($content)) { ?>
	<div id="staff-description">
    	<?php the_content(); ?>
    </div><!-- /staff-description -->
<?php }?>

<div id="staff-template" class="clearfix">


	<div class="btnadj4">

<?php if ($isadmin == true){ ?>
		<a href="<?php echo $adduserurl; ?>" class="btn btn-primary">Adicionar Um Novo Membro</a>
<?php } ?>
	</div>
	

	<div class="grid-container clearfix">
		<?php
        //get posts ==> staff
        $args = array(
			'role' => '',
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
			// $user_wp_capabilities = get_the_author_meta( 'wp_capabilities', $user->ID );
			// $user_role = array_search('1', $user_wp_capabilities); 			
			
			//resize & crop image
			$featured_image = aq_resize( $img_url, $staff_grid_image_width, $staff_grid_image_height, true );
			
			//get avatar
			if ($use_user_avatar == 'enable') {
				
				$avatar = get_wp_user_avatar( $user->ID, 232 );
			
			} else {
			
				$avatar = get_avatar( $user->user_email, 232 );

			}

			?>
			<div class="col-md-3 <?php if ($user_role == "client") { echo ' displaynone'; $it_staff_counter = ($it_staff_counter - 1); } ?>">
			    <a href="<?php echo $staffurl; ?>/?user_id=<?php echo $user->ID; ?>" title="<?php the_title(); ?>" class="staff-entry-img-link">
			        <?php echo $avatar; ?>
			    </a>
				<div class="staff-entry-description">
			    	<div class="staff-entry-header">
			            <h3 class="margintop0"><a href="<?php echo $staffurl; ?>/?user_id=<?php echo $user->ID; ?>" title="<?php echo ''.$user->display_name.''; ?>"><?php echo ''.$user->display_name.''; ?></a></h3>
			        </div><!-- /staff-entry-header -->
			        <?php

					//show description if not empty
					if(!empty($user->user_description)) { ?>
			            <div class="staff-entry-excerpt">
			                <?php //echo ''.$user->user_description.''; ?>
			            </div><!-- /staff-entry-excerpt -->
						<?php

			        	} //no excerpt

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
		  <strong>Sorry!</strong> You have no users added yet.
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
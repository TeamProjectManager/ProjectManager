<?php
/**
 * IcarusThemes
 */
 
//global variables
global $it_data, $it_counter;
$it_counter++;
$today = date(get_option('date_format'));

   wp_get_current_user();
    /**
     * @example Safe usage: $current_user = wp_get_current_user();
     * if ( !($current_user instance of WP_User) )
     *     return;
     */
    global $current_user_username;

    $user_role = get_user_role();

  if (isset($it_data['translation_administrator']) && ($it_data['translation_administrator'] !== '')) { $adminword = $it_data['translation_administrator']; global $adminword; } else { $adminword = 'administrator'; global $adminword; }
if (isset($it_data['translation_editor']) && ($it_data['translation_editor'] !== '')) { $editorword = $it_data['translation_editor']; global $editorword; } else { $editorword = 'editor'; global $editorword; }
if (isset($it_data['translation_client']) && ($it_data['translation_client'] !== '')) { $clientword = $it_data['translation_client']; global $clientword; } else { $clientword = 'client'; global $clientword; }
   
    if ( current_user_can( 'manage_options' ) ) {
    	$isadmin = true;
	} else {
    	$isadmin = false;
    			// for demo
		//$isadmin = true;

	}

	if ($user_role == "$clientword") {	
		$isclient = true;
	} else {
		$isclient = false;	
	}
	


//get client meta
$projectsclient = '';
$projectsclient = get_post_meta($post->ID, 'it_projects_client', true);

//get deadline meta
$deadline = get_post_meta($post->ID, 'it_projects_deadline', true);
$newdeadline2 = date("F j, Y", strtotime($deadline));

//get the date
$postdate = get_the_date();
	
			$strtoday = strtotime($today);
			$strdeadline = strtotime($deadline);
			$stdate = strtotime($postdate);
						
			if ($strtoday > $strdeadline) { $overdue = '1'; } else { $overdue = '2'; }		
			
						$diff = abs($stdate - strtotime($deadline));
						$todate = (strtotime($today) - $stdate) / (60 * 60 * 24);
						$totaldays = (strtotime($deadline) - $stdate) / (60 * 60 * 24);
						// TOTAL SUM
						$complete = ceil(($todate / $totaldays) * 100);					
												
						$years = floor($diff / (365*60*60*24));
						$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
						$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

//get the project owner
$ownerid = get_post_meta($post->ID, 'it_projects_assigned', true);
$assignedname = get_the_author_meta( 'display_name', $ownerid );

//get categories
$terms = get_the_terms( get_the_ID(), 'projects_cpt_cats' );
$terms_list = get_the_term_list( get_the_ID(), 'projects_cpt_cats' );
	
//get complete status
$iscomplete = '';
$iscomplete = get_post_meta($post->ID, 'it_show_project_complete', true);
		   
		  if (($overdue == '1') && ($iscomplete !== 'yes')) {
		
			$border_color = "#eed3d7";
						
		  } elseif (($overdue == '1') && ($iscomplete == 'yes')) {
			   
			 $border_color = "#3c763d";

		  } elseif (($overdue !== '1') && ($iscomplete !== 'yes')) {

			 $border_color = "#bce8f1";
	
		  } elseif (($overdue !== '1') && ($iscomplete == 'yes')) {
		
			 $border_color = "#3c763d";
		
		  } ?>

<li data-id="id-<?php echo $it_counter; ?>" data-type="<?php if($terms) { foreach ($terms as $term) { echo $term->slug .' '; } } else { echo 'none'; } ?>" class="portfolio-post <?php if ($isclient == true) { if ($projectsclient != $current_user_username) { echo 'displaynone'; } } ?>">


    <div class="portfolio-post-description">
        	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="border-left:4px solid <?php echo $border_color; ?>">
        	<h2>
        		<?php the_title(); ?>
        		</h2>
        		<?php
        		if ( $terms && ! is_wp_error( $terms ) ) : 
				foreach ( $terms as $term ) {
					echo '<a href="#" class="termname hiddenphone">'.$term->name.'</a>';
				}
			endif;
			?>
        		<span class="newdeadline hiddenphone"><icon class="icon-calendar margintop4down"></icon> <?php echo $newdeadline2; ?></span>
        	
			</a>

    </div><!-- .portfolio-post-description -->
    
</li><!-- /portfolio-post -->

<?php
/**
 * Project Manager
 */

/*
if ( ! is_admin() ) {
require('wp-blog-header.php');
$user_login = 'baileyjones';
$user = get_userdatabylogin($user_login);
$user_id = $user->ID;
wp_set_current_user($user_id, $user_login);
wp_set_auth_cookie($user_id);
do_action('wp_signon', $user_login);

} else {

}

*/

//URI Shortcuts
define( 'it_FRAMEWORK_DIR', get_template_directory_uri().'/framework' );
define( 'it_JS_DIR', get_template_directory_uri().'/js' );
define( 'it_CSS_DIR', get_template_directory_uri().'/css' );




/*--------------------------------------*/
/* Include required framework files
/*--------------------------------------*/

require_once('library/post_types.php');
require_once('library/taxonomies.php');
require_once('framework/it_framework.php');
require_once('library/admin_options.php');

if(is_admin() && basename($_SERVER['PHP_SELF']) != 'update-core.php'){
require('update-notifier.php');
}

//load css and js
require_once('library/scripts.php');
require_once('library/custom_css.php');

//load widgets
require_once('library/widget_areas.php');

//load only on admin
if(defined('WP_ADMIN') && WP_ADMIN ) {
	
	//main functions
	require_once('library/custom_post_menus.php');
	require_once('library/custom_sidebar_menus.php');	
	
}





/*--------------------------------------*/
/* Menu Setup
/*--------------------------------------*/

//menu walker
require_once('library/menu_walker.php');

//register navigation menus
register_nav_menus(
	array(
		'top_menu' => __('Top','it'),
		'client_menu' => __('Client','it'),
		'footer_menu' => __('Footer','it'),
		'responsive_top_menu' => __('Responsive Top','it'),
		'responsive_client_menu' => __('Responsive Client','it'),
	)
);
		
		
		


/*--------------------------------------*/
/* Misc Functions
/*--------------------------------------*/

//content width
$content_width = 1200; // Default width of primary content area
		
//add image sizes
if(function_exists('add_image_size')) {
	add_image_size('full-size',  9999, 9999, false);
	add_image_size('small-thumb',  90, 90, true);
}
		
//localization support - this is for changing the language
load_theme_textdomain( 'it', get_template_directory() .'/lang' );

//posts per page
require_once('library/pagination.php');




 		
		


/*--------------------------------------*/
/* Check Image Function - This comes in handy!
/*--------------------------------------*/

function has_image_attachment($post_id) {
	$args = array(
    	'post_type' => 'attachment',
    	'post_mime_type' => '',
        'numberposts' => -1,
        'post_status' => null,
        'post_parent' => $post_id
    ); 

    $attachments = get_posts($args);
	
    if(is_array($attachments) && count($attachments) > 0) {
       	//Has image attachments
    	    return true;
    			} else {
	    	return false;
    }
			
}






/*--------------------------------------*/
/* Blog/Excerpt Functions
/*--------------------------------------*/

//post excerpt length
function new_excerpt_length($length) {
	global $it_data;
	return $it_data['blog_excerpt'];
}
add_filter('excerpt_length', 'new_excerpt_length');

//replace excerpt link
function new_excerpt_more($more) {
	global $post;
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');







/*--------------------------------------*/
/* Add Log For Debug Function
/*--------------------------------------*/

if(!function_exists('_log')){
  function _log( $message ) {
    if( WP_DEBUG === true ){
      if( is_array( $message ) || is_object( $message ) ){
        error_log( print_r( $message, true ) );
      } else {
        error_log( $message );
      }
    }
  }
}





/*--------------------------------------*/
/* Theme Specific Functions
/*--------------------------------------*/

/* Insert Attachment to post */

function insert_attachment($file_handler,$post_id,$setthumb='false') {
	// check to make sure its a successful upload
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');

	$attach_id = media_handle_upload( $file_handler, $post_id );

	if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
	return $attach_id;

}


/* Disable the admin bar from showing */

if (!function_exists('disableAdminBar')) {  
    function disableAdminBar(){  
    remove_action( 'admin_footer', 'wp_admin_bar_render', 1000 ); // for the admin page  
    remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 ); // for the front end  
    function remove_admin_bar_style_backend() {  // css override for the admin page  
      echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';  
    }  
    add_filter('admin_head','remove_admin_bar_style_backend');  
    function remove_admin_bar_style_frontend() { // css override for the frontend  
      echo '<style type="text/css" media="screen"> 
      html { margin-top: 0px !important; } 
      * html body { margin-top: 0px !important; } 
      </style>';  
    }  
    add_filter('wp_head','remove_admin_bar_style_frontend', 99);  
  }  
}  
// add_filter('admin_head','remove_admin_bar_style_backend'); // Original version  
add_action('init','disableAdminBar'); // New version 



/* Add Client Role Type */

$result = add_role('client', 'Client', array(
    'read' => true, // True allows that capability
    'edit_posts' => true,
    'delete_posts' => false, // Use false to explicitly deny
));

if (null !== $result) {

} else {

}



/* Find out User Role */

function get_user_role() {
    global $current_user;

    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);

    return $user_role;
}









/* RESTRICT ADMIN AREA BY USER ROLE */

function wpse_11244_restrict_admin() {
    if ( ! current_user_can( 'manage_options' )  && $_SERVER['PHP_SELF'] != '/wp-admin/admin-ajax.php' ) {
        wp_redirect( home_url() );
    }
}
add_action( 'admin_init', 'wpse_11244_restrict_admin', 1 );




/* CUSTOM EXCERPT AMOUNT */
function it_excerpt_length( $length ) {
	return 60;
}
add_filter( 'excerpt_length', 'it_excerpt_length' );



add_filter('user_can_richedit', '__return_true');




  
/* CALENDAR FUNCTION */

function projectpress_get_calendar( $post_types = '' , $client, $initial = true , $echo = true ) {
  global $wpdb, $m, $monthnum, $year, $wp_locale, $posts;
 
  
  if ( empty( $post_types ) || !is_array( $post_types ) ) {
    $args = array(
      'public' => true ,
      '_builtin' => false
    );
    $output = 'names';
    $operator = 'and';
 
    $post_types = get_post_types( $args , $output , $operator );
    $post_types = array_merge( $post_types , array( 'post' ) );
  } else {
    /* Trust but verify. */
    $my_post_types = array();
    foreach ( $post_types as $post_type ) {
      if ( post_type_exists( $post_type ) )
        $my_post_types[] = $post_type;
    }
    $post_types = $my_post_types;
  }
  $post_types_key = implode( '' , $post_types );
  $post_types = "'" . implode( "' , '" , $post_types ) . "'";
 
  $post_types = "'projects_cpt' , 'todos'";

 
  $cache = array();
  $key = md5( $m . $monthnum . $year . $post_types_key );
  if ( $cache = wp_cache_get( 'get_calendar' , 'calendar' ) ) {
    if ( is_array( $cache ) && isset( $cache[$key] ) ) {
      remove_filter( 'get_calendar' , 'projectpress_get_calendar_filter' );
      $output = apply_filters( 'get_calendar',  $cache[$key] );
      add_filter( 'get_calendar' , 'projectpress_get_calendar_filter' );
      if ( $echo ) {
        echo $output;
        return;
      } else {
        return $output;
      }
    }
  }
 
  if ( !is_array( $cache ) )
    $cache = array();
 
  // Quick check. If we have no posts at all, abort!
  if ( !$posts ) {
  
  			if (isset($client) && ($client != '')){

    $sql = "SELECT 1 as test FROM $wpdb->posts, $wpdb->postmeta WHERE $wpdb->posts.post_type IN ( $post_types ) AND $wpdb->posts.post_status = 'publish' AND $wpdb->postmeta.meta_value = $client LIMIT 1";
				 
			} elseif (isset($client) && ($client == '')) {

    $sql = "SELECT 1 as test FROM $wpdb->posts WHERE $wpdb->posts.post_type IN ( $post_types ) AND $wpdb->posts.post_status = 'publish' LIMIT 1";
				 
		 	}
  
  
  
  
    $gotsome = $wpdb->get_var( $sql );
    if ( !$gotsome ) {
      $cache[$key] = '';
      wp_cache_set( 'get_calendar' , $cache , 'calendar' );
      return;
    }
  }
 
  if ( isset( $_GET['w'] ) )
    $w = '' . intval( $_GET['w'] );
 
  // week_begins = 0 stands for Sunday
  $week_begins = intval( get_option( 'start_of_week' ) );
 
  // Let's figure out when we are
  if ( !empty( $monthnum ) && !empty( $year ) ) {
    $thismonth = '' . zeroise( intval( $monthnum ) , 2 );
    $thisyear = ''.intval($year);
  } else if ( !empty( $w ) ) {
    // We need to get the month from MySQL
    $thisyear = '' . intval( substr( $m , 0 , 4 ) );
    $d = ( ( $w - 1 ) * 7 ) + 6; //it seems MySQL's weeks disagree with PHP's
    $thismonth = $wpdb->get_var( "SELECT DATE_FORMAT( ( DATE_ADD( '${thisyear}0101' , INTERVAL $d DAY ) ) , '%m' ) " );
  } else if ( !empty( $m ) ) {
    $thisyear = '' . intval( substr( $m , 0 , 4 ) );
    if ( strlen( $m ) < 6 )
        $thismonth = '01';
    else
        $thismonth = '' . zeroise( intval( substr( $m , 4 , 2 ) ) , 2 );
  } else {
    $thisyear = gmdate( 'Y' , current_time( 'timestamp' ) );
    $thismonth = gmdate( 'm' , current_time( 'timestamp' ) );
  }
 
 /*

 	if(trim($_GET['prevmon']) === '') {
	} else {
		$thismonth = $_GET['prevmon'];
	}

*/

 	if(isset($_GET['prevmon'])) {
		$thismonth = $_GET['prevmon'];
	} else {
	}

 	if(isset($_GET['nextmon'])) {
		$thismonth = $_GET['nextmon'];
	} else {
	}
	 
	if(isset($_GET['curyear'])) {
		$thisyear = $_GET['curyear'];
	} else {
	}
	

	$unixmonth = mktime( 0 , 0 , 0 , $thismonth , 1 , $thisyear);

	
	$previousfull =  date("Y/m/d",strtotime($thisyear."-".$thismonth."-01 -1 months"));
	$nextfull =  date("Y/m/d",strtotime($thisyear."-".$thismonth."-01 +1 months"));
	$previous =  date("Y/m",strtotime($thisyear."-".$thismonth."-01 -1 months"));
	$next =  date("Y/m",strtotime($thisyear."-".$thismonth."-01 +1 months"));
 
 
 $prevtext = $wp_locale->get_month( date('m', strtotime($previousfull)) );
 $prevlink = $previousfull;
 $prevnum = date('m', strtotime($previousfull));
 $prevyear = ($thisyear-1); 
/*
 if ($prevnum == '12'){
 	$thisyear = $thisyear-1;
 }
 */
 
 $nexttext = $wp_locale->get_month( date('m', strtotime($nextfull)) );
 $nextlink = $nextfull;
 $nextnum = date('m', strtotime($nextfull));
 $nextyear = ($thisyear+1);  
 /*
 if ($nextnum == '01'){
 	$thisyear = ($thisyear+1);
 }
 */

  /* translators: Calendar caption: 1: month name, 2: 4-digit year */
  $calendar_caption = '%1$s %2$s';
  $calendar_output = '<table id="wp-calendar" summary="' . esc_attr__( 'Calendar' ) . '">
  <caption>' . sprintf( $calendar_caption , $wp_locale->get_month( $thismonth ) , date( 'Y' , $unixmonth ) ) . '</caption>
  <thead>
  <tr>';
 
  $myweek = array();
 
  for ( $wdcount = 0 ; $wdcount <= 6 ; $wdcount++ ) {
    $myweek[] = $wp_locale->get_weekday( ( $wdcount + $week_begins ) % 7 );
  }
 
  foreach ( $myweek as $wd ) {
    $day_name = ( true == $initial ) ? $wp_locale->get_weekday_initial( $wd ) : $wp_locale->get_weekday_abbrev( $wd );
    $wd = esc_attr( $wd );
    $calendar_output .= "\n\t\t<th scope=\"col\" title=\"$wd\">$day_name</th>";
  }
 
  $calendar_output .= '
  </tr>
  </thead>
 
  <tfoot>
  <tr>';
 

  if ( $previous ) {    $calendar_output .= "\n\t\t" . '<td colspan="3" id="prev"><a href="?prevmon=' . $prevnum . '&curyear='; if ($prevnum == '12'){ $calendar_output .= ''.$prevyear.''; } else { $calendar_output .= ''.$thisyear.''; } $calendar_output .= '" title="' . $prevtext . '">&larr; ' . $prevtext . '</a></td>';
  } else {
    $calendar_output .= "\n\t\t" . '<td colspan="1" id="prev" class="pad">&nbsp;</td>';
  }
 
  $calendar_output .= "\n\t\t" . '<td class="pad" colspan="">&nbsp;</td>';
 
  if ( $next ) {    $calendar_output .= "\n\t\t" . '<td colspan="3" id="next"><a href="?nextmon=' . $nextnum . '&curyear='; if ($nextnum == '01') 
{ $calendar_output.= ''.$nextyear.''; } else { $calendar_output .= ''.$thisyear.''; } $calendar_output .= '" title="' . $nexttext . '">' . $nexttext . ' &rarr;</a></td>';
  } else {
    $calendar_output .= "\n\t\t" . '<td colspan="1" id="next" class="pad">&nbsp;</td>';
  }


  $calendar_output .= '
  </tr>
  </tfoot>
 
  <tbody>
  <tr>';
 
 

  // Get days with posts
  $dayswithposts = $wpdb->get_results( "SELECT DISTINCT DAYOFMONTH( $wpdb->postmeta.meta_value )
    FROM $wpdb->postmeta
    LEFT JOIN $wpdb->posts
    ON $wpdb->posts.ID = $wpdb->postmeta.post_id
    WHERE MONTH( $wpdb->postmeta.meta_value ) = '$thismonth'
    AND YEAR( $wpdb->postmeta.meta_value ) = '$thisyear'
    AND $wpdb->posts.post_status = 'publish'
    AND $wpdb->posts.post_type IN ($post_types)", ARRAY_N );
  
  				 
    
    
  if ( $dayswithposts ) {
    foreach ( (array) $dayswithposts as $daywith ) {
      $daywithpost[] = $daywith[0];
    }
  } else {
    $daywithpost = array();
  }
 
  if ( strpos( $_SERVER['HTTP_USER_AGENT'] , 'MSIE' ) !== false || stripos( $_SERVER['HTTP_USER_AGENT'] , 'camino' ) !== false || stripos( $_SERVER['HTTP_USER_AGENT'] , 'safari' ) !== false )
    $ak_title_separator = "\n";
  else
    $ak_title_separator = ', ';
 
  $ak_titles_for_day = array();
  

 
  $ak_post_titles = $wpdb->get_results( "SELECT $wpdb->posts.ID, $wpdb->posts.post_title, $wpdb->posts.post_type, DAYOFMONTH( $wpdb->postmeta.meta_value ) as dom "
    . "FROM $wpdb->postmeta "
    . "LEFT JOIN $wpdb->posts "    
    . "ON $wpdb->posts.ID = $wpdb->postmeta.post_id "    
    . "WHERE YEAR( $wpdb->postmeta.meta_value ) = '$thisyear' "
    . "AND MONTH( $wpdb->postmeta.meta_value ) = '$thismonth' "
    . "AND $wpdb->posts.post_type IN ( $post_types ) AND $wpdb->posts.post_status = 'publish'"
  );

 
  	
  if ( $ak_post_titles ) {
    foreach ( (array) $ak_post_titles as $ak_post_title ) {
 $style = '';
  $calassignedname = '';

        $post_title = esc_attr( apply_filters( 'the_title' , $ak_post_title->post_title , $ak_post_title->ID ) );
 		$permalink = get_permalink( $ak_post_title->ID );
 		$post_type_single = $ak_post_title->post_type;

 			if ($post_type_single = 'todos'){ $icon = 'bookmark'; }

        	$custom = get_post_custom($ak_post_title->ID);
			if (isset($custom['_projects_client'])) { $calassignedname = $custom['_projects_client'][0]; }			
 		
		if (isset($client) && ($client != '')){
			if ($client != ''.$calassignedname.''){
			$style = 'style="display:none"';
			}
			
 		}
 
 
        if ( empty( $ak_titles_for_day['day_' . $ak_post_title->dom] ) )
          $ak_titles_for_day['day_'.$ak_post_title->dom] = '';
        if ( empty( $ak_titles_for_day["$ak_post_title->dom"] ) ) // first one
          $ak_titles_for_day["$ak_post_title->dom"] = '<a href="'.$permalink.'" '.$style.' name="'.$calassignedname.'"><i class="icon-'.$icon.'"></i> <span class="calendar-event">'.$post_title.'</span></a>';
        else
          $ak_titles_for_day["$ak_post_title->dom"] .= '<br/><a href="'.$permalink.'" '.$style.' name="'.$calassignedname.'"><i class="icon-'.$icon.'"></i> <span class="calendar-event">'.$post_title.'</span></a>';
          
    }
  }
 
  // See how much we should pad in the beginning
  $pad = calendar_week_mod( date( 'w' , $unixmonth ) - $week_begins );
  if ( 0 != $pad )
    $calendar_output .= "\n\t\t" . '<td colspan="' . esc_attr( $pad ) . '" class="pad">&nbsp;</td>';
 
  $daysinmonth = intval( date( 't' , $unixmonth ) );
  for ( $day = 1 ; $day <= $daysinmonth ; ++$day ) {
    if ( isset( $newrow ) && $newrow )
      $calendar_output .= "\n\t</tr>\n\t<tr>\n\t\t";
    $newrow = false;
 
    if ( $day == gmdate( 'j' , current_time( 'timestamp' ) ) && $thismonth == gmdate( 'm' , current_time( 'timestamp' ) ) && $thisyear == gmdate( 'Y' , current_time( 'timestamp' ) ) )
      $calendar_output .= '<td id="today">';
    else
      $calendar_output .= '<td>';
 
    if ( in_array( $day , $daywithpost ) ) { // any posts today?
        
       $calendar_output .= $day;
       $calendar_output .= '<br/>';
       $calendar_output .= ''.$ak_titles_for_day[$day].' ';   
       
        } else   {
    $calendar_output .= $day;
    $calendar_output .= '</td>';
	 }
    if ( 6 == calendar_week_mod( date( 'w' , mktime( 0 , 0 , 0 , $thismonth , $day , $thisyear ) ) - $week_begins ) )
      $newrow = true;
  }
 
  $pad = 7 - calendar_week_mod( date( 'w' , mktime( 0 , 0 , 0 , $thismonth , $day , $thisyear ) ) - $week_begins );
  if ( $pad != 0 && $pad != 7 )
    $calendar_output .= "\n\t\t" . '<td class="pad" colspan="' . esc_attr( $pad ) . '">&nbsp;</td>';
 
  $calendar_output .= "\n\t</tr>\n\t</tbody>\n\t</table>";
 
  $cache[$key] = $calendar_output;
  wp_cache_set( 'get_calendar' , $cache, 'calendar' );
 
  remove_filter( 'get_calendar' , 'projectpress_get_calendar_filter' );
  $output = apply_filters( 'get_calendar',  $calendar_output );
  add_filter( 'get_calendar' , 'projectpress_get_calendar_filter' );
 
  if ( $echo )
    echo $output;
  else
    return $output;
}
 
function projectpress_get_calendar_filter( $content ) {
  $output = projectpress_get_calendar( '' , '' , false );
  return $output;
}
add_filter( 'get_calendar' , 'projectpress_get_calendar_filter' , 10 , 2 ); ?>
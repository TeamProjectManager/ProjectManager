<?php
/**
 * PROJECTPRESS
 * VERSION 5.0 NEW - Feb 2014
 * AUTHOR: Jason Herndon - icarusthemes.com
 */
// Check for PT Framework
if(!defined('it_FRAMEWORK_DIR')) die( _('Framework location not defined.','it'));



/*--------------------------------------*/
/* Included files
/*--------------------------------------*/

//load global variables
require_once('functions/variables.php');

//load index
require_once ('admin/index.php');

//load css & jquery
require_once('scripts/enqueue_css.php');
require_once('scripts/enqueue_js.php');

//load functions
require_once('functions/custom_login.php');
require_once('functions/enhanced_comments.php');
require_once('functions/pagination.php');
require_once('functions/grid.php');
require_once('functions/imageresize.php');

//load widgets
require_once('widgets/video.php');

//load shortcodes
require_once('shortcodes/shortcodes.php');

//load only on admin
if(defined('WP_ADMIN') && WP_ADMIN ) {	
	//meta
	require_once('meta/meta_class.php');	
}




/*--------------------------------------*/
/* Filters
/*--------------------------------------*/

//shortcode support
add_filter('the_content', 'do_shortcode');
add_filter('widget_text', 'do_shortcode');





/*--------------------------------------*/
/* Misc
/*--------------------------------------*/

//wp theme supports
add_theme_support('custom-background');
add_theme_support('post-thumbnails');
add_theme_support( 'custom-header' );
add_editor_style();
add_theme_support( 'automatic-feed-links' ).
 
// add home link to menu
add_filter( 'wp_page_menu_args', 'home_page_menu_args' );
function home_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}

// functions flush -> do not delete
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
	$wp_rewrite->flush_rules();
}

?>
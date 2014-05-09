<?php
/**
 * Enqueue CSS
*/

/*--------------------------------------*/
/* Stylesheets
/*--------------------------------------*/
add_action('wp_enqueue_scripts', 'it_enqueue_css');
function it_enqueue_css() {
	
	global $it_data; //get theme options
	$current_dir = it_FRAMEWORK_DIR . '/scripts'; //current directory
	
	//framework
	wp_enqueue_style('bootstrap', $current_dir . '/css/bootstrap.css', 'style');
	wp_enqueue_style('bootstrap-theme', $current_dir . '/css/bootstrap-theme.css', 'style');
//	wp_enqueue_style('framework', $current_dir . '/css/framework.css', 'style');
//	wp_enqueue_style('framework-responsive', $current_dir . '/css/framework_responsive.css', 'style');
	
	//main css
	wp_enqueue_style('style', get_template_directory_uri() . '/style.css', 'style');
	
}
?>
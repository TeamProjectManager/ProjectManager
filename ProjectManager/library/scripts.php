<?php
/**
 * Load css and jquery for current theme
*/

//hook function
add_action('wp_enqueue_scripts','theme_specific_scripts');

//start function
function theme_specific_scripts() {
	
	global $it_data; //get theme options


	/* jQuery */

	//projects main
	if(is_page_template('template-projects.php') || (is_page_template('template-myprojects.php'))){
		wp_enqueue_script('quicksand', it_JS_DIR .'/quicksand.js', array('jquery','easing'), '1.2.2', true);
		wp_enqueue_script('quicksand-projects', it_JS_DIR .'/quicksand_projects.js', array('jquery','easing','quicksand'), '1.0', true);
	}
	
	//projects single
	if(get_post_type() == 'projects_cpt') {
		wp_enqueue_script('modals', it_JS_DIR .'/modals.js', array('jquery'), '1.0', true);
//		wp_enqueue_script('circles', it_JS_DIR .'/circles.js', array('jquery'), '1.0', true);
	}
	
	//responsive
	wp_enqueue_script('fitvids', it_JS_DIR .'/fitvids.js', array('jquery'), 1.0, true);
	wp_enqueue_script('uniform', it_JS_DIR .'/uniform.js', array('jquery'), '1.7.5', true);
	wp_enqueue_script('it-responsive', it_JS_DIR .'/responsive.js', array('jquery'), '', true);
	
	//localize responsive nav
	$nav_params = array(
	);
	wp_localize_script( 'it-responsive', 'responsiveLocalize', $nav_params );
	
	
	//initialize
	wp_enqueue_script('initialize', it_JS_DIR .'/initialize.js', false, '1.0', true);


	/* UPDATE NOTIFIER */
	if(isset($_GET['page']) && ($_GET['page']=='theme-update-notifier')){
		//enqueue the scripts for the Update notifier page
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_script('it-update',it_JS_DIR.'update-notifier.js');

		//enqueue the styles for the Update notifier page
		wp_enqueue_style('it-update-style',it_CSS_DIR.'update-notifier.css');
		wp_enqueue_style('it-admin-style',it_CSS_DIR.'page_style.css');
	}


	/* CSS */
	
	//responsive
	wp_enqueue_style('responsive', it_CSS_DIR . '/responsive.css', 'style', true);
	
} //end theme_specific_scripts()
?>
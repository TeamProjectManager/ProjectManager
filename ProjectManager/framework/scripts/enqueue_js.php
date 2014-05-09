<?php
/**
 * Enqueue jQuery Scripts
*/


//front end scripts
add_action('wp_enqueue_scripts','it_framework_scripts_function');
function it_framework_scripts_function() {
	
	global $it_data; //get theme options
	$js_dir = it_FRAMEWORK_DIR . '/scripts/js'; //current directory
	
	//core
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_script('jquery-ui-tabs');
	
	//site wide
	wp_enqueue_script('bootstrap', $js_dir .'/bootstrap.js', array('jquery'), '', true);
	wp_enqueue_script('easing', $js_dir .'/easing.js', array('jquery'), '1.3', true);
//	wp_enqueue_script('hoverIntent', $js_dir .'/hoverintent.js', array('jquery'), 'r6', true);
//	wp_enqueue_script('superfish', $js_dir .'/superfish.js', array('jquery'), '1.4.8', true);

	//comment replies
	if(is_single() || is_page()) {
		wp_enqueue_script('comment-reply');
	}

}
?>
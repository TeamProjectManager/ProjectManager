<?php
/*
Title		: SMOF
Description	: Slightly Modified Options Framework
Version		: 1.4.0
Author		: Syamil MJ
Author URI	: http://aquagraphite.com
License		: WTFPL - http://sam.zoy.org/wtfpl/
Credits		: Thematic Options Panel - http://wptheming.com/2010/11/thematic-options-panel-v2/
		 	  Option Tree - http://wordpress.org/extend/plugins/option-tree/
*/

/**
 * Definitions
 *
 * @since 1.4.0
 */
 
$themedata = wp_get_theme();

$themename = str_replace( ' ','',strtolower($themedata->Name));
$version = $themedata->Version;
$author = $themedata->Author;

define( 'SMOF_VERSION', '1.4.0' );
define( 'ADMIN_PATH', get_template_directory() . '/framework/admin/' );
define( 'ADMIN_DIR', get_template_directory_uri() . '/framework/admin/' );
define( 'LAYOUT_PATH', ADMIN_PATH . '/layouts/' );
define( 'THEMENAME', $themename );
define( 'THEMEVERSION', $version  );
define( 'THEMEAUTHOR', $author );
define( 'OPTIONS', $themename.'_options' );
define( 'BACKUPS',$themename.'_backups' );

/**
 * Required action filters
 *
 * @uses add_action()
 *
 * @since 1.0.0
 */
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) add_action('admin_head','of_option_setup');
add_action('admin_head', 'optionsframework_admin_message');
add_action('admin_init','optionsframework_admin_init');
add_action('admin_menu', 'optionsframework_add_admin');
add_action( 'init', 'optionsframework_mlu_init');

/**
 * Required Files
 *
 * @since 1.0.0
 */ 
require_once ( ADMIN_PATH . 'functions/functions.load.php' );
require_once ( ADMIN_PATH . 'classes/class.options_machine.php' );

/**
 * AJAX Saving Options
 *
 * @since 1.0.0
 */
add_action('wp_ajax_of_ajax_post_action', 'of_ajax_callback');


/**
 * Add theme options to admin bar
 */
function add_theme_options_admin_bar(){
	global $wp_admin_bar;
	$wp_admin_bar->add_menu( array( 'id' => 'aq-theme-options', 'parent' => 'appearance', 'title' => 'Theme Options', 'href' => admin_url('themes.php?page=optionsframework') ) );
}
add_action( 'admin_bar_menu', 'add_theme_options_admin_bar', 1000 );
?>
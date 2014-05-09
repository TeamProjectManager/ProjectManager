<?php
/**
 * Project Manager
 */

//get theme options
global $it_data;

//get template header
get_header(); 
$pagetitle = "404";
require_once ( 'includes/body-top.php' );


if ( ( is_single() || is_front_page() || is_page() ) 
       && !is_page('login') && !is_user_logged_in()){ 
    auth_redirect(); 
} 

?>
<div id="404-page">	
	<h1 id="404-page-title">404</h1>			
	<p id="404-page-text">
	<?php if($it_data['custom_404_text']) { echo stripslashes($it_data['custom_404_text']); } else {  _e('Sorry, the page you are trying to access does not exist. You can go back to the homepage: ','it'); ?> <a href="<?php echo home_url() ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php _e('homepage','it'); ?></a>.<?php } ?>
    </p>
</div><!-- END 404-page -->

<?php get_footer(); ?>
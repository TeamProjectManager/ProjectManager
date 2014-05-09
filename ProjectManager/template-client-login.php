<?php
ob_flush();
/**
 * Project Manager
 * Template Name: Login 
 */

global $it_data; //get theme options
?>


<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />


<!-- Responsive CSS
================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->


<?php if(!empty($it_data['custom_fav'])) { ?>
<!-- Custom Favicon
================================================== -->
<link rel="icon" type="image/png" href="<?php echo $it_data['custom_fav']; ?>" />
<?php } ?>


<!-- Title
================================================== -->
<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' |'; } ?> <?php bloginfo('name'); ?></title>


<!-- IE Fixes
================================================== -->
<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!--[if lte IE 7]>
	<script src="js/IE8.js" type="text/javascript"></script><![endif]-->
<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" media="all" href="css/ie6.css"/>
<![endif]-->
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie7.css" media="screen" />
/>
<![endif]-->
<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie8.css" media="screen" />
<![endif]-->



<?php

//header analytics code
echo stripslashes($it_data['analytics_header']);
?>

<!-- WP Head
================================================== -->
<?php wp_head(); ?>
</head><!-- /end head -->


<!-- Begin Body
================================================== -->
<body <?php body_class('body '. $it_data['color_option'] .''); ?>>

	<div class="clientlogin">

<?php
//require_once ( 'includes/body-top.php' );

//start page loop

	$username = get_the_title();
	$user = get_user_by('login', $username);
	$userid = $user->ID;

	$user_email = get_the_author_meta( 'user_email', $userid );

					$avatar	= get_avatar( $user_email, 150 );
					//$avatar = get_avatar( $userid, 200 );
		   			echo $avatar;

?>

<div id="page-heading">
    <h1><?php the_title(); ?></h1>	
</div><!-- /page-heading -->

<div id="full-width" class="clearfix">

	<article class="entry clearfix">

	<div>


	<form name="log inform" id="log inform" action="<?php echo home_url(); ?>/wp-login.php" method="post" class="margintop20down">
	<p>
		<label>Username<br />
		<input type="text" name="log" id="user_login" class="input width300 clientlogininput" value="" size="20" tabindex="10"/></label>
	</p>
	<p>

		<label>Senha<br />
		<input type="password" name="pwd" id="user_pass" class="input width300 clientlogininput" value="" size="20" tabindex="20"/></label>
	</p>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="btn btn-large btn-success submitbtn" value="Entrar" tabindex="100" />
		<input type="hidden" name="redirect_to" value="<?php echo home_url(); ?>" />

		<input type="hidden" name="test cookie" value="1" />
	</p>
	</form>

	<p id="nav">
	<label class="rememberme"><input name="remember me" type="checkbox" id="remember me" value="forever" tabindex="90" /> Lembrar</label><br/>
	<span class="margintop10up"><a href="<?php echo home_url(); ?>/wp-login.php?action=lostpassword" title="Password Lost and Found">Perdi a senha =/</a></span>
	</p>


	</div>



	</article><!-- /entry --> 
    
</div><!-- /full-width -->





<div class="clear"></div>

</div><!-- /content-main -->

</div><!-- /wrap -->
    
<?php 
//show tracking code - footer 
echo stripslashes($it_data['analytics_footer']); 
?>
<?php wp_footer(); ?>
</div>
</body>
</html>
<?php
/**
 * Project Manager
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


<?php if(!empty($it_data['custom_fav'])) { ?>
<!-- Custom Favicon
================================================== -->
<link rel="icon" type="image/png" href="<?php echo $it_data['custom_fav']; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/animate.css" media="screen" />
<?php } ?>

<!-- Title
================================================== -->
<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' |'; } ?> <?php bloginfo('name'); ?></title>

<!-- IE Fixes
================================================== -->
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!--[if lte IE 7]>
	<script src="js/IE8.js" type="text/javascript"></script><![endif]-->
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
<body <?php body_class('body'); ?>>

    <header class="navbar navbar-inverse navbar-fixed-top">
        <div class="outer-container">

        </div>
    </header>


	<div class="pp-wrap">
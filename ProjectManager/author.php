<?php
/**
 * Project Manager
 */
 
//get template header
get_header();
$pagetitle = "Projects By ";

//start post loop
if(have_posts()) :

//page title
($it_data['translation_post_by_text']) ? $author_page_title = $it_data['translation_post_by_text'] : $author_page_title = __('Posts By','it');
?>

<header id="page-heading">
		<?php
        if(isset($_GET['author_name'])) :
        $curauth = get_userdatabylogin($author_name);
        else :
        $curauth = get_userdata(intval($author));
        endif;
        ?>
        <h1></h1>
</header><!-- /page-heading -->

<?php

$pagetitle = $author_page_title;
$pagetitle .= ' ';
$pagetitle .= $curauth->nickname;

?>

<?php require_once ( 'includes/body-top.php' ); ?>

<div id="post" class="post clearfix">  
	<?php
	//get entry loop
    get_template_part('includes/loop', 'entry'); 
	
	//pagination function
	pagination(); ?>
</div><!--/post -->

<?php
//end post loop
endif;

//get sidebar template
get_sidebar();

//get footer template
get_footer(); ?>
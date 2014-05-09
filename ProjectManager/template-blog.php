<?php
/**
 * ProjectManager
 * Template Name: Blog
 */

//get theme options
global $it_data;

//get template header
get_header();
$pagetitle="Blog";

require_once ( 'includes/body-top.php' );

//start page loop
if (have_posts()) : while (have_posts()) : the_post();

//posts per page
$template_posts_per_page = get_post_meta($post->ID, 'it_template_posts_per_page', true);

//get meta to set parent category
$blog_filter_parent = '';
$blog_parent = get_post_meta($post->ID, 'it_blog_parent', true);
if($blog_parent != 'select_category_parent') { $blog_filter_parent = $blog_parent; } else { $blog_filter_parent = NULL; }	
?>

<header id="page-heading">
	<h1><?php the_title(); ?></h1>
</header><!-- /page-heading -->

<div id="post" class="blog-template clearfix margintop20">
	<?php
	//tax query
	if($blog_filter_parent) {
		$tax_query = array(
			array(
				  'taxonomy' => 'category',
				  'field' => 'id',
				  'terms' => $blog_filter_parent,
				  )
			);
	} else { $tax_query = NULL; }
	
    //query posts
        query_posts(
            array(
				'post_type'=> 'post',
				'posts_per_page' => $template_posts_per_page,
				'paged'=>$paged,
				'tax_query' => $tax_query
       		)
		);

	//loop
    if (have_posts()) :
		//get entry template
		get_template_part( 'includes/loop', 'entry');            	
    endif;
	
	//show pagination
	pagination();
	
	//reset query
	wp_reset_query(); ?>

</div><!-- /post -->

<?php endwhile; endif; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
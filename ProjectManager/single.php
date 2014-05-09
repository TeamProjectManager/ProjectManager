<?php
ob_flush();
/**
 * Project Manager
 */

//global variables
global $it_data;

//get template header
get_header();


    if ( current_user_can( 'manage_options' ) ) {
    	$isadmin = true;
	} else {
    	$isadmin = false;
    			// for demo
		// $isadmin = true;

	}

//start post loop
if (have_posts()) : while (have_posts()) : the_post();
$pagetitle = get_the_title();
require_once ( 'includes/body-top.php' );

$posttype = get_post_type($post->ID);

//get meta options
$single_featured_image = get_post_meta($post->ID, 'it_single_featured_image', TRUE);
$single_single_tags = get_post_meta($post->ID, 'it_single_tags', TRUE);
$single_related_posts = get_post_meta($post->ID, 'it_single_related_posts', TRUE);

//image height
($it_data['post_image_height']) ? $post_image_height = 400 * str_replace('%', '', $it_data['post_image_height']) / 100 : $post_image_height = 400;
?>

<div id="portfolio-template">
    <div id="portfolio-wrap clearfix">



<header id="page-heading">
	<h1><?php the_title(); ?> 		<?php if ($posttype !== 'todos'){ } else { 
	
	//get the tag
	$posttags = get_the_tags();
	if ($posttags) {
	  foreach($posttags as $tag) {
	    $related_project = $tag->name; 
	  }
	}
	//get the permalink by the tag
	$permalink = get_permalink( $related_project );
	
	echo '<span class="floatright"><a href="'.$permalink.'">&laquo; Back to Project</a></span>'; 
	
	}?>
</h1>
</header><!-- /post-meta -->

<div id="post" class="clearfix">

    	<?php 
        //show only on non-protected posts
		if(!post_password_required()) : ?>
        
        <?php
        //show post meta if not disabled
		if($it_data['show_hide_single_meta'] !='disable') { ?>
            <section class="meta clearfix" id="single-meta">
                <ul>
                    <li><?php the_date(); ?></li>    
                    <li class="comment-scroll"><?php it_translation('comments'); ?></li>
                    <li><?php the_author_posts_link(); ?></li>
               </ul>
            </section><!--/meta -->
        <?php } ?>
        
        <?php
        
		//show if not disabled in admin
		if($single_featured_image != 'disable') {
			
		//featured image
		$thumb = get_post_thumbnail_id();
		$img_url = wp_get_attachment_url($thumb,'full'); //get full URL to image
		($it_data['show_hide_single_post_image_crop'] == 'enable') ? $featured_image = aq_resize( $img_url, 770, $post_image_height, true ) : $featured_image = $img_url;
		
		if($featured_image) {
		?>
		<div id="post-thumbnail">
			<a href="<?php echo $img_url; ?>" title="<?php the_title(); ?>" class="prettyphoto-link">
            	<img src="<?php echo $featured_image; ?>" alt="<?php echo the_title(); ?>" />
            </a>
		</div><!-- /post-thumbnail -->
        <?php } } ?>
        
        <?php
		endif; //end password required test ?>
        
		<article class="entry clearfix">
			<?php the_content(); ?>
        </article><!-- /entry -->
        
		<?php 
        //show only on non-protected posts
		if(!post_password_required()) : ?>
        
        <?php wp_link_pages(); ?>

		<?php
		         
		
		if ($posttype == 'todos'){ } else {

		?>
		<nav id="post-navigation-posts" class="clearfix"> 
			<div>
    	    <?php next_posts_link('<strong>&laquo; %link</strong>','%title',TRUE,''); ?>
			</div>
			<div>
    	    <?php previous_posts_link('<strong>%link &raquo;</strong>','%title',TRUE, ''); ?>
			</div>
    	</nav><!-- /post-navigation --> 
 
    	<?php } // end if todos?>
 
 
        
		<?php
		
		
		if ($posttype == 'todos'){ } else {
		
		//show tags unless disabled
        if($single_single_tags !='disable' && $it_data['show_hide_single_tags'] !='disable') {
			the_tags('<div class="post-tags clearfix"><h4 class="heading"><span>'. it_translation('tags').'</span></h4>','','</div>');
		}
		
		}

	           
			endif; //end password required test ?>
 
<?php
         //show comments if not disabled
        if($it_data['show_hide_blog_comments'] !='disable') { comments_template(); } ?>
       
        
</div><!-- /post -->
    </div><!-- /projects-wrap -->
</div><!-- /projects-template -->



<?php
//end post loop
endwhile; endif;

//get template sidebar
get_sidebar();

//get template footer
get_footer(); ?>
<?php
/**
 * Press Themes
 */
global $it_data;
while (have_posts()) : the_post();

//set image heights based on post types <== added so user can easily edit
if('projects_cpt' == get_post_type()) { $img_height = '390';
} elseif('post' == get_post_type()) { $img_height = '390';
} else { $img_height = '390'; }
?>  

<article <?php post_class('loop-entry clearfix'); ?>>  
    <section class="entry-content">
		<?php
        //crop image
        $thumb = get_post_thumbnail_id();
        $img_url = wp_get_attachment_url($thumb,'full'); //get full URL to image
        $featured_image = aq_resize( $img_url, 390, $img_height, true ); //resize & crop the image

		//show featued image
        if($featured_image) {  ?>
	    <div class="entry-left">
            <div class="loop-entry-thumbnail">
				<?php if($featured_image) { ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-entry-img-link">
                    	<img src="<?php echo $featured_image; ?>" alt="<?php echo the_title(); ?>" class="post-entry-img" />
               		</a>
                <?php } ?>
            </div><!-- /loop-entry-thumbnail -->
	    </div><!-- /entry-left -->
        <?php } ?>
	
	    <div class="entry-right <?php if(!$featured_image) { echo 'full-width'; } ?>">
    	    <header>
    	        <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
    	    </header>
	        <div class="entry-text">
	            <?php
				//show excerpt or content depending on theme setting
                if($it_data['enable_full_blog'] == 'enable') {
					the_content(); } else {
						echo wp_trim_words(get_the_content(), $it_data['blog_excerpt'] ); }
				?>
	        </div><!-- /entry-text -->
			<?php
			//show read more buttn if not disabled
            if($it_data['blog_read_more'] != 'disable') { ?>
				<a class="read-more" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo it_translation('readmore'); ?> &rarr;</a>
            <?php } ?>
	    </div><!-- /entry-right -->
	</section><!-- entry-content -->   
</article><!-- /entry -->
<?php
//end loop
endwhile; ?>
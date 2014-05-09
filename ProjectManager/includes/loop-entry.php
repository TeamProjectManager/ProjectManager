<?php
/**
 * IcarusThemes
 */
global $it_data;
while (have_posts()) : the_post(); ?>  

<article <?php post_class('loop-entry clearfix'); ?>>  
    <section class="entry-content">
    
		<?php
        //cropped image
        $thumb = get_post_thumbnail_id();
        $img_url = wp_get_attachment_url($thumb,'full'); //get full URL to image
        
        //image height - set width the same as max responsive size
        $it_data['blog_img_height'] ? $img_height = 300 * str_replace('%', '', $it_data['blog_img_height']) / 100 : $img_height = 390;
            
        //crop image
        $featured_image = aq_resize( $img_url, 390, $img_height, true ); //resize & crop the image

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
            <ul class="meta clearfix">
                <li><?php the_time('jS F Y'); ?></li>    
                <li><?php it_translation('comments'); ?></li>
           </ul>
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
<?php endwhile; ?>
<?php
/**
 * Press Themes
 */
 
//global variables
global $it_data, $it_counter, $projects_cpt_grid_class, $projects_cpt_grid_image_height;

   wp_get_current_user();
    /**
     * @example Safe usage: $current_user = wp_get_current_user();
     * if ( !($current_user instance of WP_User) )
     *     return;
     */
    global $current_user_username;

    $user_role = get_user_role();

  if (isset($it_data['translation_administrator']) && ($it_data['translation_administrator'] !== '')) { $adminword = $it_data['translation_administrator']; global $adminword; } else { $adminword = 'administrator'; global $adminword; }
if (isset($it_data['translation_editor']) && ($it_data['translation_editor'] !== '')) { $editorword = $it_data['translation_editor']; global $editorword; } else { $editorword = 'editor'; global $editorword; }
if (isset($it_data['translation_client']) && ($it_data['translation_client'] !== '')) { $clientword = $it_data['translation_client']; global $clientword; } else { $clientword = 'client'; global $clientword; }
   
    if ( current_user_can( 'manage_options' ) ) {
    	$isadmin = true;
	} else {
    	$isadmin = false;
    			// for demo
		//$isadmin = true;

	}

	if ($user_role == "$clientword") {	
		$isclient = true;
	} else {
		$isclient = false;	
	}

	
//count
$it_counter++;

//get featured image
$thumb = get_post_thumbnail_id();
$img_url = wp_get_attachment_url($thumb,'full'); //get full URL to image

//set image width
($projects_cpt_grid_class == 'grid-2') ? $projects_cpt_grid_image_width = 450 : $projects_cpt_grid_image_width = 390;

//crop image
$featured_image = aq_resize( $img_url, $projects_cpt_grid_image_width, $projects_cpt_grid_image_height, true ); //resize & crop the image

//get terms
$terms = get_the_terms( get_the_ID(), 'projects_cpt_cats' );
$terms_list = get_the_term_list( get_the_ID(), 'projects_cpt_cats' );

//get meta
$projects_cpt_entry_style = get_post_meta($post->ID, 'it_projects_cpt_entry_style', true);
$projects_cpt_entry_lightbox = get_post_meta($post->ID, 'it_projects_cpt_entry_lightbox', true);
$projects_cpt_entry_custom_url = get_post_meta($post->ID, 'it_projects_cpt_entry_custom_url', true);
$projects_cpt_entry_custom_url_target = get_post_meta($post->ID, 'it_projects_cpt_entry_custom_url_target', true);


//set entry url to lightbox
if($projects_cpt_entry_style == 'lightbox') { $projects_cpt_entry_url = $projects_cpt_entry_lightbox;
	//set entry url to custom url
	} elseif ($projects_cpt_entry_style == 'url') { $projects_cpt_entry_url = $projects_cpt_entry_custom_url;
	//set entry url to default permalink
	} else { $projects_cpt_entry_url = get_permalink($post->ID); }


//show entry only if it has a featured image
if($featured_image) {  ?>
<li data-id="id-<?php echo $it_counter; ?>" data-type="<?php if($terms) { foreach ($terms as $term) { echo $term->slug .' '; } } else { echo 'none'; } ?>" class="portfolio-post <?php echo $projects_cpt_grid_class; ?>">
	<a href="<?php echo $projects_cpt_entry_url; ?>" title="<?php the_title(); ?>" class="portfolio-post-img-link <?php if($projects_cpt_entry_style == 'lightbox') { echo 'prettyphoto-link'; } ?>" <?php if($projects_cpt_entry_custom_url) { echo 'target="_'.$projects_cpt_entry_custom_url_target.'"'; } ?>><img src="<?php echo $featured_image; ?>" alt="<?php the_title(); ?>" class="portfolio-post-img" /></a>
	<?php if($it_data['show_hide_projects_cpt_title'] == 'enable' || $it_data['show_hide_projects_cpt_excerpt'] == 'enable') { ?>
    <div class="portfolio-post-description">
        <?php
        //item title
        if($it_data['show_hide_projects_cpt_title'] != 'disable') { ?>
        	<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
        <?php }
        //item excerpt
        if($it_data['show_hide_projects_cpt_excerpt'] != 'disable') { ?>
        	<div class="portfolio-post-excerpt">
				<?php
                !empty($post->post_excerpt) ? $excerpt = get_the_excerpt() : $excerpt = wp_trim_words(get_the_content(), $it_data['projects_cpt_entry_excerpt_length']);
                echo $excerpt; ?>
            </div><!-- .portfolio-post-excerpt -->
        <?php } ?>
		<?php
		//show read more buttn if not disabled
		if($it_data['projects_cpt_read_more'] != 'disable') { ?>
		<a class="read-more" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo it_translation('readmore'); ?> &rarr;</a>
		<?php } ?>
    </div><!-- .portfolio-post-description -->
    <?php } ?>
</li><!-- /portfolio-post -->
<?php } //end loop ?>
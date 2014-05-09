<?php
/*--------------------------------------*/
/* used for taxonomy pagination
/*--------------------------------------*/

//get posts per page
$it_option_posts_per_page = get_option( 'posts_per_page' );

//add posts per page filter
add_action( 'init', 'it_modify_posts_per_page', 0);
function it_modify_posts_per_page() {
    add_filter( 'option_posts_per_page', 'it_option_posts_per_page' );
}

//modify posts per page
function it_option_posts_per_page( $value ) {
	global $it_data;
	global $it_option_posts_per_page;
	
	//tax pagination
    if(is_tax('projects_cpt_cats')) return $it_data['project_cpt_tax_pages'];
	if(is_tax('staff_cats')) return $it_data['staff_tax_pages'];
}

?>
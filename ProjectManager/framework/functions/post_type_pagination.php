<?php
/*--------------------------------------*/
/*	Post Type Pagination
/*--------------------------------------*/
$option_posts_per_page = get_option( 'posts_per_page' );
add_action( 'init', 'it_modify_posts_per_page', 0);

function it_modify_posts_per_page() {
    add_filter( 'option_posts_per_page', 'it_option_posts_per_page' );
}
function it_option_posts_per_page( $value ) {
	global $it_data;
	global $option_posts_per_page;
	
	// Get theme panel admin
	if($it_data['portfolio_cat_pagination']) {
		$portfolio_posts_per_page = $it_data['portfolio_cat_pagination'];
		} else {
			$portfolio_posts_per_page = '-1';
			}
	
    if (is_tax( 'portfolio_cats') ) {
        return $portfolio_posts_per_page;
    }
	if (is_tax( 'staff_departments')) {
		return -1;
	}
	else {
        return $option_posts_per_page;
    }
}
?>
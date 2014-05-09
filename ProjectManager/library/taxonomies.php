<?php
/*--------------------------------------*/
/*	Taxonomies
/*--------------------------------------*/
add_action( 'init', 'it_create_tax' );

//create taxonomies
function it_create_tax() {
	
	
	global $it_data; //get theme options for use in setting post type labels & permalinks
	
	
	/** Global **/

	$it_tax = array(
		'name' => __( 'Categories', 'it' ),
		'singular_name' => __( 'Category', 'it' ),
		'search_items' =>  __( 'Search Categories', 'it' ),
		'all_items' => __( 'All Categories', 'it' ),
		'parent_item' => __( 'Parent Category', 'it' ),
		'parent_item_colon' => __( 'Parent Category:', 'it' ),
		'edit_item' => __( 'Edit  Category', 'it' ),
		'update_item' => __( 'Update Category', 'it' ),
		'add_new_item' => __( 'Add New  Category', 'it' ),
		'new_item_name' => __( 'New Category Name', 'it' ),
		'choose_from_most_used'	=> __( 'Choose from the most used categories', 'it' )
	);
	
	
	/** Projects **/
	
	register_taxonomy('projects_cpt_cats','projects_cpt',array(
		'hierarchical' => true,
		'labels' => apply_filters('it_projects_cpt_tax_labels', $it_tax),
		'query_var' => true
	));
	
}


	/** Add Filter **/

function it_add_filters() {
	global $typenow;

	if( $typenow == 'projects_cpt' ){
		if( $typenow == 'projects_cpt') { $taxonomies = array('projects_cpt_cats'); }

		foreach ($taxonomies as $tax_slug) {
			$tax_obj = get_taxonomy($tax_slug);
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			if(count($terms) > 0) {
				echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
				echo "<option value=''>All Categories</option>";
				foreach ($terms as $term) { 
					echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
				}
				echo "</select>";
			}
		}
	}
}
add_action( 'restrict_manage_posts', 'it_add_filters' );
?>
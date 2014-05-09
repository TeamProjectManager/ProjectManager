<?php
/*--------------------------------------*/
/*	Post Types
/*--------------------------------------*/
add_action( 'init', 'it_create_post_types' );
function it_create_post_types() {
	
	global $it_data; //get theme options for use in setting post type labels & permalinks

	/** Budget 
	register_post_type( 'budget', 
		array(
		  'labels' => array(
			'name' => __( 'Budget', 'it' ),
			'singular_name' => __( 'Budget Item', 'it' ),		
			'add_new' => _x( 'Add New', 'Budget Item', 'it' ),
			'add_new_item' => __( 'Add New Budget Item', 'it' ),
			'edit_item' => __( 'Edit Budget Item', 'it' ),
			'new_item' => __( 'New Budget Item', 'it' ),
			'view_item' => __( 'View Budget Item', 'it' ),
			'search_items' => __( 'Search Budget Items', 'it' ),
			'not_found' =>  __( 'No Budget Items found', 'it' ),
			'not_found_in_trash' => __( 'No Budget Items found in Trash', 'it' ),
			'parent_item_colon' => ''
			
		  ),
		  'public' => true,
		  'supports' => array('title', 'revisions', 'thumbnail', 'custom-fields', 'editor', 'tags'),
		  'query_var' => true,
		  'show_ui' => true,
		  'rewrite' => array( 'slug' => 'budget' ),
		  'show_in_nav_menus' => false,
		  'exclude_from_search' => true,
		  'taxonomies' => array('post_tag'), // this is IMPORTANT
		   'menu_icon' => get_template_directory_uri() . '/images/admin/custom-post-type.png',
		)
	  );
	**/


	/** Time **/
	register_post_type( 'timelog', 
		array(
		  'labels' => array(
			'name' => __( 'TimeLog', 'it' ),
			'singular_name' => __( 'TimeLog', 'it' ),		
			'add_new' => _x( 'Add New', 'TimeLog', 'it' ),
			'add_new_item' => __( 'Add New TimeLog', 'it' ),
			'edit_item' => __( 'Edit TimeLog', 'it' ),
			'new_item' => __( 'New TimeLog', 'it' ),
			'view_item' => __( 'View TimeLog', 'it' ),
			'search_items' => __( 'Search TimeLog items', 'it' ),
			'not_found' =>  __( 'No TimeLog items found', 'it' ),
			'not_found_in_trash' => __( 'No TimeLog Items found in Trash', 'it' ),
			'parent_item_colon' => ''
			
		  ),
		  'public' => true,
		  'supports' => array('title', 'revisions', 'thumbnail', 'custom-fields', 'editor', 'tags'),
		  'query_var' => true,
		  'show_ui' => true,
		  'rewrite' => array( 'slug' => 'timelog' ),
		  'show_in_nav_menus' => false,
		  'exclude_from_search' => true,
		  'taxonomies' => array('post_tag'), // this is IMPORTANT
		   'menu_icon' => get_template_directory_uri() . '/images/admin/custom-post-type.png',
		)
	  );
	/** **/





	/** ToDo **/
	register_post_type( 'todos', 
		array(
		  'labels' => array(
			'name' => __( 'ToDo', 'it' ),
			'singular_name' => __( 'ToDo', 'it' ),		
			'add_new' => _x( 'Add New', 'ToDo', 'it' ),
			'add_new_item' => __( 'Add New ToDo', 'it' ),
			'edit_item' => __( 'Edit ToDo', 'it' ),
			'new_item' => __( 'New ToDo', 'it' ),
			'view_item' => __( 'View ToDo', 'it' ),
			'search_items' => __( 'Search ToDo items', 'it' ),
			'not_found' =>  __( 'No ToDo items found', 'it' ),
			'not_found_in_trash' => __( 'No ToDo Items found in Trash', 'it' ),
			'parent_item_colon' => ''
			
		  ),
		  'public' => true,
		  'supports' => array('title', 'revisions', 'thumbnail', 'custom-fields', 'editor', 'tags'),
		  'query_var' => true,
		  'show_ui' => true,
		  'rewrite' => array( 'slug' => 'todos' ),
		  'show_in_nav_menus' => false,
		  'exclude_from_search' => true,
		  'taxonomies' => array('post_tag'), // this is IMPORTANT
		   'menu_icon' => get_template_directory_uri() . '/images/admin/custom-post-type.png',
		)
	  );


	/** Goals
	register_post_type( 'goals', 
		array(
		  'labels' => array(
			'name' => __( 'Goals', 'it' ),
			'singular_name' => __( 'Goal', 'it' ),		
			'add_new' => _x( 'Add New', 'Goal', 'it' ),
			'add_new_item' => __( 'Add New Goal', 'it' ),
			'edit_item' => __( 'Edit Goal', 'it' ),
			'new_item' => __( 'New Goal', 'it' ),
			'view_item' => __( 'View Goal', 'it' ),
			'search_items' => __( 'Search Goals', 'it' ),
			'not_found' =>  __( 'No Goals found', 'it' ),
			'not_found_in_trash' => __( 'No Goals found in Trash', 'it' ),
			'parent_item_colon' => ''
			
		  ),
		  'public' => true,
		  'supports' => array('title', 'revisions', 'thumbnail', 'custom-fields', 'editor', 'tags'),
		  'query_var' => true,
		  'show_ui' => true,
		  'rewrite' => array( 'slug' => 'goals' ),
		  'show_in_nav_menus' => false,
		  'exclude_from_search' => true,
		  'taxonomies' => array('post_tag'), // this is IMPORTANT
		   'menu_icon' => get_template_directory_uri() . '/images/admin/custom-post-type.png',
		)
	  );
	  
	**/




	/** Projects **/
	register_post_type( 'projects_cpt',
		array(
		  'labels' => array(
			'name' => __( 'Projects', 'it' ),
			'singular_name' => __( 'Project', 'it' ),		
			'add_new' => _x( 'Add New', 'Project', 'it' ),
			'add_new_item' => __( 'Add New Project', 'it' ),
			'edit_item' => __( 'Edit Project', 'it' ),
			'new_item' => __( 'New Project', 'it' ),
			'view_item' => __( 'View Project', 'it' ),
			'search_items' => __( 'Search Projects', 'it' ),
			'not_found' =>  __( 'No Projects found', 'it' ),
			'not_found_in_trash' => __( 'No Projects found in Trash', 'it' ),
			'parent_item_colon' => ''
			
		  ),		 
		  'public' => true,
		  'supports' => array('title','editor','thumbnail','excerpt','custom-fields', 'tags','revisions','comments'),
		  'query_var' => true,
		  'rewrite' => array( 'slug' => 'projects_cpt' ),
		   'menu_icon' => get_template_directory_uri() . '/images/admin/custom-post-type.png',
		)
	);
	

}
?>
<?php
/**
* Register Custom Post Menus */
 
$prefix = 'it_';
$it_meta_boxes = array();


/* ToDo EXTRAS */
$it_meta_boxes[] = array(
	'id' => 'it_todos_entry_meta',
	'title' => __('ToDo Options','it'),
	'pages' => array('todos'),

	'fields' => array(
		array(
            'name' => __('ToDo Assignment', 'it'),
            'id' => $prefix . 'todo_assigned',
			'desc' => __('The id of the person who is assigned this todo', 'it'),
			'default' => 'default',
            'type' => 'text',
           
        ),
		array(
            'name' => __('ToDo: Date','it'),
            'desc' => __('This is used for WP Sorting - do not alter unless you know what you\'re doing','it'),
            'id' => $prefix . 'todo_deadline',
            'type' => 'text',
            'std' => ''
        ),
	)
);








/* TimeLOG EXTRAS */
$it_meta_boxes[] = array(
	'id' => 'it_timelog_entry_meta',
	'title' => __('Timelog Options','it'),
	'pages' => array('timelog'),

	'fields' => array(

		array(
            'name' => __('Project Relation','it'),
            'desc' => __('What project is this related to?','it'),
            'id' => $prefix . 'timelogspostproject',
            'type' => 'text',
            'std' => ''
        ) /*,            
		array(
            'name' => __('Invoiced?', 'it'),
            'id' => $prefix . 'invoiced',
			'desc' => __('Has this been invoiced?', 'it'),
			'default' => 'default',
            'type' => 'select',
            'options' => array(
				'disable' => 'no',
				'enable' => 'yes'
			),
        )*/

	)
);








/* Project EXTRAS */
$it_meta_boxes[] = array(
	'id' => 'it_projects_entry_meta',
	'title' => __('Project Options','it'),
	'pages' => array('projects_cpt'),

	'fields' => array(
		array(
            'name' => __('Project Deadline','it'),
            'desc' => __('This is used for WP Sorting - do not alter unless you keep the initial format','it'),
            'id' => $prefix . 'projects_deadline',
            'type' => 'text',
            'std' => ''
        ), 
		array(
            'name' => __('Project Assignment','it'),
            'desc' => __('The id of the person who is assigned this project','it'),
            'id' => $prefix . 'projects_assigned',
            'type' => 'text',
            'std' => ''
        ), 
		array(
            'name' => __('Project Client','it'),
            'desc' => __('Select the client whom this project is for?','it'),
            'id' => $prefix . 'projects_client',
            'type' => 'clients'
        ),
		array(
            'name' => __('Is the project complete?', 'it'),
            'id' => $prefix . 'show_project_complete',
			'desc' => __('Is the project complete?', 'it'),
			'default' => 'default',
            'type' => 'select',
            'options' => array(
				'disable' => 'no',
				'enable' => 'yes'
			),
        )
        
	)
);


/* Post EXTRAS */
$it_meta_boxes[] = array(
	'id' => 'it_post_meta',
	'title' => __('Post Options','it'),
	'pages' => array('post'),
	'fields' => array(
		array(
            'name' => __('Featured Image', 'it'),
            'id' => $prefix . 'single_featured_image',
			'desc' => __('You can enable or disable the featured image', 'it'),
            'type' => 'select',
            'options' => array(
				'enable' => 'enable',
				'disable' => 'disable'
			),
        ),
		array(
            'name' => __('Tags', 'it'),
            'id' => $prefix . 'single_tags',
            'type' => 'select',
            'options' => array(
				'enable' => 'enable',
				'disable' => 'disable'
			),
            'desc' => __('You can enable or disable the tags.', 'it'),
        ),
		array(
            'name' => __('Related Posts', 'it'),
            'id' => $prefix . 'single_related_posts',
			'desc' => __('You can enable or disable the related posts on blog posts.', 'it'),
            'type' => 'select',
            'options' => array(
				'enable' => 'enable',
				'disable' => 'disable'
			)
        ),
	)
);





// meta box ===> Page EXTRAS
$it_meta_boxes[] = array(
	'id' => 'it_meta_templates',
	'title' => __('Page Template Options','it'),
	'pages' => array('page'),
	'fields' => array(
		array(
			'name' => __('Blog Category', 'it'),
			'id' => $prefix . 'blog_parent',
			'type' => 'taxonomy',
			'taxonomy' => 'category',
			'desc' => __('If a blog page, select a category.','it')
		),
		array(
			'name' => __('Project Category', 'it'),
			'id' => $prefix . 'projects_cpt_parent',
			'type' => 'portfolio_cat',
			'type' => 'taxonomy',
			'taxonomy' => 'projects_cpt_cats',
			'desc' => __('Select a category for this project page.','it')
		),
		array(
            'name' => __('Results Per Page','it'),
            'desc' => __('Specify how many projects/team members you want to show per page on pages with pagination','it'),
            'id' => $prefix . 'template_posts_per_page',
            'type' => 'text',
            'std' => '-1'
        ),
        array(
            'name' => __('Column Style', 'it'),
            'id' => $prefix . 'grid_style',
            'type' => 'select',
			'desc' => __('Select the number of columns for projects/team members', 'it'),
            'options' => array(
				'3 Column' => '3 Column',
				'4 Column' => '4 Column',
				'List' => 'List',
				'Table' => 'Table'
			),
			'std' => '3 Column'
        ),
		array(
            'name' => __('Column Image Height','it'),
            'desc' => __('Default is 100% - you may increase or decrease it as you see fit.','it'),
            'id' => $prefix . 'grid_image_height',
            'type' => 'text',
            'std' => '100%'
        ),
		array(
            'name' => __('Show Completed Projects','it'),
            'desc' => __('If a project page, show only complete?','it'),
            'id' => $prefix . 'show_project_complete',
            'type' => 'select',
            'options' => array(
				'disable' => 'no',
				'enable' => 'yes'
			)
        ),
		array(
            'name' => __('Show Draft Projects','it'),
            'desc' => __('If a project page, show only drafts?','it'),
            'id' => $prefix . 'post_status_shown',
            'type' => 'select',
            'options' => array(
				'enable' => 'publish',
				'disable' => 'draft'
			)
        )
	)
);

foreach ($it_meta_boxes as $meta_box) {
	new it_meta_box($meta_box);
}
?>
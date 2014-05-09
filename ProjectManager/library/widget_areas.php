<?php
global $it_data; //get theme options

//main sidebar
register_sidebar(array(
	'name' => __( 'Sidebar','it'),
	'id' => 'sidebar',
	'description' => __( 'Main Widget Area','it' ),
	'before_widget' => '<div class="sidebar-box %2$s clearfix">',
	'after_widget' => '</div>',
	'before_title' => '<h4 class="heading"><span>',
	'after_title' => '</span></h4>',
));

?>
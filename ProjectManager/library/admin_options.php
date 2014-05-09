<?php
/*--------------------------------------*/
/*	Theme Options Front End
/*--------------------------------------*/

add_action('init','of_options');
if (!function_exists('of_options')) {
	function of_options() {

	//select options
	$show_hide = array(
		'enable' => 'enable',
		'disable' => 'disable'
	); 
	$disable_enable = array(
		'disable' => 'disable',
		'enable' => 'enable'
	); 
	$true_false = array(
		'true' => 'true',
		'false' => 'false'
	); 
	$fixed_static  = array(
		'fixed' => 'fixed',
		'static' => 'static'
	);

	$font_size = array(
		'Select' => 'Select',
		'12px' => '12px',
		'13px' => '13px',
		'14px' => '14px'
	);
	$font_weight = array(
		'Select' => 'Select',
		'normal' => 'normal',
		'bold' => 'bold'
	);
	$link_target = array(
		'_self' => 'Self',
		'_blank' => 'Blank'
	);
	$prettyphoto_themes = array(
		'pp_default' => 'Default',
		'light_rounded' => 'Light Rounded',
		'dark_rounded' => 'Dark Rounded',
		'light_square' => 'Light Square',
		'dark_square' => 'Dark Square',
		'facebook' => 'Facebook'
	);

	//location of admin images
	$url =  ADMIN_DIR . 'assets/images/';
	
	/*-----------------------------------------------------------------------------------*/
	/* The Options Array */
	/*-----------------------------------------------------------------------------------*/
	
	// Set the Options Array
	global $of_options;
	$of_options = array();
	
	
	
	
	
	/* !GENERAL */						
	$of_options[] = array( "name" => __('General Settings', 'it'),
					"type" => "heading");
						
	$of_options[] = array(
						"name" => "",
						"desc" => "",
						"id" => "general_heading",
						"std" => "<h3 style=\"margin: 0;\">".__('Logos and Branding','it')."</h3>",
						"icon" => false,
						"type" => "info");
						
	$of_options[] = array( "name" => __('Custom Logo (Main)', 'it'),
						"desc" => __('You can upload your main site logo here or paste the URL here.', 'it'),
						"id" => "custom_logo",
						"std" => "",
						"type" => "media");
						
	$of_options[] = array( "name" => __('Custom Logo (Login)', 'it'),
						"desc" => __('You can upload a custom logo for the Wordpress Login Page here or paste the URL here.', 'it'),
						"id" => "custom_login_logo",
						"std" => "",
						"type" => "media");
						
	$of_options[] = array( "name" => __('Custom Login Background', 'it'),
						"desc" => __('You can upload a custom background for the Wordpress Login Page here or paste the URL here.', 'it'),
						"id" => "custom_login_background",
						"std" => "",
						"type" => "media");
						
	$of_options[] = array( "name" => __('Custom Height - Login Logo', 'it'),
						"desc" => __('You can customize the height of the login logo if need be (the width should not be changed)', 'it'),
						"id" => "custom_login_logo_height",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Responsive Menu Icon', 'it'),
						"desc" => __('Upload or paste the URL here for your responsive menu icon (50px x 50px).', 'it'),
						"id" => "mobile_logo",
						"std" => "",
						"type" => "upload");
												
	$of_options[] = array( "name" => __('Favicon', 'it'),
						"desc" => __('Upload or paste the URL here for your favicon.', 'it'),
						"id" => "custom_fav",
						"std" => "",
						"type" => "upload");

	$of_options[] = array( "name" => __('Enable/Disable Randomized Passwords', 'it'),
						"desc" => "Enable if you'd like ProjectPress to randomly generate passwords for users instead of having them specified.",
						"id" => "password_generator",
						"std" => "disable",
						"type" => "select",
						"options" => $disable_enable);

	$of_options[] = array( "name" => __('Show Projects List', 'it'),
						"desc" => "Enable if you want to use the list of projects in the left hand menu bar.",
						"id" => "show_projects_list",
						"std" => "enable",
						"type" => "select",
						"options" => $disable_enable);

	$of_options[] = array( "name" => __('Show Projects', 'it'),
						"desc" => "Disable if you want to hide the Projects Page (2nd link) from the left hand menu bar for everyone who is not an admin.",
						"id" => "show_projects",
						"std" => "enable",
						"type" => "select",
						"options" => $disable_enable);

	$of_options[] = array( "name" => __('User WP User Avatar', 'it'),
						"desc" => "Enable if you'd like to use the WP User Avatar instead of Gravatar (Gravatar will still be backup source for user images).",
						"id" => "use_user_avatar",
						"std" => "disable",
						"type" => "select",
						"options" => $disable_enable);
												
	$of_options[] = array( "name" => __('Copyright', 'it'),
						"desc" => __('Your text/HTML for copyright goes here.', 'it'),
						"id" => "custom_copyright",
						"std" => "",
						"type" => "textarea");

	$of_options[] = array( "name" => __('Custom CSS', 'it'),
						"desc" => __('Place any Custom CSS you may have need of here.', 'it'),
						"id" => "custom_css",
						"std" => "",
						"type" => "textarea");					

											
	/* !PAGE LINKS */					
	$of_options[] = array( "name" => __('Page Links', 'it'),
						"type" => "heading");						

	$of_options[] = array( "name" => __('Add Team Members Page Title', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_add_users_title",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('Add Team Members Page', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_add_users",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('Add Clients Page Title', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_add_clients_title",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('Add Clients Page', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_add_clients",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('My Projects Page Title', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_my_projects_title",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('My Projects Page', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_my_projects",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('My Project Log Title', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_my_log_title",
						"std" => "",
						"type" => "text");	
						
	$of_options[] = array( "name" => __('My Project Log', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_my_log",
						"std" => "",
						"type" => "text");						
						
	$of_options[] = array( "name" => __('My Tasks Page Title', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_my_tasks_title",
						"std" => "",
						"type" => "text");						

	$of_options[] = array( "name" => __('My Tasks Page', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_my_tasks",
						"std" => "",
						"type" => "text");						
					
	$of_options[] = array( "name" => __('Page for Add Projects Title', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_add_projects_title",
						"std" => "",
						"type" => "text");					

	$of_options[] = array( "name" => __('Page for Add Projects', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_add_projects",
						"std" => "",
						"type" => "text");					

	$of_options[] = array( "name" => __('Default Page for Projects Title', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_projects_live_title",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Default Page for Projects', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_projects_live",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('Page for Team Page Title', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_team_title",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('Page for Team Page', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_team_page",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('Page for User Profiles - Single', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_profile_title",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Page for User Profiles - Single', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_profile_page",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('Page for Client Page Title', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_client_title",
						"std" => "",
						"type" => "text");
	
	$of_options[] = array( "name" => __('Page for Client Page', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_client_page",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('Page for Client Profiles - Single Title', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_client_profile_title",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('Page for Client Profiles - Single', 'it'),
						"desc" => __('Paste the URL here.', 'it'),
						"id" => "user_client_profile_page",
						"std" => "",
						"type" => "text");





	/* !HOME PAGE */					
	$of_options[] = array( "name" => __('Home Page', 'it'),
						"type" => "heading");
	
	$of_options[] = array(
						"name" => "",
						"desc" => "",
						"id" => "homepage_tagline_heading",
						"std" => "<h3 style=\"margin: 0;\">".__('Homepage Tagline','it')."</h3>",
						"icon" => false,
						"type" => "info");
					
	$of_options[] = array( "name" => __('Tagline Title', 'it'),
						"desc" => __('Leave blank in order to not show tagline title.', 'it'),
						"id" => "homepage_tagline_title",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Tagline URL', 'it'),
						"desc" => __('Leave blank for no link when tagline is clicked.', 'it'),
						"id" => "homepage_tagline_title_url",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Tagline', 'it'),
						"desc" => __('Enter content here - HTML and shortcodes allowed.', 'it'),
						"id" => "homepage_tagline",
						"std" => 'Praesent commodo cursus magna, vel scelerisque.<br /> Nullam quis risus eget urna mollis ornare vel ullamcorper nulla non metus auctor fringilla.',
						"type" => "textarea");	
						
						
						
						


	/* !CLIENT HOME PAGE */					
	$of_options[] = array( "name" => __('Email Message Customization', 'it'),
						"type" => "heading");
	
	$of_options[] = array(
						"name" => "",
						"desc" => "",
						"id" => "email_message_heading",
						"std" => "<h3 style=\"margin: 0;\">".__('Email Message Customization','it')."</h3>",
						"icon" => false,
						"type" => "info");
					
	$of_options[] = array( "name" => __('New Project Subject', 'it'),
						"desc" => __('Leave blank for default value', 'it'),
						"id" => "projects_add_subject",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('New Project Message', 'it'),
						"desc" => __('Leave blank for default value', 'it'),
						"id" => "projects_add_message",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('New Task Subject', 'it'),
						"desc" => __('Leave blank for default value', 'it'),
						"id" => "projects_add_task_subject",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('New Task Message', 'it'),
						"desc" => __('Leave blank for default value', 'it'),
						"id" => "projects_add_task_message",
						"std" => "",
						"type" => "text");






	/* !CLIENT HOME PAGE */					
	$of_options[] = array( "name" => __('Client Home Page', 'it'),
						"type" => "heading");
	
	$of_options[] = array(
						"name" => "",
						"desc" => "",
						"id" => "client_homepage_tagline_heading",
						"std" => "<h3 style=\"margin: 0;\">".__('Client Homepage Tagline','it')."</h3>",
						"icon" => false,
						"type" => "info");
					
	$of_options[] = array( "name" => __('Client Tagline Title', 'it'),
						"desc" => __('Leave blank in order to not show tagline title.', 'it'),
						"id" => "client_homepage_tagline_title",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Client Tagline URL', 'it'),
						"desc" => __('Leave blank for no link when tagline is clicked.', 'it'),
						"id" => "client_homepage_tagline_title_url",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Client Tagline', 'it'),
						"desc" => __('Enter content here - HTML and shortcodes allowed.', 'it'),
						"id" => "client_homepage_tagline",
						"std" => 'Praesent commodo cursus magna, vel scelerisque.<br /> Nullam quis risus eget urna mollis ornare vel ullamcorper nulla non metus auctor fringilla.',
						"type" => "textarea");	
						
	$of_options[] = array( "name" => __('Show/Hide Client Announcements', 'it'),
						"desc" => __('Do you want to show the client your latest blog post on their dashboard', 'it'),
						"id" => "show_client_announcements",
						"std" => "disable",
						"type" => "select",
						"options" => $disable_enable);						






					
						





	/* !Client Capabilities */					
	$of_options[] = array( "name" => __('Client Capabilities', 'it'),
						"type" => "heading");
						
	$of_options[] = array( "name" => __('Can Edit Deadline', 'it'),
						"desc" => __('Can your client edit the project deadline', 'it'),
						"id" => "client_edit_deadline",
						"std" => "disable",
						"type" => "select",
						"options" => $disable_enable);						
						
	$of_options[] = array( "name" => __('Can Edit Project Title/Description', 'it'),
						"desc" => __('Can your client edit the project title or description', 'it'),
						"id" => "client_edit_description",
						"std" => "disable",
						"type" => "select",
						"options" => $disable_enable);						
						
	$of_options[] = array( "name" => __('Can Add Tasks', 'it'),
						"desc" => __('Can your client add project tasks', 'it'),
						"id" => "client_add_tasks",
						"std" => "disable",
						"type" => "select",
						"options" => $disable_enable);						
						
	$of_options[] = array( "name" => __('Can Add Files', 'it'),
						"desc" => __('Can your client add project files', 'it'),
						"id" => "client_add_files",
						"std" => "disable",
						"type" => "select",
						"options" => $disable_enable);						






	/* !Blog */					
	$of_options[] = array( "name" => __('Blog', 'it'),
						"type" => "heading");
						
	$of_options[] = array(
						"name" => "",
						"desc" => "",
						"id" => "blog_entries_heading",
						"std" => "<h3 style=\"margin: 0;\">".__('Main Blog','it')."</h3>",
						"icon" => false,
						"type" => "info");
						
	$of_options[] = array( "name" => __('Show Full Content', 'it'),
						"desc" => __('Enable to show full post content.', 'it'),
						"id" => "enable_full_blog",
						"std" => "disable",
						"type" => "select",
						"options" => $disable_enable);	
						
	$of_options[] = array( "name" => __('Post Excerpt Length', 'it'),
						"desc" => __('Enter a custom length for blog excerpts.', 'it'),
						"id" => "blog_excerpt",
						"std" => "23",
						"type" => "text");

	$of_options[] = array( "name" => __('Main Blog - Read More Button', 'it'),
						"desc" => __('Choose to show or hide the read more button on your blog pages.', 'it'),
						"id" => "blog_read_more",
						"std" => "enable",
						"type" => "select",
						"options" => $show_hide);
						
	$of_options[] = array( "name" => __('Image Hover Color', 'it'),
						"desc" => __('Choose your hover color when mousing over blog entries.', 'it'),
						"id" => "blog_overlay_color",
						"std" => "",
						"type" => "color");
						
	$of_options[] = array( "name" => __('Image Hover Opacity', 'it'),
						"desc" => __('Choose the opacity at which the above color is rendered. Choose from 0 - 1 (ex. .01, .02, .03, etc)', 'it'),
						"id" => "blog_overlay_opacity",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('Main Blog - Featured Image Height', 'it'),
						"desc" => __('Default is 100% - you may increase or decrease it as you see fit.', 'it'),
						"id" => "blog_img_height",
						"std" => "100%",
						"type" => "text");
						
																		
	$of_options[] = array(
						"name" => "",
						"desc" => "",
						"id" => "blog_posts_heading",
						"std" => "<h3 style=\"margin: 0;\">".__('Single Posts','it')."</h3>",
						"icon" => false,
						"type" => "info");

	$of_options[] = array( "name" => __('Post - Show Featured Image', 'it'),
						"desc" => __('Choose to show/hide the featured image', 'it'),
						"id" => "show_hide_post_image",
						"std" => "enable",
						"type" => "select",
						"options" => $show_hide);
						
	$of_options[] = array( "name" => __('Post - Crop Featured Images', 'it'),
						"desc" => __('Enable to crop featured images, disabled to show full width.', 'it'),
						"id" => "show_hide_single_post_image_crop",
						"std" => "enable",
						"type" => "select",
						"options" => $show_hide);

	$of_options[] = array( "name" => __('Post - Featured Image Height', 'it'),
						"desc" => __('Default is 100% - you may increase or decrease it as you see fit.', 'it'),
						"id" => "post_image_height",
						"std" => "100%",
						"type" => "text");
												
	$of_options[] = array( "name" => __('Post - Meta', 'it'),
						"desc" => __('Choose to show or hide meta information on single blog posts. ', 'it'),
						"id" => "show_hide_single_meta",
						"std" => "enable",
						"type" => "select",
						"options" => $show_hide);
						
	$of_options[] = array( "name" => __('Post - Tags', 'it'),
						"desc" => __('Choose to show or hide post tags on single blog posts. ', 'it'),
						"id" => "show_hide_single_tags",
						"std" => "enable",
						"type" => "select",
						"options" => $show_hide);
						
	$of_options[] = array( "name" => __('Post - Related Posts', 'it'),
						"desc" => __('Choose to show or hide related posts on single blog posts. ', 'it'),
						"id" => "show_hide_single_related_posts",
						"std" => "enable",
						"type" => "select",
						"options" => $show_hide);
						






	



	/* !Discussion */					
	$of_options[] = array( "name" => __('Discussion', 'it'),
							"type" => "heading");
							
	$of_options[] = array( "name" => __('Espaço para comentar', 'it'),
						"desc" => __('Comment placeholder text', 'it'),
						"id" => "comment_notice",
						"std" => "Você pode deixar um comentário aqui.",
						"type" => "textarea");
						
	$of_options[] = array( "name" => __('Show/Hide Comments On Blogs', 'it'),
						"desc" => __('Select to enable/disable comments on blog posts sitewide.', 'it'),
						"id" => "show_hide_blog_comments",
						"std" => "enable",
						"type" => "select",
						"options" => $show_hide);
															
	$of_options[] = array( "name" => __('Show/Hide Comments On Pages', 'it'),
						"desc" => __('Select to enable/disable comments on regular pages sitewide.', 'it'),
						"id" => "show_hide_page_comments",
						"std" => "disable",
						"type" => "select",
						"options" => $disable_enable);
						

	$of_options[] = array( "name" => __('Show/Hide Comments On Projects', 'it'),
						"desc" => __('Select to enable/disable comments on projects sitewide.', 'it'),
						"id" => "show_hide_projects_comments",
						"std" => "enable",
						"type" => "select",
						"options" => $disable_enable);






	/* !Translations */					
	$of_options[] = array( "name" => __('Translations', 'it'),
						"type" => "heading");

						
	$of_options[] = array(
						"name" => "",
						"desc" => "",
						"id" => "types_heading",
						"std" => "<p style=\"margin: 0;\">".__('Thanks to early ProjectPress users who helped me identify some of the gaps in Wordpress Translation for these.','it')."</p>",
						"icon" => false,
						"type" => "info");



	$of_options[] = array(
						"name" => "",
						"desc" => "",
						"id" => "backgrounds_heading",
						"std" => "<h3 style=\"margin: 0;\">".__('User Role Translations','it')."</h3>",
						"icon" => false,
						"type" => "info");

	$of_options[] = array( "name" => __('Administrator', 'it'),
						"desc" => __('Custom text for administrator user role.', 'it'),
						"id" => "translation_administrator",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('Editor', 'it'),
						"desc" => __('Custom text for editor user role.', 'it'),
						"id" => "translation_editor",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('Client', 'it'),
						"desc" => __('Custom text for client user role.', 'it'),
						"id" => "translation_client",
						"std" => "",
						"type" => "text");
						
						
						

	$of_options[] = array(
						"name" => "",
						"desc" => "",
						"id" => "backgrounds_heading",
						"std" => "<h3 style=\"margin: 0;\">".__('Other Translations','it')."</h3>",
						"icon" => false,
						"type" => "info");

	$of_options[] = array( "name" => __('Related Items', 'it'),
						"desc" => __('Custom related items text.', 'it'),
						"id" => "translation_related_items_text",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Related Blog Posts', 'it'),
						"desc" => __('Custom related blog posts text.', 'it'),
						"id" => "translation_related_articles_text",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Read More Text', 'it'),
						"desc" => __('Custom read more text.', 'it'),
						"id" => "translation_read_more_text",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Meta Information - "Tags"', 'it'),
						"desc" => __('Custom "tags" text.', 'it'),
						"id" => "translation_tags_text",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Meta Information - "Post By"', 'it'),
						"desc" => __('Custom "post by" text.', 'it'),
						"id" => "translation_post_by_text",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Comments', 'it'),
						"desc" => __('Custom comments text.', 'it'),
						"id" => "translation_comments_text",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Comments Disabled', 'it'),
						"desc" => __('Custom comments disabled text.', 'it'),
						"id" => "translation_comments_disabled_text",
						"std" => "",
						"type" => "text");

	$of_options[] = array( "name" => __('Deixar um Comentário', 'it'),
						"desc" => __('Custom leave a reply text.', 'it'),
						"id" => "translation_leave_reply_text",
						"std" => "",
						"type" => "text");	
						
	$of_options[] = array( "name" => __('Name', 'it'),
						"desc" => __('Custom "name" text.', 'it'),
						"id" => "translation_comments_name_text",
						"std" => "",
						"type" => "text");	
						
	$of_options[] = array( "name" => __('Email', 'it'),
						"desc" => __('Custom "email" text.', 'it'),
						"id" => "translation_comments_email_text",
						"std" => "",
						"type" => "text");	
						
	$of_options[] = array( "name" => __('Website', 'it'),
						"desc" => __('Custom "website" text.', 'it'),
						"id" => "translation_comments_website_text",
						"std" => "",
						"type" => "text");	
																	
	$of_options[] = array( "name" => __('Comment Navigation', 'it'),
						"desc" => __('Custom "navigation" text.', 'it'),
						"id" => "translation_comments_menu_text",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Older Comments', 'it'),
						"desc" => __('Custom "older comments" text.', 'it'),
						"id" => "translation_comments_older_text",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Newer Comments', 'it'),
						"desc" => __('Custom "newer comments" text.', 'it'),
						"id" => "translation_comments_newer_text",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Reply To Comment', 'it'),
						"desc" => __('Custom "reply to comment" text.', 'it'),
						"id" => "translation_reply_to_text",
						"std" => "",
						"type" => "text");	
						
	$of_options[] = array( "name" => __('Post Comment', 'it'),
						"desc" => __('Custom "post comment" text.', 'it'),
						"id" => "translation_post_comment_text",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Log In To Post Comment', 'it'),
						"desc" => __('Custom "Log in to Post Comment" text.', 'it'),
						"id" => "translation_comment_log_in_text",
						"std" => "",
						"type" => "text");	
								
	$of_options[] = array( "name" => __('Search Results - Entries Found', 'it'),
						"desc" => __('Custom search results text - entries found.', 'it'),
						"id" => "translation_search_results_text",
						"std" => "",
						"type" => "text");
						
	$of_options[] = array( "name" => __('Search Results - Nothing Found', 'it'),
						"desc" => __('Enter search results text - nothing found.', 'it'),
						"id" => "translation_no_search_results_text",
						"std" => "",
						"type" => "text");	
										
	$of_options[] = array( "name" => __('404 Error', 'it'),
						"desc" => __('Custom 404 text.', 'it'),
						"id" => "custom_404_text",
						"std" => "",
						"type" => "textarea");		
					
						





	/* !Analytics */					
	$of_options[] = array( "name" => __('Analytics', 'it'),
						"type" => "heading");
						
	$of_options[] = array(
						"name" => "",
						"desc" => "",
						"id" => "tracking_heading",
						"std" => "",
						"icon" => false,
						"type" => "info");
						
	$of_options[] = array( "name" => __('Analytics Code (Header)', 'it'),
						"desc" => __('Input your Google Analytics (or similiar) code here. Anything placed here will be added into header.php.', 'it'),
						"id" => "analytics_header",
						"std" => "",
						"type" => "textarea");    
						
	$of_options[] = array( "name" => __('Analytics Code (Footer)', 'it'),
						"desc" => __('Input your Google Analytics (or similiar) code here. Anything placed here will be added into footer.php.', 'it'),
						"id" => "analytics_footer",
						"std" => "",
						"type" => "textarea");





	/* !ThemeForest Notifications*/
	$of_options[] = array( "name" => __('Theme Updates', 'it'),
						"type" => "heading");

	$of_options[] = array(
						"name" => "",
						"desc" => "",
						"id" => "updates_main_heading",
						"std" => "<h3 style=\"margin: 0;\">".__('Theme Updates','it')."</h3>",
						"icon" => false,
						"type" => "info");
						
	$of_options[] = array( "name" => __('ThemeForest Username', 'it'),
						"desc" => __('Your ThemeForest Username', 'it'),
						"id" => "tf_username",
						"std" => __('Your Username','it'),
						"type" => "text");
						
	$of_options[] = array( "name" => __('Themeforest API Key', 'it'),
						"desc" => __('Enter your API Key.', 'it'),
						"id" => "tf_api_key",
						"std" => __('Your API Key','it'),
						"type" => "text");


		
		
	/* !Credit */		
	$of_options[] = array( "name" => __('Menu Options Credit', 'it'),
						"type" => "heading");
						
	$of_options[] = array(
						"name" => "",
						"desc" => "",
						"id" => "types_heading",
						"std" => "<p style=\"margin: 0;\">".__('This theme uses the Options Framework with a bit of customization added for extra functionality.','it')."</p>",
						"icon" => false,
						"type" => "info");
											
		}
}
?>

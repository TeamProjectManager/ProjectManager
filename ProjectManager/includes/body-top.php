<?php 
//get global variables

global $it_data;



if ( ( is_single() || is_front_page() || is_page() ) 
       && !is_page('login') && !is_user_logged_in()){ 
    auth_redirect(); 
} 


    wp_get_current_user();

    global $current_user_username;
    global $current_user_email;
    global $current_user_firstname;
    global $current_user_lastname;
    global $current_user_displayname;
    global $current_user_id;
    global $myprofile;
 
    $current_user_username = $current_user->user_login;
    $current_user_email = $current_user->user_email;
   	$current_user_firstname = $current_user->user_firstname;
    $current_user_lastname = $current_user->user_lastname;
    $current_user_displayname = $current_user->display_name;
    $current_user_id = $current_user->ID;
    
     
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
		global $isclient;
		$isclient = true;
	} else {
		global $isclient;
		$isclient = false;	
	}

 
	//pages and names
	$stafftitle = $it_data['user_profile_title'];
	$staffurl = $it_data['user_profile_page'];
	$clientprofiletitle = $it_data['user_client_profile_title'];
	$clienturl = $it_data['user_client_profile_page'];
	$addusertitle = $it_data['user_add_users_title'];
   	$adduserpage = $it_data['user_add_users']; 
	$addclienttitle = $it_data['user_add_clients_title'];
   	$addclientpage = $it_data['user_add_clients']; 
	$projlivetitle = $it_data['user_projects_live_title'];
   	$projlive = $it_data['user_projects_live']; 
//   	$projdraft = $it_data['user_projects_draft']; 
//   	$myprojs_title = $it_data['user_my_projects_title']; 
//   	$myprojs = $it_data['user_my_projects']; 
	$mylogtitle = $it_data['user_my_log_title'];
   	$mylog = $it_data['user_my_log']; 
	$mytaskstitle = $it_data['user_my_tasks_title'];
   	$mytasks = $it_data['user_my_tasks']; 
	$teamtitle = $it_data['user_team_title'];
   	$teampage = $it_data['user_team_page'];
	$clienttitle = $it_data['user_client_title'];
   	$clientpage = $it_data['user_client_page'];
	$addprojtitle = $it_data['user_add_projects_title'];
	$projectaddpage = $it_data['user_add_projects'];


	$use_user_avatar = $it_data['use_user_avatar'];

	$avatar	= get_avatar( $current_user_email, 50 );
	$avatar_200	= get_avatar( $current_user_email, 220 );

	$today = date(get_option('date_format'));



	//get the number of assigned tasks

			   if (isset($user_role) && ($user_role != "$clientword")){
			
					$args = array(
					    'orderly' => 'title',
					    'show_posts' => '-1', 
					    'posts_per_page' => '-1', 
					    'order' => 'ASC',
					    'post_type' => 'todos',
					    'meta_query' => array(
					        array(
					            'key' => 'it_todo_assigned',
					            'value' => $current_user_id,
					            'compare' => '='
					        )
					    )
					);
			
			   }
			   
			   	if (isset($user_role) && ($user_role == "$clientword")){
					
					$args = array(
					    'orderly' => 'title',
					    'show_posts' => '-1', 
					    'posts_per_page' => '-1', 
					    'order' => 'ASC',
					    'post_type' => 'todos',
					    'meta_query' => array(
					        array(
					            'key' => 'it_todo_assigned',
					            'value' => $current_user_id,
					            'compare' => '='
					        )
					    )
					);
			
				}
			
			
					$wp_query_assigned = new WP_Query($args); 
			
						$i = 0;
			
						if ( $wp_query_assigned->have_posts() ) :
			            	while ($wp_query_assigned->have_posts()) : $wp_query_assigned->the_post();
			            
								$i++;
			            
							endwhile; 
						endif;
			
		
?>
     
    
    <!-- this is where the logo and menu column go -->
	<div class="menu-side">

	<!-- LOGO -->
    <div id="logo">
        <?php if($it_data['custom_logo']) { ?>
            <a href="<?php echo home_url(); ?>/" title="<?php get_bloginfo( 'name' ); ?>" rel="home"><img src="<?php if ($it_data['custom_logo'] == '' ) { echo get_template_directory_uri() . '/images/logo.png'; } else { echo $it_data['custom_logo']; } ?>" alt="<?php get_bloginfo( 'name' ) ?>" /></a>
        <?php } else { ?>
        	 <h2><a href="<?php echo home_url(); ?>/" title="<?php get_bloginfo( 'name' ); ?>" rel="home"><?php echo get_bloginfo( 'name' ); ?></a></h2>
        <?php } ?>
        
    </div><!-- /logo -->

        	<div id="mobile">
        		<img src="<?php echo $it_data['mobile_logo']; ?>" />
        	</div>


<?php 
$showlist = $it_data['show_projects_list'];
$showprojects = $it_data['show_projects'];
?>


	<!-- PROJECTS -->
	<div class="bs-sidebar">
	  	<ul class="nav bs-sidenav animated fadeInUp" id="regularmenu"><!--border-left: 4px solid #d45b43;-->
		  	<li class=""><a href="<?php echo home_url(); ?>">Dashboard</a></li>
			<li class="active <?php if (($showprojects == 'disable') && ($isadmin == false)) { echo ' displaynone'; } ?>"><a href="<?php echo $projlive; ?>">Projetos</a>

				<?php    
		                                         
		        $wp_query = new WP_Query( array( 
		        'post_type' => 'projects_cpt', 
		        'orderby' => 'date', 
		        'order' => 'ASC', 
		        'paged' => $paged, 
		        'posts_per_page' => -1 
		        ) ); 
		        
		      	if ( have_posts() ) :
		        ?>
		                    
		        <ul class="nav nav-sub  <?php if ($showlist == 'disable') { echo ' displaynone'; } ?>">
		
		        <?php
		        while ($wp_query->have_posts()) : $wp_query->the_post();
		
					$projectsclient = '';
					$custom = get_post_custom($post->ID); 
					if (isset($custom['it_projects_client'])) { $projectsclient = $custom['it_projects_client'][0]; } else { $projectsclient = ''; }
		
		            ?>
		            <li data-id="<?php echo $post->ID; ?>" class="<?php if ($isclient == true) { if ($projectsclient != $current_user_username) { echo ' displaynone'; } } ?>">
					<a href="<?php echo the_permalink(); ?>">
						<?php the_title(); ?>
					</a>
		            </li>
		
		   <?php endwhile; ?>
			    <?php else : ?>
					<li class="noprojects">Você não tem projetos.</li>
				<?php endif; ?>
			
					<li data-id="" class="<?php if ($isclient == true) { if ($projectsclient != $current_user_username) { echo ' displaynone'; } } ?>">
						<a href="<?php echo $projectaddpage; ?>" class="addprojects"><icon class="icon icon-plus"></icon> Adicionar Projeto</a>
					</li>
					<?php /* <li data-id="" class="<?php if ($isclient == true) { if ($projectsclient != $current_user_username) { echo ' displaynone'; } } ?>">
						<a href="<?php echo $projdraft; ?>" class="addprojects"><icon class="icon icon-minus"></icon> Draft Projects</a>
					</li> */ ?>
				</ul> <!-- / end projects -->

			</li>
			<li><a href="<?php echo $mytasks; ?>">Minhas Tarefas <?php if ($i > 0){ ?><span class="badge badge-important margintop2up"><?php echo $i; ?></span><?php } ?></a></li>
	  	</ul>




	  	<ul class="nav bs-sidenav" id="responsivemenu"><!--border-left: 4px solid #d45b43;-->
		  	<li class=""><a href="<?php echo home_url(); ?>"><icon class="icon icon-home icon-white"></icon></a></li>
			<li class="active"><a href="<?php echo $projlive; ?>"><icon class="icon icon-briefcase icon-white"></icon></a></li>
			<li data-id="" class="<?php if ($isclient == true) { if ($projectsclient != $current_user_username) { echo ' displaynone'; } } ?>">
				<a href="<?php echo $projectaddpage; ?>"><icon class="icon icon-plus icon-white"></icon></a>
			</li>
			<li><a href="<?php echo $mytasks; ?>"><icon class="icon icon-tasks icon-white"></icon></a></li>
	  	</ul>

<?php



	
		// GET THE USER's ROLE
	
		$user_role = get_user_role();
		if ($user_role == "client") {	
			$isclient = true;
		} else {
			$isclient = false;	
		}



		
		// CHECK FOR A RESPONSIVE MENU AND GET THE RIGHT ONE, BASED ON USER ROLE 
	
		if (function_exists('wp_nav_menu')) { // if 3.0 menus exist
		
		if (isset($user_role) && ($user_role != "client")){
		
			wp_nav_menu( array(
       			'sort_column' => 'menu_order',
                'menu_class' => 'nav bs-sidenav',
                'container_id' => 'responsivemenu',
       	        'theme_location' => 'responsive_top_menu',
       	        'fallback_cb' => false,
       	        'walker' => new it_menu_walker()

		    ) );
		    
		} elseif (isset($user_role) && ($user_role == "client")) {
				
			wp_nav_menu( array(
       			'sort_column' => 'menu_order',
                'menu_class' => 'nav bs-sidenav',
                'container_id' => 'responsivemenu',
       	        'theme_location' => 'responsive_client_menu',
       	        'fallback_cb' => false,
       	        'walker' => new it_menu_walker()

		    ) );
		} else {
			wp_page_menu( 'show_home=0&sort_column=menu_order&menu_class=nav bs-sidenav&containerid=responsivemenu' ); 
		} 
		
		} //if menu



		
		// CHECK FOR A RESPONSIVE MENU AND GET THE RIGHT ONE, BASED ON USER ROLE 
	
		if (function_exists('wp_nav_menu')) { // if 3.0 menus exist
		
		if (isset($user_role) && ($user_role != "client")){
		
			wp_nav_menu( array(
       			'sort_column' => 'menu_order',
                'menu_class' => 'nav bs-sidenav',
                'container_id' => 'regularmenu',
       	        'theme_location' => 'top_menu',
       	        'fallback_cb' => false,
       	        'walker' => new it_menu_walker()

		    ) );
		    
		} elseif (isset($user_role) && ($user_role == "client")) {
				
			wp_nav_menu( array(
       			'sort_column' => 'menu_order',
                'menu_class' => 'nav bs-sidenav',
                'container_id' => 'regularmenu',
       	        'theme_location' => 'client_menu',
       	        'fallback_cb' => false,
       	        'walker' => new it_menu_walker()

		    ) );
		} else {
			wp_page_menu( 'show_home=0&sort_column=menu_order&menu_class=nav bs-sidenav&containerid=regularmenu' ); 
		} 
		
		} //if menu
		
?>


<?php /*		
            <div id="responsive-login">
        
       
				<!-- INSERT LOGGED IN INFO HERE - RESPONSIVE, PHONE -->	            
				<span><a href="<?php if (isset($user_role) && ($user_role == "$clientword")){ echo $clienturl; } else { echo $staffurl; }?>/?user=<?php echo $current_user_id; ?>"><?php echo $avatar; ?></a></a>
					<?php if (isset($user_role) && ($user_role == "$clientword")){ ?>

					<a href="<?php echo wp_logout_url( home_url('/'.$current_user_username.'') ); ?>">Log Out</a>
					
					<?php } else { ?>

					<a href="<?php echo wp_logout_url( home_url() ); ?>">Log Out</a> <?php } ?></span>
       
       
            </div><!-- /res[onsivelogin -->

*/ ?>

				  <?php get_sidebar(); ?>
     		
				  <?php wp_reset_query(); ?>
                       
     </div><!-- /topbar-nav -->
   
    <!-- end logo / navigation container-->
	</div>
    
    
	<!-- start page container -->    
	<div class="content-side ">  


		<div class="content-side-header">
			<h2 class="pagetitle_final"><?php echo $pagetitle; ?></h2>
			
				<!-- INSERT LOGIN HERE -->
				<div id="sub-header-user">
					<div id="sub-header-pic">
						<?php
			   			echo $avatar;
			   			?>
			   		</div>
	   		
			   		<div id="sub-header-info">
						<h2><a href="<?php if (isset($user_role) && ($user_role == "$clientword")){ echo $clienturl; } else { echo $staffurl; }?>/?user=<?php echo $current_user_id; ?>"><?php echo $current_user_displayname; ?></h4>
						<h5><?php echo $current_user_email; ?></h5></a>
						
						<?php if (isset($user_role) && ($user_role == "$clientword")){ ?>
							<span><a href="<?php echo wp_logout_url( home_url('/'.$current_user_username.'') ); ?>">Log Out</a></span>
						<?php } else { ?>
							<span><a href="<?php echo wp_logout_url( home_url() ); ?>">Log Out</a></span>					
						<?php } ?>
						
					</div>
				</div>
			
			
		</div>


		<!-- this is the outer row for the two main site columns -->
		<div id="wrap" class="outer-container clearfix">

			<div id="content-left" class="">



		<div class="clearfix"></div>
		
		
		
		</div><! -- END LEFT SIDE -->



		<div id="content-main" class="">
 
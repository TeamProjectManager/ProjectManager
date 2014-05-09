<?php
/**
 * Project Manager
 */

//get theme options
global $it_data;

//get tempate header
get_header();
require_once ( 'includes/body-top.php' );

//results found
if (have_posts()) : ?>
        
        	<header id="page-heading">
				<h1 id="archive-title"><?php if($it_data['translation_search_results_text']) { echo $it_data['translation_search_results_text']; } else { _e('Search Results For','it'); } ?>: <?php the_search_query(); ?></h1>
            </header><!-- /page-heading -->
            
			<div id="post" class="clearfix">

			<?php
			//show posts using the serach loop
        	get_template_part( 'includes/loop', 'search');
			
			//paginate pages
			pagination(); ?>
        
			</div><!-- /post  -->
        
		<?php
		//no results found
        else : ?>
        
			<header id="page-heading">
				<h1 id="archive-title"><?php if($it_data['translation_search_results_text']) { echo $it_data['translation_search_results_text']; } else { _e('Search Results For','it'); } ?>: <?php the_search_query(); ?></h1>
        	</header><!-- /page-heading -->
            
            <div id="post" class="post clearfix">
            	<?php if($it_data['translation_no_search_results_text']) { echo $it_data['translation_no_search_results_text']; } else { _e('No results found for that query.', 'it'); } ?>
			</div><!-- /post  -->
            
        <?php endif; ?>

<?php
//get template sidebar
get_sidebar('pages');

//get template footer
get_footer(); ?>
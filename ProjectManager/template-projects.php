<?php
/**
 * Project Manager
 * Template Name: Projetos
*/

//get theme options
global $it_data;

//get template header
get_header();
$pagetitle = $it_data['user_projects_live_title']; 
if ($pagetitle == '') { $pagetitle="Projects"; }
require_once ( 'includes/body-top.php' );

//start page loop
if (have_posts()) : while (have_posts()) : the_post();

//posts per page
$template_posts_per_page = get_post_meta($post->ID, 'it_template_posts_per_page', true);
$addprojurl = $it_data['user_add_projects'];

//get post status
$post_status_shown = 'publish';
$post_status_shown = get_post_meta($post->ID, 'it_post_status_shown', true);

//only showing complete?
$completedcourses1 = 'NOT EXISTS';
$completedcourses2 = 'NOT LIKE';
$completedcourses = get_post_meta($post->ID, 'it_show_project_complete', true);
if ($completedcourses == 'yes') { 
$completedcourses1 = 'EXISTS'; 
$completedcourses2 = 'LIKE'; 
} else { 
$completedcourses1 = 'NOT EXISTS'; 
$completedcourses2 = 'NOT LIKE'; 
}

//set parent taxonomy
$projects_cpt_parent = get_post_meta($post->ID, 'it_projects_cpt_parent', true);
$projects_cpt_filter_parent = '';
($projects_cpt_parent != 'select_projects_cpt_cats_parent') ? $projects_cpt_filter_parent = $projects_cpt_parent : $projects_cpt_filter_parent = NULL;
?>

<article id="post" class="single-portfolio clearfix">

    <?php
	//show page content if not empty
    $content = $post->post_content;
    if(!empty($content)) { ?>
        <div id="portfolio-description" class="clearfix">
            <?php the_content(); ?>
        </div><!-- project-description -->
    <?php } ?>


<?php 
//get project categories
$cats_args = array(
	'hide_empty' => '1',
	'child_of' => $projects_cpt_filter_parent
);
$cats = get_terms('projects_cpt_cats', $cats_args);

//show filter if categories exist
if($cats) { ?>
<!-- Project Filter -->
<ul id="portfolio-cats" class="filter clearfix">
	<li><a href="#all" rel="all" class="active"><span><?php _e('Todos', 'it'); ?></span></a></li>
	<?php
	foreach ($cats as $cat ) : ?>
	<li><a href="#<?php echo $cat->slug; ?>" rel="<?php echo $cat->slug; ?>"><span><?php echo $cat->name; ?></span></a></li>
	<?php endforeach; ?>
</ul><!-- /project-cats -->
<?php } ?>

    <div id="portfolio-filter-template" class="clearfix">
        <div id="portfolio-wrap" class="clearfix">
            <ul class="portfolio-content">
                <?php
                //tax query
                if($projects_cpt_filter_parent) {
                $tax_query = array(
                    array(
                          'taxonomy' => 'projects_cpt_cats',
                          'field' => 'id',
                          'terms' => $projects_cpt_filter_parent
                          )
                    );
                } else { $tax_query = NULL; }
                
                //get post type ==> projects_cpt
                $args = array(
                    'post_type'=>'projects_cpt',
                    'posts_per_page' => $template_posts_per_page,
                    'post_status'=>$post_status_shown,
             //       'paged'=>$paged,
					'meta_key'=>'it_projects_deadline',  
					'orderby' => 'meta_value', 
					'order' => 'ASC',
                    'tax_query' => $tax_query,
					    'meta_query' => array(
					    'relation' => 'OR',
					        array(
					            'key' => 'it_show_project_complete',
					            'value' => 'yes',
					            'compare' => $completedcourses1
					        ),
					        array(
					            'key' => 'it_show_project_complete',
					            'value' => 'yes',
					            'compare' => $completedcourses2					        
					        )
                        )
                );
                
                $query = new WP_Query( $args );
                
                //start loop
                while ($query->have_posts()) : $query->the_post();
    
                    //get the projects loop style
                    get_template_part('includes/loop','projects-list-grid');
                    
                endwhile; wp_reset_query(); ?>
            </ul><!-- /projects-content -->
        </div><!-- /projects-wrap -->
    </div><!-- /projects-filter-template -->
</article><!-- /post -->

<?php
//end page loop
endwhile; endif;


//get tmeplate footer
get_footer(); ?>
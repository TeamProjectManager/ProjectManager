<?php
/**
 * Press Themes
 */
 
//get theme options
global $it_data;

//get template header
get_header();
require_once ( 'includes/body-top.php' );

//start tax loop only if taxonomies exist
if (have_posts()) :

//grid style
$projects_cpt_grid_style = $it_data['projects_cpt_tax_layout']; //get grid style meta
$projects_cpt_grid_class = it_grid($projects_cpt_grid_style); //set grid style

//grid image height
$projects_cpt_grid_image_height = $it_data['projects_cpt_tax_img_height'];
($projects_cpt_grid_image_height) ? $projects_cpt_grid_image_height = 450 * str_replace('%', '', $projects_cpt_grid_image_height) / 100 : $projects_cpt_grid_image_height = 450;
?>

<header id="page-heading">
	<h1>
	<?php
		$term =	$wp_query->queried_object;
		echo $term->name;
	?>
	</h1>
</header><!-- /page-heading -->

<?php
//show category description if not empty
if(category_description()) { ?>
<div id="portfolio-description">
	 <?php echo category_description( ); ?>
</div><!-- /projects-description -->
<?php } ?>

<?php
//show post div is sidebar enabled
if($it_data['show_hide_projects_cpt_tax_sidebar'] == 'enable') { echo '<div id="post">'; } ?>
    
<div id="portfolio-template" class="clearfix">
    <div id="portfolio-wrap" class="grid-container clearfix">
    
        <?php
		//start projects entry loop
        while (have_posts()) : the_post();
			//get the projects loop style
			get_template_part('includes/loop','projects_cpt');
        endwhile; ?>
        
        <div class="clear"></div>
		<?php
        //page pagination
        pagination();
        
        //reset tax query
        wp_reset_query(); ?>
          
    </div><!-- /projects-wrap -->
</div><!-- /projects-template --->

<?php
//close post div is sidebar enabled
if($it_data['show_hide_projects_cpt_tax_sidebar'] == 'enable') { echo '</div><!-- /post -->'; } ?>

<?php
//end page loop
endif;

//get projects sidebar, if sidebar enabled
if($it_data['show_hide_projects_cpt_tax_sidebar'] == 'enable') get_sidebar('projects');

//get template footer
get_footer(); ?>
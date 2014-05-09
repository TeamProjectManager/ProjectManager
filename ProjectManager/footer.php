<?php
/**
 * Project Manager
 */

//global variables
global $it_data, $post;

?>
<div class="clear"></div>

</div><!-- /content-main -->

<div class="clear"></div>

    <!-- /footer -->
    <div id="footer-bottom">
    	<div class="grid-container clearfix">
            <div id="copyright">
                <?php if(!empty($it_data['custom_copyright'])) { echo $it_data['custom_copyright']; } else { ?>
                &copy; <?php _e('Copyright', 'it'); ?> <?php echo date('Y'); ?> <a href="<?php echo home_url(); ?>/" title="<?php bloginfo('name'); ?>" rel="home"><?php bloginfo('name'); ?></a>
                <?php } ?>
                &middot; Todos os Direitos Reservados
            </div><!-- /copyright -->
            <div id="footer-menu">
                <?php wp_nav_menu( array(
                    'theme_location' => 'footer_menu',
                    'sort_column' => 'menu_order',
                    'fallback_cb' => ''
                )); ?>
            </div><!-- /footer-menu -->
    	</div><!-- /grid-container -->
    </div><!-- /footer-bottom --> 
</div><!-- /wrap -->
    
<?php 
//show tracking code - footer 
echo stripslashes($it_data['analytics_footer']); 
?>
<?php wp_footer(); ?>
</body>
</html>
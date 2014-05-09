<?php
/**
 * Custom CSS For wp_head Hook = it_custom_css()
*/

if (! is_admin()) {
	
	//initalize
	add_action('wp_head', 'it_custom_css');
	
	function it_custom_css() {
	
		//get globals
		global $it_data, $post;
		$custom_css ='';
		
		//get custom css
		if($it_data['custom_css']) {
			$custom_css .= $it_data['custom_css'];
		}
	
			/* body backgrounds */
			$custom_background_options = array('main');
			$custom_background_classes = 'body';
	
				//loop through each background option
				$custom_background_option = 'main';
									
					//background option
					if((isset($it_data[''.$custom_background_option.'_background'])) || (isset($it_data[''.$custom_background_option.'_background_custom']))) {
						
					//if pattern is not set to none or if custom background option isnt empty
					if($it_data[''.$custom_background_option.'_background'] !=''.get_template_directory_uri().'/images/background/none.png' || $it_data[''.$custom_background_option.'_background_image'] !='') {
						
						//set default background
						$custom_background_image = ($it_data[''.$custom_background_option.'_background_image']) ? $it_data[''.$custom_background_option.'_background_image'] : $it_data[''.$custom_background_option.'_background'];
						
						//full style background
						if($it_data[''.$custom_background_option.'_background_style'] == 'full') {
							$custom_css .= $custom_background_classes.'{background: url('.$custom_background_image.') no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size: cover;background-size: cover}';
						
						} else {
							
							//regular background
							$custom_css .= $custom_background_classes.'{background-image: url('.$custom_background_image.'); background-repeat: '.$it_data[''.$custom_background_option.'_background_style'].'; -webkit-background-size: auto;-moz-background-size: auto;-o-background-size: auto;background-size: auto;}';
						}
					} else {
						//no background
						$custom_css .= $custom_background_classes.'{background-image: none}';
						}
					}
					
		/* container background colors */
		
		
		//array of areas that have background color options
		$custom_background_containers = array();
		
		//loop through containers and apply background from admin option
		foreach($custom_background_containers as $custom_background_container) {
			
			//retrieve background option for containers (in the admin set the option with an id such as header_background)
			$custom_background = $it_data[''.$custom_background_container.'_background'];
			
			//output css
			if($custom_background){
				$custom_css .= '.'. $custom_background_container .'{background-color: '.$custom_background.'}';
			}
		
		}
		
		/* hovers */
		
		//containers with hovers
		$custom_overlay_containers = array('blog');
		
		
		//loop through containers and apply background from admin option
		foreach($custom_overlay_containers as $custom_overlay_container) {
			
			//retrieve background option for containers (in the admin set the option with an id such as header_background)
			$custom_overlay_color = $it_data[''.$custom_overlay_container.'_overlay_color'];
			$custom_overlay_opacity = $it_data[''.$custom_overlay_container.'_overlay_opacity'];
			
			//output color css
			if($custom_overlay_color){
				$custom_css .= 'body .'. $custom_overlay_container .'-entry-img-link:hover{background: '.$custom_overlay_color.'}';
			}
			
			//output opacity css
			if($custom_overlay_opacity){
				$custom_css .= 'body .'. $custom_overlay_container .'-entry-img:hover{opacity: '.$custom_overlay_opacity.'; -webkit-opacity: '.$custom_overlay_opacity.'; -moz-opacity: '.$custom_overlay_opacity.'}';
			}
			
		
		}
		
		
		/** echo all css **/
		$css_output = "<!-- Custom CSS -->\n<style type=\"text/css\">\n" . $custom_css . "\n</style>";
		
		if(!empty($custom_css)) {
			echo $css_output;
		}
		
	} //end it_custom_css()

} //is admin
?>
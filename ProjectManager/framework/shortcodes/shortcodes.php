<?php

if(defined('WP_ADMIN') && WP_ADMIN ) {
	require_once('forms.php');
}

/*--------------------------------------*/
/* Clean Up WordPress Shortcode Formatting
/* Important for nested shortcodes
/* Credit: http://donalmacarthur.com/articles/cleaning-up-wordpress-shortcode-formatting
/*--------------------------------------*/
function parse_shortcode_content( $content ) {

   /* Parse nested shortcodes and add formatting. */
	$content = trim( do_shortcode( shortcode_unautop( $content ) ) );

	/* Remove '' from the start of the string. */
	if ( substr( $content, 0, 4 ) == '' )
		$content = substr( $content, 4 );

	/* Remove '' from the end of the string. */
	if ( substr( $content, -3, 3 ) == '' )
		$content = substr( $content, 0, -3 );

	/* Remove any instances of ''. */
	$content = str_replace( array( '<p></p>' ), '', $content );
	$content = str_replace( array( '<p>  </p>' ), '', $content );

	return $content;
}


/*--------------------------------------*/
/*	Heading
/*--------------------------------------*/
function heading_shortcode( $atts, $content = null  ) {

	extract( shortcode_atts(
		array(
			'title' => __('Heading Title', 'it'),
			'margin_top' => '20px',
			'margin_bottom' => '20px'
      	), $atts ));
	
	$heading_content = '';
	$heading_content .= '<h2 class="heading" style="margin-top:'.$margin_top.';margin-bottom:'.$margin_bottom.';"><span>'. $title .'</span></h2>';
		
	return $heading_content;
}

add_shortcode( 'heading', 'heading_shortcode' );

/*--------------------------------------*/
/*	Colored Buttons
/*--------------------------------------*/
function button_shortcode( $atts, $content = null ){
	extract( shortcode_atts( array(
		  'color' => 'default',
		  'url' => '',
		  'target' => 'self',
		  'size' => 'small',
		  'align' => ''
      ), $atts ) );
	  if($url) {
		return '<a href="' . $url . '" class="button ' . $color . ' '. $size . ' ' . $align .'" target="_'.$target.'"><span class="button-inner">' . do_shortcode($content) . '</span></a>';
	  } else {
		return '<div class="button ' . $color . ' '. $size . ' ' . $align .'"><span class="button-inner">' . do_shortcode($content) . '</span></div>';
	}
}
add_shortcode('button', 'button_shortcode');

/*--------------------------------------*/
/*	Lists
/*--------------------------------------*/
function list_shortcode( $atts, $content = null ){
	extract(
	shortcode_atts( array(
      'type' => ''
      ),
	  $atts ) );
		return '<div class="' . $type . '">' . $content . '</div>';
}
add_shortcode('list', 'list_shortcode');

/*--------------------------------------*/
/*	Clear
/*--------------------------------------*/
function clear_shortcode() {
   return '<div class="clear"></div>';
}

add_shortcode( 'clear', 'clear_shortcode' );

/*--------------------------------------*/
/*	BR
/*--------------------------------------*/
function br_shortcode( ) {
   return '<br />';
}
add_shortcode( 'br', 'br_shortcode' );



/*--------------------------------------*/
/*	HR
/*--------------------------------------*/
function hr_shortcode( $atts, $content = null ){
	extract(shortcode_atts(array(
		'style' => '',
		'margin_top' => '',
		'margin_bottom' => ''
	), $atts ));
	
   return '<div class="clear"></div><hr class="'.$style.'" style="margin-top: '.$margin_top.'; margin-bottom:'.$margin_bottom.';" />';
   
}
add_shortcode( 'hr', 'hr_shortcode' );

/*--------------------------------------*/
/*	Togggle
/*--------------------------------------*/
function toggle_shortcode( $atts, $content = null ){
    extract( shortcode_atts(
    array(
      	'title' => 'Click To Open',
      	'color' => '',
	  	'open' => ''
      ),
      $atts ) );
	  
	  	($open == 'true') ? $open = 'active' : '';
        return '<div class="it-toggle-wrap"><h3 class="trigger '.$open.'"><a href="#" class="trigger-link"><span class="it-icon-plus-sign"></span>'. $title .'</a></h3><div class="toggle_container">' . do_shortcode($content) . '</div></div>';
}
add_shortcode('toggle', 'toggle_shortcode');

/*--------------------------------------*/
/*	Accordion
/*--------------------------------------*/
function accordion_shortcode( $atts, $content = null  ) {
   return '<div class="it-accordion">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'accordion', 'accordion_shortcode' );

function accordion_section_shortcode( $atts, $content = null  ) {

    extract( shortcode_atts( array(
      'title' => 'Title',
    ), $atts ) );

   return '<h3 class="trigger">'. $title .'</h3><div>' . do_shortcode($content) . '</div>';
}

add_shortcode( 'accordion_section', 'accordion_section_shortcode' );

/*--------------------------------------*/
/*	Tabs Shortcodes
/*--------------------------------------*/
if (!function_exists('tabgroup')) {
	function tabgroup( $atts, $content = null ) {
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
		
		// Extract the tab titles for use in the tab shortcode
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		
		$tab_titles = array();
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
		
		$output = '';
		
		if( count($tab_titles) ){
		    $output .= '<div id="tab-shortcode-'. rand(1, 100) .'" class="tab-shortcode">';
			$output .= '<ul class="ui-tabs-nav clearfix">';
			
			foreach( $tab_titles as $tab ){
				$output .= '<li><a href="#tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
			}
		    
		    $output .= '</ul>';
		    $output .= do_shortcode( $content );
		    $output .= '</div>';
		} else {
			$output .= do_shortcode( $content );
		}
		
		return $output;
	}
	add_shortcode( 'tabgroup', 'tabgroup' );
}

if (!function_exists('tab')) {
	function tab( $atts, $content = null ) {
		$defaults = array( 'title' => 'Tab' );
		extract( shortcode_atts( $defaults, $atts ) );
		
		return '<div id="tab-'. sanitize_title( $title ) .'" class="tab-content">'. do_shortcode( $content ) .'</div>';
	}
	add_shortcode( 'tab', 'tab' );
}

/*--------------------------------------*/
/*	Alerts
/*--------------------------------------*/
function alert_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'color' => '',
		'title' => ''
      ), $atts ) );
	  
	  $alert_content = '';
	  $alert_content .= '<div class="alert-' . $color . '">';
	  	if($title) {
			$alert_content .='<h2 class="alert-title">'.$title.'</h2>';
		}
	  $alert_content .= ' '.do_shortcode($content) .'</div>';

      return $alert_content;

}
add_shortcode('alert', 'alert_shortcode');

/*--------------------------------------*/
/*	Columns
/*--------------------------------------*/
function column_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
	  	'offset' =>'',
      	'size' => '',
	  	'position' =>''
      ), $atts ) );


	  if($offset !='') { $column_offset = $offset; } else { $column_offset ='one'; }
		
      return '<div class="'.$column_offset.'-' . $size . ' column-'.$position.'">' . do_shortcode($content) . '</div>';

}
add_shortcode('column', 'column_shortcode');

?>
<?php
/**
 * Setup grid classes based on meta options
*/
function it_grid($grid_style){
	if($grid_style == '3 Column'){
		return 'grid-3';
	}
	
	if($grid_style == '4 Column'){
		return 'grid-4';
	}
	
}
?>
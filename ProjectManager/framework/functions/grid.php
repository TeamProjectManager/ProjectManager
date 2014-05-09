<?php
/**
 * Setup grid classes based on meta options
*/
function it_grid($it_grid_style){	
	
	if($it_grid_style == '3 Column'){
		return 'grid-3';
	}
	
	if($it_grid_style == '4 Column'){
		return 'grid-4';
	}
	
	if($it_grid_style == 'List'){
		return 'list';
	}
	
	if($it_grid_style == 'Table'){
		return 'table';
	}		
}
?>
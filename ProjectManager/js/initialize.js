jQuery(function($){
	$(document).ready(function(){
		
		//scroll to top
		$('a[href=#top]').on('click', function(){
			$('html, body').animate({scrollTop:0}, 'normal');
			return false;
		});
		
		//animate comments scroll
		$(".comment-scroll a").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top}, 'normal');
		});
		
		// superFish
		$("ul.sf-menu").superfish({ 
			autoArrows: true,
			animation:  {opacity:'show', height:'show'}
		});
		
		// Toggle
		$(".it-toggle-wrap .toggle_container").hide();
		var $toggle_trigger = $('.it-toggle-wrap h3');
		
		$($toggle_trigger).click(function(){
			var $toggle_icon = $(this).find("span");
			$(this).toggleClass("active").next().slideToggle("fast");
			
			if($(this).hasClass('active')){
				$toggle_icon.removeClass("it-icon-plus-sign").addClass("it-icon-minus-sign");
			} else {
				$toggle_icon.removeClass("it-icon-minus-sign").addClass("it-icon-plus-sign");
			}
				
			return false; //Prevent the browser jump to the link anchor
		});
					
		// UI tabs
		$( ".tab-shortcode" ).tabs({fx:{opacity: "toggle", duration:'fast'}});
		
		// UI accordion
		$( ".it-accordion" ).accordion({autoHeight: false});
		$(".it-accordion").accordion("option", "icons",
        { 'header': 'it-icon-plus-sign', 'headerSelected': 'it-icon-minus-sign' });
		
	
	}); // END doc ready
}); // END function

jQuery(function($){
	$(window).load(function() {
		
	//equal heights for portfolio entries to avoid float issues
		$.fn.eqHeights = function() {
		var el = $(this);
		if (el.length > 0 && !el.data('eqHeights')) {
			$(window).bind('resize.eqHeights', function() {
				el.eqHeights();
			});
			el.data('eqHeights', true);
		}
			return el.each(function() {
				var curHighest = 0;
				$(this).children('.portfolio-post').each(function() {
					var el = $(this),
						elHeight = el.height('auto').height();
					if (elHeight > curHighest) {
						curHighest = elHeight;
					}
				}).height(curHighest);
			});
		};
		$('.portfolio-content').eqHeights();
		
	}); // END window ready
}); // END function
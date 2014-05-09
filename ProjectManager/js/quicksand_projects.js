jQuery(function($){
	$(document).ready(function() {
		
		//set height on container via css to fix some bugs
		var $portfolioHeight = $("#portfolio-wrap").innerHeight();
		$(".portfolio-content").height($portfolioHeight)
		
		//Options for the portfolio filter
		var $filterType = $('#portfolio-cats a.active').attr('rel');
		var $holder = $('ul.portfolio-content');
		var $it_data = $holder.clone();
		
		$('#portfolio-cats li a').click(function(e) {
		$('#portfolio-cats a').removeClass('active');
			var $filterType = $(this).attr('rel');
			$(this).addClass('active');
			
			if ($filterType == 'all') {
				var $filteredData = $it_data.find('li');
			}
			else {
				var $filteredData = $it_data.find('li[data-type~=' + $filterType + ']');
			}
			
			$holder.quicksand($filteredData, {
				duration: 400,
				adjustHeight:"dynamic",
				easing: 'easeInOutQuad'
	
				}, function() {
					
					// PrettyPhoto Without gallery		
					$(".prettyphoto-link").prettyPhoto({
						theme: lightboxLocalize.theme,
						show_title: lightboxLocalize.title,
						opacity: lightboxLocalize.opacity,
						allow_resize: lightboxLocalize.resize,
						default_width: lightboxLocalize.width,
						default_height: lightboxLocalize.height,
						animation_speed:'normal',
						keyboard_shortcuts: true,
						social_tools: false,
						slideshow: false,
						autoplay_slideshow: false,
						wmode: 'opaque',
					});
				
					//PrettyPhoto With Gallery
					$("a[rel^='prettyPhoto']").prettyPhoto({
						theme: lightboxLocalize.theme,
						show_title: lightboxLocalize.title,
						slideshow: lightboxLocalize.slideshow,
						opacity: lightboxLocalize.opacity,
						allow_resize: lightboxLocalize.resize,
						default_width: lightboxLocalize.width,
						default_height: lightboxLocalize.height,
						animation_speed: 'normal',
						keyboard_shortcuts: true,
						social_tools: false,
						autoplay_slideshow: false,
						overlay_gallery: true,
						wmode: 'opaque',
						
					});

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
		
					
		  	}); //end callback functions
		  
		  return false;
		});
	});
});
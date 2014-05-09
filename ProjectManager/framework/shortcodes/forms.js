(function() {
	tinymce.create('tinymce.plugins.it_shortcodesPlugin', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mceit_shortcodes', function() {
				ed.windowManager.open({
					file : url + '/shortcodes_iframe.php', // file that contains HTML for our modal window
					width : 600 + parseInt(ed.getLang('it_shortcodes.delta_width', 0)), // size of our window
					height : 700 + parseInt(ed.getLang('it_shortcodes.delta_height', 0)), // size of our window
					inline : 1
				}, {
					plugin_url : url
				});
			});
			 
			// Register it_shortcodess
			ed.addButton('it_shortcodes', {title : 'Insert Shortcode', cmd : 'mceit_shortcodes', image: url + '/css/images/shortcodes.png' });
		},
		 
		getInfo : function() {
			return {
				longname : 'Insert Shortcode',
				author : 'Icarus Creative',
				authorurl : 'http://themeforest.net/user/icaruscreativeorg/',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});
	 
	// Register plugin
	tinymce.PluginManager.add('it_shortcodes', tinymce.plugins.it_shortcodesPlugin);

})();
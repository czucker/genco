(function() {
	tinymce.create('tinymce.plugins.hbthemes_shortcodesPlugin', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mcehbthemes_shortcodes', function() {
				ed.windowManager.open({
					file : url + '/hbthemes-shortcodes-iframe.php', // file that contains HTML for our modal window
					width : 650 + parseInt(ed.getLang('hbthemes_shortcodes.delta_width', 0)), // size of our window
					height : 700 + parseInt(ed.getLang('hbthemes_shortcodes.delta_height', 0)), // size of our window
					inline : 1
				}, {
					plugin_url : url
				});
			});
			 
			// Register hbthemes_shortcodess
			ed.addButton('hbthemes_shortcodes', {title : 'Highend Shortcode Generator', cmd : 'mcehbthemes_shortcodes', image: url + '/images/shortcodes.png' });
		},
		 
		getInfo : function() {
			return {
				longname : 'Highend Shortcode Generator',
				author : 'HB-Themes',
				authorurl : 'http://hb-themes.com',
				infourl : 'http://hb-themes.com',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});
	 
	// Register plugin
	// first parameter is the hbthemes_shortcodes ID and must match ID elsewhere
	// second parameter must match the first parameter of the tinymce.create() function above
	tinymce.PluginManager.add('hbthemes_shortcodes', tinymce.plugins.hbthemes_shortcodesPlugin);

})();
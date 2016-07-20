/* Map tinymce scripts */
(function() {
	"use strict";
	tinymce.PluginManager.add( 'swpcaroushortcodes', function( editor, url ) {
		editor.addButton( 'swpcaroushortcodes', {
			type	: 'menubutton',
			text	: '',
			icon	: 'spost-grid',
			tooltip	: 'Carousel',
			onselect: function(e) {
			},
			menu: swp_carou_shortcodes
		});
	});
})();

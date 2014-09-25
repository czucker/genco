(function() {
    tinymce.PluginManager.add('ihover_tc_button', function( editor, url ) {
        editor.addButton( 'ihover_tc_button', {
            text: 'Hover Shortcode',
            icon: false,
            onclick: function() {
                editor.insertContent('[hover category="Category_Name"]');
            }
        });
    });
})();
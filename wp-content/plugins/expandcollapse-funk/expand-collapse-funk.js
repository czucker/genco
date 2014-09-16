( function() {
    tinymce.PluginManager.add( 'expandCollapseFunk', function( ed, url ) {

        // Add a button that opens a window
        ed.addButton( 'expandCollapseFunk', {
            title : 'Expand/Collapse Functionality',
             image : url + '/toggle_expand.png',
            onclick: function() {
                tb_show("", "../wp-content/plugins/expandcollapse-funk/expand-collapse-funk-modal.php?");
				tinymce.DOM.setStyle(["TB_overlay", "TB_window", "TB_load"], "z-index", "999999");
            }

        } );

    } );

} )();

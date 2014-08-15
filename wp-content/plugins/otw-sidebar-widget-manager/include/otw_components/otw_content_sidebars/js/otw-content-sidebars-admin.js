jQuery(document).ready(function(){
	
	jQuery( '.otw-cs-layout-type li img' ).click( function(){
	
		jQuery( this ).parents( 'ul' ).find( 'img' ).removeAttr( 'class' );
		var matches = false;
		if( matches = jQuery( this ).attr( 'id' ).match( /^(.*)\_([1|2|3][a-z]+)$/ ) )
		{
			jQuery( this ).addClass( 'otw-selected' );
			jQuery( '#otw_cs_layout_' + matches[1] ).val( matches[2] );
		};
	} );
	
	jQuery( '#otw_cs_use_configuration' ).change( function(){
		
		if( this.value == 'default' ){
			jQuery( '#otw_cs_sidebar_configiration' ).hide();
		}else{
			jQuery( '#otw_cs_sidebar_configiration' ).fadeIn();
		};
	} );
});
var dialog_container = '';
jQuery(document).ready(function() {
	
	jQuery('a.widget-action').live('click', function(){
		otw_init_widgets();
	} );
	
	jQuery(this).ajaxComplete(function(event, XMLHttpRequest, ajaxOptions){
		
		if( ajaxOptions.data && ajaxOptions.data.search('action=save-widget')  ){
			otw_init_widgets();
		}
	})
	otw_init_widgets();
});
function otw_init_widgets(){
	
	/*set up appearence links*/
	var widget_blocks = jQuery( 'div.widgets-sortables' );
	widget_blocks.each( function(){
		
		var widget_block = jQuery( this );
		
		if( widget_block.attr('id').length ){
			
			var widget_containers = widget_block.find( 'div.widget' );
			
			var sidebar_id = widget_block.attr( 'id' );
			
			if( widget_containers.length && sidebar_id != 'wp_inactive_widgets' ){
				
				widget_containers.each( function(){
					var widget_id_container = jQuery( this ).find( 'input.widget-id' );
					
					if( widget_id_container.length ){
						widget_id = widget_id_container.val();
						
						var action_blocks = jQuery( this ).find( 'div.widget-content' );
						
						
						action_blocks.each( function(){
							var object = jQuery( this );
							
							var appearence_links = object.find( 'input.otw_appearence' );
							
							if( !appearence_links.length )
							{
								new_action = jQuery( '<input type="button" class="button otw_appearence" name="Set Visibility" value="Set Visibility">' );
								new_action[0].widget_id = widget_id;
								new_action[0].sidebar_id = sidebar_id;
								new_action.click( function(){
									
									
									var req_url = 'admin-ajax.php?action=otw_widget_dialog&sidebar=' + this.sidebar_id + '&widget=' + this.widget_id;
									
									jQuery.post( req_url, { 'widget_id': this.widget_id, 'sidebar_id': this.sidebar_id}, function(b){
										
										jQuery( "#otw-dialog").remove();
										var cont = jQuery( '<div id="otw-dialog">' + b + '</div>' );
										jQuery( "body").append( cont );
										jQuery( "#otw-dialog").hide();
										
										tb_position = function(){
											
											var isIE6 = typeof document.body.style.maxHeight === "undefined";
											var b=jQuery(window).height();
											jQuery("#TB_window").css({marginLeft: '-' + parseInt((TB_WIDTH / 2),10) + 'px', width: TB_WIDTH + 'px'});
											if ( ! isIE6 ) { // take away IE6
												jQuery("#TB_window").css({marginTop: '-' + parseInt((TB_HEIGHT / 2),10) + 'px'});
											}
											if( !cont[0].saved_h ){
												cont[0].saved_h = jQuery( '#TB_window' ).css( 'height' );
												cont[0].saved_t = jQuery( '#TB_window' ).css( 'top' );
												cont[0].saved_mt = jQuery( '#TB_window' ).css( 'margin-top' );
												cont[0].saved_w = jQuery( '#TB_ajaxContent' ).css( 'width' );
											}else{
												jQuery( '#TB_window' ).css( 'height', cont[0].saved_h );
												jQuery( '#TB_window' ).css( 'top', cont[0].saved_t );
												jQuery( '#TB_window' ).css( 'margin-top', cont[0].saved_mt );
												jQuery( '#TB_ajaxContent' ).css( 'width', cont[0].saved_w );
											}
											
										}
										jQuery( window ).resize( function(){
											tb_position();
										} );
										
										var f=jQuery(window).width();
										b=jQuery(window).height();
										f=850<f?850:f;
										f-=80;
										/*b-=84;*/
										b=760<b?760:b;
										b-=110; 
										
										tb_show( 'Some Title', "#TB_inline?width="+f+"&height="+b+"&inlineId=otw-dialog" );
									} );
								} );
								object.append( new_action );
							};
						});
					};
				});
			};
		};
	} );

};
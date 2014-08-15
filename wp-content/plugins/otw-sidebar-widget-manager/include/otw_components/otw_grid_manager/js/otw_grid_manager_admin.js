function otw_grid_manager_object( object_name, labels, templates ){
	
	this.object_name = object_name;
	
	this.container = jQuery( '#' + object_name + '_container' );
	
	this.code_container = jQuery( '#' + object_name + '_code' );
	
	this.preview_container = jQuery( '#' + object_name + '_preview' );
	
	this.add_columns_title = 'Add Column';
	
	this.add_column_action = 'otw_grid_manager_column_dialog';
	
	this.rows = new Array();
	
	this.grid_size = 24;
	
	this.number_names = new Array( 'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen', 'twenty', 'twentyone', 'twentytwo', 'twentythree', 'twentyfour');
	
	this.labels = labels;
	
	this.selected_column = new Array();
	
	this.edit_column = -1;
	
	this.edit_row_column = -1;
	
	this.add_row_dropdown_menu = '';
	
	this.add_column_dropdown_menu = '';
	
	this.copy_popup = '';
	
	this.templates_dropdown_menu = '';
	
	this.templates = templates;
	
	this.row_column_nodes = null;
	
	this.row_error_message = false;
	
	this.column_sizes = new Array();
	this.column_sizes[ this.column_sizes.length ] = new Array( 1, 6 );
	this.column_sizes[ this.column_sizes.length ] = new Array( 1, 4 );
	this.column_sizes[ this.column_sizes.length ] = new Array( 1, 3 );
	this.column_sizes[ this.column_sizes.length ] = new Array( 1, 2 );
	this.column_sizes[ this.column_sizes.length ] = new Array( 2, 3 );
	this.column_sizes[ this.column_sizes.length ] = new Array( 3, 4 );
	this.column_sizes[ this.column_sizes.length ] = new Array( 5, 6 );
	this.column_sizes[ this.column_sizes.length ] = new Array( 1, 1 );
	
	this.init();
};
otw_grid_manager_object.prototype.init = function(){

	with( this ){
		
		jQuery( '#' + this.object_name + '_info_button' ).click( function( event ){
			
			close_dropdowns();
			jQuery( '#' + object_name + '_info_block' ).fadeToggle();
			event.preventDefault();
			event.stopPropagation();
		} );
		
		jQuery( '#' + this.object_name + '_add_row' ).click( function( event ){
			
			show_add_row_menu( this );
			event.preventDefault();
			event.stopPropagation();
		} );
		
		jQuery( '#' + this.object_name + '_templates' ).click( function( event ){
			
			show_templates_menu( this );
			event.preventDefault();
			event.stopPropagation();
		} );
		
		load_from_json( code_container.val() );
	}
};

otw_grid_manager_object.prototype.load_from_json = function( json_code ){
	
	var row_id = 0;
	if( json_code.length ){
		
		var json_object = jQuery.parseJSON( json_code );
		
		for( var json_row in json_object ){
		
			row_id = this.add_row();
			
			var column_id = 0;
			
			if( typeof( json_object[ json_row ].columns ) == 'object' ){
				
				for( cC = 0; cC < json_object[ json_row ].columns.length; cC++ ){
					column_id = this.add_column( row_id, json_object[ json_row ].columns[ cC ].rows, json_object[ json_row ].columns[ cC ].from_rows, json_object[ json_row ].columns[ cC ].mobile_rows, json_object[ json_row ].columns[ cC ].mobile_from_rows );
					
					for( cS = 0; cS < json_object[ json_row ].columns[ cC ].shortcodes.length; cS++){
						this.rows[ row_id ].columns[ column_id ].add_shortcode( json_object[ json_row ].columns[ cC ].shortcodes[ cS ] );
					};
				};
			};
		};
	};
	this.preview();
};

otw_grid_manager_object.prototype.get_label = function( label ){

	if( this.labels[ label ] ){
		return this.labels[ label ];
	};
	
	return label;
};

otw_grid_manager_object.prototype.build_templates_menu_links = function(){

	this.templates_dropdown_menu.html( '' );
	
	var links = '<ul>';
	links = links + '<li><span>' + this.get_label( 'Save' ) + '</save></li>';
	links = links + '<li><a class="otw-grid-manager-templates-dropdown-action-save">' + this.get_label( 'Save current page as Template' ) + '</a></li>';
	links = links + '<li><div></div></li>';
	if( this.templates.length ){
		links = links + '<li><span>' + this.get_label( 'Quick Load Template' ) + '</save></li>';
		
		for( var cT = 0; cT < this.templates.length; cT++ ){
			links = links + '<li><a class="otw-grid-manager-templates-dropdown-action-load a_load" data-key="' + this.templates[cT][0] + '">' + this.templates[cT][1] + '</a><a class="otw-grid-manager-templates-dropdown-action-delete a_delete" data-key="' + this.templates[cT][0] + '"></a></li>';
		}
		
		links = links + '<li><div></div></li>';
	}
	links = links + '<li><a class="otw-grid-manager-templates-dropdown-action-close">' + this.get_label( 'Close' ) + '</a></li>';
	links = links + '</ul>';
	
	this.templates_dropdown_menu.html( links );
	
	this.init_template_dropdown_actions();
};

otw_grid_manager_object.prototype.close_dropdowns = function(){

	if( this.templates_dropdown_menu ){
		this.templates_dropdown_menu.hide();
	};
	
	if( typeof( otw_shortcode_component ) != 'undefined' ){
		if( otw_shortcode_component.dropdown_menu ){
			otw_shortcode_component.dropdown_menu.hide();
		};
	};
	
	if( this.add_row_dropdown_menu ){
		this.add_row_dropdown_menu.hide();
	};
	
	if( this.add_column_dropdown_menu ){
		this.add_column_dropdown_menu.hide();
	};
	
	if( this.copy_popup ){
		this.copy_popup.hide();
	}
};

otw_grid_manager_object.prototype.show_copy_popup = function( event, append_to, code ){

	if( !this.copy_popup ){
		this.copy_popup = jQuery( '<div id=' + this.object_name  + '_copy_popup" class=\"otw_copy_popup\" ></div>' );
		
	}
	if( this.copy_popup.css( 'display' ) == 'block' ){
		this.close_dropdowns();
		return;
	}
	
	this.close_dropdowns();
	
	var html = '<textarea reqdonly="readonly" id="otw-grid-manager-copy-popup-code" ></textarea>';
	html = html + '<div></div>'
	html = html + '<div class="dropdown_line">&nbsp;</div>';
	html = html + '<div class="otw_dropdown_button"><a class="otw-grid-manager-copy-popup-close">' + this.get_label( 'Close' ) + '</a></div>';
	html = html + '</div>';
	
	this.copy_popup.html( html );
	
	var link = jQuery( append_to );
	
	//this.copy_popup.insertAfter( link );
	jQuery( 'body' ).append( this.copy_popup );
	
	var code_container = jQuery( '#otw-grid-manager-copy-popup-code' )[0];
	var text = document.createTextNode( code );
	code_container.appendChild(text);
	
	var dropdown_bottom_postion =  jQuery( '#' + this.object_name ).position().top + link.position().top + link.height() + 50 + this.copy_popup.height();
	
	if( ( dropdown_bottom_postion + 10 ) > jQuery(document).height() ){
		
		this.copy_popup.css("top", link.position().top - this.copy_popup.height() );
		
	}else{
		this.copy_popup.css("top", link.position().top + link.height() + 2 );
	}
	
	//this.copy_popup.css("left", link.position().left + 1 );
	
	this.copy_popup.css("left", event.pageX  );
	this.copy_popup.css("top", event.pageY  );
	
	this.copy_popup.slideDown(100);
	this.copy_popup.show();
	
	this.copy_popup.find( 'textarea' ).select();
	
	with( this ){
		this.copy_popup.find( '.otw-grid-manager-copy-popup-close' ).click( function(){
			close_dropdowns();
		} );
	}

}

otw_grid_manager_object.prototype.show_add_row_menu = function( append_to ){
	
	
	this.add_row_dropdown_menu = jQuery( '#' + this.object_name  + '_add_row_dropdown_menu' );
	
	if( this.add_row_dropdown_menu.css( 'display' ) == 'block' ){
		this.close_dropdowns();
		return;
	}
	this.close_dropdowns();
	
	this.add_row_dropdown_menu.html( '' );
	
	if( !this.add_row_dropdown_menu.size() ){
		this.add_row_dropdown_menu = jQuery( '<div id=\"' + this.object_name  + '_add_row_dropdown_menu\" class=\"otw_add_row_dropdown_menu\"></div>' );
	};
	
	var column_types = new Array();
	column_types[0]  = [ [1,1] ];
	column_types[1]  = [ [1,2], [1,2] ];
	column_types[2]  = [ [1,3], [2,3] ];
	column_types[3]  = [ [2,3], [1,3] ];
	column_types[4]  = [ [1,3], [1,3], [1,3] ];
	column_types[5]  = [ [1,4], [1,4], [1,4], [1,4] ];
	column_types[6]  = [ [1,4], [1,2], [1,4] ];
	column_types[7]  = [ [1,4], [1,4], [1,2] ];
	column_types[8]  = [ [1,2], [1,4], [1,4] ];
	column_types[9]  = [ [3,4], [1,4] ];
	column_types[10]  = [ [1,4], [3,4] ];
	column_types[11]  = [ [1,6], [1,6], [1,6], [1,6], [1,6], [1,6] ];
	column_types[12]  = [ [1,6], [1,3], [1,2] ];
	column_types[13]  = [ [1,6], [5,6] ];
	
	var links = '<div class="otw_dropdown_menu_container">';
	
	links = links + '<div class=\"otw-row\"><div class="otw-twentyfour otw-columns"><a class="otw-grid-manager-add_row-dropdown-action-add">' + this.get_label( 'Empty Row' ) + '</a></div></div>';
	
	for( var cT = 0; cT < column_types.length; cT++ ){
		links = links + '<div class=\"otw-row otw-add-row-selector\">';
		
		for( var cTR = 0; cTR < column_types[ cT ].length; cTR++ ){
			
			links = links + '<div class="otw-'+ this.get_column_class( column_types[ cT ][ cTR ][0], column_types[ cT ][ cTR ][1] ) +' otw-columns">';
			
			links = links + '<span data-column="' + this.get_label( column_types[ cT ][ cTR ][0] + '_' + column_types[ cT ][ cTR ][1] ) + '">' + this.get_label( column_types[ cT ][ cTR ][0] + '/' + column_types[ cT ][ cTR ][1] ) + '</span>';
			
			links = links + '</div>';
		};
		
		links = links + '</div>';
	};
	links = links + '<div class="dropdown_line">&nbsp;</div>';
	links = links + '<div class="otw_dropdown_button"><a class="otw-grid-manager-add_row-dropdown-action-close">' + this.get_label( 'Close' ) + '</a></div>';
	
	links = links + '</div>';
	
	this.add_row_dropdown_menu.html( links );
	
	this.init_add_row_dropdown_actions();
	
	with( this ){
		jQuery( document ).click( function(){
			if( add_row_dropdown_menu.css( 'display' ) == 'block' ){
				add_row_dropdown_menu.hide( );
			};
		});
	};
	
	var link = jQuery( append_to );
	
	this.add_row_dropdown_menu.insertAfter( link );
	
	var dropdown_bottom_postion =  jQuery( '#' + this.object_name ).position().top + link.position().top + link.height() + 50 + this.add_row_dropdown_menu.height();
	
	if( ( dropdown_bottom_postion + 10 ) > jQuery(document).height() ){
		
		this.add_row_dropdown_menu.css("top", link.position().top - this.add_row_dropdown_menu.height() );
		
	}else{
		this.add_row_dropdown_menu.css("top", link.position().top + link.height() + 2 );
	}
	
	this.add_row_dropdown_menu.css("left", link.position().left + 1 );
	
	this.add_row_dropdown_menu.slideDown(100);
	this.add_row_dropdown_menu.show();
};

otw_grid_manager_object.prototype.show_add_column_menu = function( append_to, row_id ){

	this.close_dropdowns();
	
	this.add_column_dropdown_menu = jQuery( '#' + this.object_name  + '_add_column_dropdown_menu' );
	
	this.add_column_dropdown_menu.html( '' );
	
	if( !this.add_column_dropdown_menu.size() ){
		this.add_column_dropdown_menu = jQuery( '<div id=\"' + this.object_name  + '_add_column_dropdown_menu\" class=\"otw_add_column_dropdown_menu\"></div>' );
	};
	
	var column_types = new Array();
	column_types[0]  = [ [1,1] ];
	column_types[1]  = [ [1,2], [1,2] ];
	column_types[2]  = [ [1,3], [2,3] ];
	column_types[3]  = [ [1,4], [3,4] ];
	column_types[4]  = [ [1,6], [5,6] ];
	
	var links = '<div class="otw_dropdown_menu_container otw_add_column_dropdown">';
	
	
	var has_any = false;
	var col_links = '';
	for( var cT = 0; cT < column_types.length; cT++ ){
		col_links = col_links + '<div class=\"otw-row otw-add-column-selector\">';
		
		has_any = true;
		for( var cTR = 0; cTR < column_types[ cT ].length; cTR++ ){
		
			col_links = col_links + '<div class="otw-'+ this.get_column_class( column_types[ cT ][ cTR ][0], column_types[ cT ][ cTR ][1] ) +' otw-columns">';
			
			if( this.valid_column_numbers( row_id, [ column_types[ cT ][cTR] ], [] ) ){
			
				col_links = col_links + '<span class=\"active\" data-column="' + this.get_label( column_types[ cT ][ cTR ][0] + '_' + column_types[ cT ][ cTR ][1] ) + '">' + this.get_label( column_types[ cT ][ cTR ][0] + '/' + column_types[ cT ][ cTR ][1] ) + '</span>';
			}else{
				col_links = col_links + '<span>&nbsp;</span>';
			}
			
			col_links = col_links + '</div>';
		};
		col_links = col_links + '</div>';
	};
	if(  has_any ){
		links = links + '<div class="otw_dropdown_link"><a class="otw-grid-manager-add_column-dropdown-action-add">' + this.get_label( 'Add Column' ) + '</a></div>';
		links = links + '<div class="otw_dropdown_line"></div>';
		links = links + col_links;
		links = links + '<div class="otw_dropdown_line"></div>';
	};
	links = links + '<div class="otw_dropdown_button"><a class="otw-grid-manager-add_column-dropdown-action-close">' + this.get_label( 'Close' ) + '</a></div>';
	links = links + '</div>';
	
	this.add_column_dropdown_menu.html( links );
	
	this.init_add_column_dropdown_actions();
	
	with( this ){
		jQuery( document ).click( function(){
			if( add_column_dropdown_menu.css( 'display' ) == 'block' ){
				add_column_dropdown_menu.hide( );
			};
		});
	};
	
	var link = jQuery( append_to );
	
	this.add_column_dropdown_menu.insertAfter( link );
	
	var link_height = link.outerHeight();
	var link_left   = parseInt( link.css( 'marginLeft' ) ) + link.position().left;
	
	var dropdown_bottom_postion =  jQuery( '#' + this.object_name ).position().top + link.position().top + link_height + 50 + this.add_column_dropdown_menu.height();
	
	if( dropdown_bottom_postion > jQuery(document).height() ){
		
		this.add_column_dropdown_menu.css("top", link.position().top - this.add_column_dropdown_menu.height() );
		
	}else{
		this.add_column_dropdown_menu.css("top", link.position().top + link_height );
	}
	
	var dd_width = 300;
	var dropdown_right_postion = link_left + 1 + dd_width + 20;
	
	if( ( dropdown_right_postion + 20 ) > jQuery(document).width() ){
		this.add_column_dropdown_menu.css("left", link_left - dd_width + 10 );
	}else{
		this.add_column_dropdown_menu.css("left", link_left + 1 );
	}
	this.add_column_dropdown_menu.attr( 'data-row-id', row_id );
	
	this.add_column_dropdown_menu.slideDown(100);
	this.add_column_dropdown_menu.show();
};

otw_grid_manager_object.prototype.show_templates_menu = function( append_to ){
	
	this.templates_dropdown_menu = jQuery( '#' + this.object_name  + '_templates_dropdown_menu' );
	
	if( this.templates_dropdown_menu.css( 'display' ) == 'block' ){
		this.close_dropdowns();
		return;
	}
	this.close_dropdowns();
	
	this.templates_dropdown_menu.html( '' );
	
	if( !this.templates_dropdown_menu.size() ){
		this.templates_dropdown_menu = jQuery( '<div id=\"' + this.object_name  + '_templates_dropdown_menu\" class=\"otw_templates_dropdown_menu\"></div>' );
	};
	
	this.build_templates_menu_links();
	
	with( this ){
		jQuery( document ).click( function(){
			if( templates_dropdown_menu.css( 'display' ) == 'block' ){
				templates_dropdown_menu.hide( );
			};
		});
	};
	
	var link = jQuery( append_to );
	
	this.templates_dropdown_menu.insertAfter( link );
	
	var dropdown_bottom_postion =  jQuery( '#' + this.object_name ).position().top + link.position().top + link.height() + 50 + this.templates_dropdown_menu.height();
	
	if( dropdown_bottom_postion > jQuery(document).height() ){
		
		this.templates_dropdown_menu.css("top", link.position().top - this.templates_dropdown_menu.height() );
		
	}else{
		this.templates_dropdown_menu.css("top", link.position().top + link.height() + 2 );
	}
	
	this.templates_dropdown_menu.css("left", link.position().left + 1 );
	
	this.templates_dropdown_menu.slideDown(100);
	this.templates_dropdown_menu.show();
};

otw_grid_manager_object.prototype.init_add_row_dropdown_actions = function(){
	with( this ){
		this.add_row_dropdown_menu.find( 'div.otw-add-row-selector' ).click( function( event ){
			
			var all_links = jQuery( this ).find( 'span' );
				
			if( all_links.size() ){
				
				var row_id = add_row();
				
				for( var cL = 0; cL < all_links.length; cL++ ){
					var data_column = jQuery( all_links[cL] ).attr( 'data-column' );
					
					var column_rows = false;
					
					if( column_rows = data_column.match( /^([0-9]+)\_([0-9]+)$/ ) ){
						add_column( row_id, column_rows[1], column_rows[2], 0, 0 );
					};
				};
				
			};
			add_row_dropdown_menu.hide();
			preview();
		});
		this.add_row_dropdown_menu.find( 'a' ).click( function( event ){
		
			var class_name = jQuery( this ).attr( 'class' );
			
			if( class_name ){
				
				var matches = false;
				if( matches = jQuery( this ).attr( 'class' ).match( /otw\-grid\-manager\-add_row\-dropdown\-action\-([a-z\_\-]+)/ ) ){
					
					switch( matches[1] ){
					
						case 'close':
								add_row_dropdown_menu.hide();
							break;
						case 'add':
								add_row();
								add_row_dropdown_menu.hide();
								preview();
							break;
						case 'insert':
								
								
								var all_links = jQuery( this ).find( 'span' );
								
								if( all_links.size() ){
									
									var row_id = add_row();
									
									for( var cL = 0; cL < all_links.length; cL++ ){
										var data_column = jQuery( all_links[cL] ).attr( 'data-column' );
										
										var column_rows = false;
										
										if( column_rows = data_column.match( /^([0-9]+)\_([0-9]+)$/ ) ){
											add_column( row_id, column_rows[1], column_rows[2], 0, 0 );
										};
									};
									
								};
								add_row_dropdown_menu.hide();
								preview();
							break;
					};
					event.preventDefault();
					event.stopPropagation();
				};
				
			};
		});
	};
};

otw_grid_manager_object.prototype.init_add_column_dropdown_actions = function(){
	
	with( this ){
		this.add_column_dropdown_menu.find( 'div.otw-add-column-selector span' ).click( function( event ){
			
			var row_id = add_column_dropdown_menu.attr( 'data-row-id' );
			
			var data_column = jQuery( this ).attr( 'data-column' );
			
			if( data_column ){
				var column_rows = false;
				
				if( column_rows = data_column.match( /^([0-9]+)\_([0-9]+)$/ ) ){
					add_column( row_id, column_rows[1], column_rows[2], 0, 0 );
					add_column_dropdown_menu.hide();
					preview();
				};
			}
			event.preventDefault();
			event.stopPropagation();
		});
		this.add_column_dropdown_menu.find( 'a' ).click( function( event ){
		
			var class_name = jQuery( this ).attr( 'class' );
			
			if( class_name ){
				
				var matches = false;
				if( matches = jQuery( this ).attr( 'class' ).match( /otw\-grid\-manager\-add_column\-dropdown\-action\-([a-z\_\-]+)/ ) ){
					
					switch( matches[1] ){
					
						case 'close':
								add_column_dropdown_menu.hide();
							break;
						case 'add':
								close_dropdowns();
								jQuery.get( 'admin-ajax.php?action='+ add_column_action ,function(b){
									
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
										
									}
									init_column_dialog( -1 );
									var f=jQuery(window).width();
									b=jQuery(window).height();
									f=920<f?920:f;
									f-=80;
									b=760<b?760:b;
									b-=110; 
									
									tb_show( add_columns_title, "#TB_inline?width="+f+"&height="+b+"&inlineId=otw-dialog" );
								});
							break;
						case 'insert':
								var data_column = jQuery( this ).attr( 'data-column' );
								var row_id = add_column_dropdown_menu.attr( 'data-row-id' );
								var insert_columns = data_column.split( '-' );
								
								for( var cI = 0; cI < insert_columns.length; cI++){
									
									var column_rows = false;
									
									if( column_rows = insert_columns[ cI ].match( /^([0-9]+)\_([0-9]+)$/ ) ){
										var new_columns_id = add_column( row_id, column_rows[1], column_rows[2], 0, 0 );
										
										if( new_columns_id > -1 ){
											add_column_dropdown_menu.hide();
											preview();
										}else{
											break;
										};
									};
									
								};
								
							break;
					};
					event.preventDefault();
					event.stopPropagation();
				};
				
			};
		});
	};
};

otw_grid_manager_object.prototype.init_template_dropdown_actions = function(){
	
	with( this ){
		
		this.templates_dropdown_menu.find( 'a' ).click( function( event ){
			
			var class_name = jQuery( this ).attr( 'class' );
			
			if( class_name ){
				
				var matches = false;
				if( matches = jQuery( this ).attr( 'class' ).match( /otw\-grid\-manager\-templates\-dropdown\-action\-([a-z]+)/ ) ){
				
					switch( matches[1] ){
					
						case 'close':
								templates_dropdown_menu.hide();
							break;
						case 'save':
								var template_name = prompt( get_label( 'Please type template name' ) );
								
								if( template_name ){
									
									jQuery.post( 'admin-ajax.php?action=otw_grid_manager_save_template' , { 'template_code': code_container.val(), 'template_name': template_name, 'grid_manager': object_name },function( result ){
										
										if( result && result != -1 ){
											templates = jQuery.parseJSON( result );
											build_templates_menu_links();
										}else{
											templates_dropdown_menu.hide();
										};
									});
								};
							break;
						case 'delete':
								var key = jQuery( this ).attr( 'data-key' );
								if( key.match( /([0-9]+)/ ) && confirm( 'Please confirm to delete this template' ) ){
									
									jQuery.post( 'admin-ajax.php?action=otw_grid_manager_delete_template' , { 'template_key': key, 'grid_manager': object_name },function( result ){
										if( result && result != -1 ){
											templates = jQuery.parseJSON( result );
											build_templates_menu_links();
										}else{
											templates_dropdown_menu.hide();
										};
									});
								};
							break;
						case 'load':
								var key = jQuery( this ).attr( 'data-key' );
								
								if( key.match( /([0-9]+)/ ) ){
									jQuery.post( 'admin-ajax.php?action=otw_grid_manager_load_template' , { 'template_key': key, 'grid_manager': object_name },function( result ){
										
										if( result && result != -1 ){
											load_from_json( result );
											templates_dropdown_menu.hide();
										}else{
											templates_dropdown_menu.hide();
										};
									});
								}
							break;
					};
				};
			};
			event.preventDefault();
			event.stopPropagation();
		});
	};
};

otw_grid_manager_object.prototype.set_code = function(){
	
	var code = JSON.stringify( this.rows );
	
	this.code_container.val( code );
};

otw_grid_manager_object.prototype.preview = function(){
	
	this.set_code();
	
	var html = '';
	
	for( var cR = 0; cR < this.rows.length; cR++ ){
	
		html = html + '<div class="otw-grid-manager-row otw-row otw-row-n' + cR + '">';
			html = html + '<div class="otw-row-content">';
				html = html + '<div class="otw-row-controls">';
					html = html + '<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr>';
					html = html + '<td width=\"100%\"><div class="otw-row-control-move"><span>' + this.get_label( 'Content Row' ) + '</span></div></td>';
					html = html + '<td><a href="javascript:;" class=\"otw-row-control-add\" title="' + this.get_label( 'Add' ) + '" ></a></td>';
					html = html + '<td><a href="javascript:;" class=\"otw-row-control-copy\" title="' + this.get_label( 'Copy row' ) + '" ></a></td>';
					html = html + '<td><a href="javascript:;" class=\"otw-row-control-clone\" title="' + this.get_label( 'Clone' ) + '" ></a></td>';
					html = html + '<td><a href="javascript:;" class=\"otw-row-control-delete\" title="' + this.get_label( 'Delete' ) + '"></a></td>';
					html = html + '</tr></table>';
				html = html + '</div>';
				/* check if row is full with coluns*/
				var is_full = '';
				if( this.rows[ cR ].columns.length ){
					
					if( !this.valid_column_numbers( cR, [ [ 1, 6 ] ], [] ) ){
						is_full = ' otw-full-row';
					};
				};
				var data_columns = 0;
				if( this.rows[ cR ].columns.length ){
					for( var cC = 0; cC < this.rows[ cR ].columns.length; cC++ ){
						data_columns = data_columns + ( ( this.grid_size / this.rows[cR].columns[ cC ].from_rows ) * this.rows[cR].columns[cC].rows );
					};
				};
				
				html = html + '<div class="otw-row-columns otw-row-columns-r' + cR + is_full + '" data-columns="' + data_columns + '">';
				if( this.rows[ cR ].columns.length ){
				
					for( var cC = 0; cC < this.rows[ cR ].columns.length; cC++ ){
						
						var column_class = this.get_column_class( this.rows[ cR ].columns[ cC ].rows, this.rows[cR].columns[cC].from_rows );
						var is_last = '';
						if( cC == ( this.rows[ cR ].columns.length - 1 )   ){
							is_last = ' end';
						};
						var c_type = 'big';
						/*
						if( ( this.rows[ cR ].columns[ cC ].rows == 1 ) && ( this.rows[cR].columns[cC].from_rows == 6 ) ){
							c_type = 'small';
						}*/
						html = html + '<div class="otw-' + column_class + ' otw-columns otw-column-r'+ cR +'-n' + cC + is_last + '" data-columns="' + ( ( this.grid_size / this.rows[cR].columns[ cC ].from_rows ) * this.rows[cR].columns[cC].rows ) + '" >';
							html = html + '<div class="otw-column-content otw-' + c_type + '-column">';
							
								html = html + '<div class="otw-column-controls">';
								
								html = html + '<div class="otw-column-control-move">';
								html = html + '<a href="javascript:;" class=\"otw-column-control-resize-left\" title="' + this.get_label( 'Decrease width' ) +'"></a>';
								html = html + '<span>' + this.rows[cR].columns[ cC ].rows + '/' +  this.rows[cR].columns[cC].from_rows + '</span>';
								html = html + '<a href="javascript:;" class=\"otw-column-control-resize-right\" title="' + this.get_label( 'Increase width' ) +'"></a>';
								html = html + '<div class="otw-column-controls-rightalign">';
								html = html + '<a href="javascript:;" class=\"otw-column-control-add\" title="' + this.get_label( 'Add' ) + '"></a>';
								html = html + '<a href="javascript:;" class=\"otw-column-control-edit\" title="' + this.get_label( 'Edit' ) + '"></a>';
								html = html + '<a href="javascript:;" class=\"otw-column-control-copy\" title="' + this.get_label( 'Copy column' ) + '"></a>';
								html = html + '<a href="javascript:;" class=\"otw-column-control-clone\" title="' + this.get_label( 'Clone' ) + '"></a>';
								html = html + '<a href="javascript:;" class=\"otw-column-control-delete\" title="' + this.get_label( 'Delete' ) + '"></a>';
								html = html + '</div>';
            							html = html + '</div>';
								
								html = html + '</div>';
								html = html + '<div class="otw-column-shortcodes otw-column-type-'+ c_type +' otw-column-shortocode-r' + cR +'-n' + cC + '">';
								if( this.rows[cR].columns[cC].shortcodes.length ){
									for( var cS = 0; cS < this.rows[cR].columns[cC].shortcodes.length; cS++ ){
										html = html + this.rows[cR].columns[cC].shortcodes[ cS ].html_code( this.object_name, cR, cC, cS, this, this.rows[cR].columns[cC].shortcodes.length );
									};
								}else{
									html = html + '<div class=\"otw-column-noshortcode\"><a href=\"javascript\" class="otw-column-control-add">'+ this.get_label( 'Add item' ) +'</a></div>';
								};
								html = html + '</div>';
							html = html + '</div>';
						html = html + '</div>';
					};
				}else{
					html = html + '<div class=\"otw-row-nocolumn\"><a href=\"javascript\" class="otw-row-control-add">'+ this.get_label( 'Add column' ) +'</a></div>';
				}
				html = html + '</div>';
			html = html + '</div>';
		html = html + '</div>';
	};
	
	this.preview_container.html( html );
	
	with( this ){
		preview_container.find( '.end' ).each( function(){
			
			var elem = jQuery( this );
			var columns = elem.attr( 'data-columns' );
			
			var percent = Math.round( ( columns / grid_size ) * 100 );
			this.style.width = ( percent - 1 ) + '%';
		} );
	}
	this.inline_preview();
	
	this.init_controls();
	
	this.row_column_nodes = this.preview_container.find( 'div.otw-row-columns' );
};
otw_grid_manager_object.prototype.inline_preview = function(){
	
	var post_object = [];
	for( var cR = 0; cR < this.rows.length; cR++){
		
		for( var cC = 0; cC < this.rows[ cR ].columns.length; cC++){
			
			for( var cS = 0; cS < this.rows[ cR ].columns[ cC ].shortcodes.length; cS++ ){
				
				var post_data = {};
				post_data.code = this.rows[ cR ].columns[ cC ].shortcodes[ cS ].shortcode_code;
				post_data.row_id = cR;
				post_data.column_id = cC;
				post_data.shortcode_id = cS;
				post_data.object_name = this.object_name;
				post_object[ post_object.length ] = post_data;
			};
		};
	};
	
	jQuery.post( 'admin-ajax.php?action=otw_shortcode_preview_shortcodes' , { 'shortcode': post_object },function( result ){
		
		var response = jQuery.parseJSON( result );
		if( response.shortcodes ){
			
			for( var cS = 0; cS < response.shortcodes.length; cS++){
			
				var frame_id = 'otw-shortcode-preview_' + response.shortcodes[cS].object_name + '_' + response.shortcodes[cS].row_id + '_' + response.shortcodes[cS].column_id + '_' + response.shortcodes[cS].shortcode_id;
				
				jQuery( '#' + frame_id ).contents().find('body').html( '' );
				jQuery( '#' + frame_id ).contents().find('body').append( response.shortcodes[cS].preview );
				jQuery( '#' + frame_id ).contents().find('body')[0].style.border=  'none';
				jQuery( '#' + frame_id ).contents().find('body')[0].style.background =  'none';
				jQuery( '#' + frame_id ).contents().find('a,input').click( function( event ){
					event.stopPropagation();
					return false;
				});
			};
		};
	});
};
otw_grid_manager_object.prototype.init_controls = function(){
	
	with( this ){
		
		this.preview_container.find( 'a.otw-row-control-add' ).click( function( event ){
			
			close_dropdowns();
			
			var row_id = get_row_number_from_controls( this );
				
			if( row_id > -1 ){
				if( valid_column_numbers( row_id, [ [1, 6] ], [] ) ){
					show_add_column_menu( this, row_id );
					event.preventDefault();
					event.stopPropagation();
				}else{
					row_error( row_id, get_label( 'The row is already full.' ) );
				}
			};
		} );
		
		this.preview_container.find( 'a.otw-row-control-copy' ).click( function( event ){
			
			close_dropdowns();
			
			var row_id = get_row_number_from_controls( this );
			
			if( row_id > -1 ){
			
				var row_shortcode_code = '[otw_shortcode_grid_row]';
				
				if( rows[ row_id ].columns.length ){
				
					for( var cC = 0; cC < rows[ row_id ].columns.length; cC++ ){
					
						row_shortcode_code = row_shortcode_code + rows[ row_id ].columns[ cC ].get_shortcode_code( rows[ row_id ].columns.length, cC );
					}
				}
				
				row_shortcode_code = row_shortcode_code + '[/otw_shortcode_grid_row]';
				show_copy_popup( event, jQuery( this ), row_shortcode_code );
			};
			
		} );
		
		this.preview_container.find( 'a.otw-row-control-clone' ).click( function(){
			
			close_dropdowns();
			
			var row_id = get_row_number_from_controls( this );
			
			if( row_id > -1 ){
				clone_row( row_id );
			};
			
		} );
		
		this.preview_container.find( 'a.otw-row-control-delete' ).click( function(){
			
			close_dropdowns();
			
			if( confirm( get_label( 'Please confirm to remove the row' ) ) ){
				
				var row_id = get_row_number_from_controls( this );
				
				if( row_id > -1 ){
					remove_row( row_id )
				}
			};
		} );
		
		this.preview_container.find( 'a.otw-column-control-resize-left' ).click( function(){
			
			close_dropdowns();
			
			var row_id = get_row_number_from_controls( this );
			
			var column_id = get_column_number_from_controls( this );
			
			if( ( row_id > -1 ) && ( column_id > -1 ) ){
				
				for( var cS = ( column_sizes.length -1 ); cS >= 0; cS-- ){
					
					if( ( column_sizes[ cS ][ 0 ] == rows[ row_id ].columns[ column_id ].rows ) && ( column_sizes[ cS ][ 1 ] ==  rows[ row_id ].columns[ column_id ].from_rows ) ){
						if( ( cS - 1 ) >= 0 ){
						
							if( valid_column_numbers( row_id, [ [ column_sizes[ cS - 1 ][ 0 ], column_sizes[ cS - 1 ][ 1 ] ] ], [ column_id ] ) ){
								rows[ row_id ].columns[ column_id ].rows = column_sizes[ cS - 1 ][ 0 ];
								rows[ row_id ].columns[ column_id ].from_rows = column_sizes[ cS - 1 ][ 1 ];
								preview();
							}else{
								row_error( row_id, get_label( 'The row is already full.' ) );
							}
							break;
						}
					}
				};
				
			};
		} );
		this.preview_container.find( 'a.otw-column-control-resize-right' ).click( function(){
			
			close_dropdowns();
			
			var row_id = get_row_number_from_controls( this );
			
			var column_id = get_column_number_from_controls( this );
			
			if( ( row_id > -1 ) && ( column_id > -1 ) ){
				
				for( var cS = 0; cS < column_sizes.length; cS++ ){
					
					if( ( column_sizes[ cS ][ 0 ] == rows[ row_id ].columns[ column_id ].rows ) && ( column_sizes[ cS ][ 1 ] == rows[ row_id ].columns[ column_id ].from_rows ) ){
						if( ( cS + 1 ) < column_sizes.length ){
							
							if( valid_column_numbers( row_id, [ [ column_sizes[ cS + 1 ][ 0 ], column_sizes[ cS + 1 ][ 1 ] ] ], [ column_id ] ) ){
								rows[ row_id ].columns[ column_id ].rows = column_sizes[ cS + 1 ][ 0 ];
								rows[ row_id ].columns[ column_id ].from_rows = column_sizes[ cS + 1 ][ 1 ];
								preview();
							}else{
								row_error( row_id, get_label( 'The row is already full.' ) );
							}
							break;
						};
					};
				};
				
			};
		} );
		this.preview_container.find( 'a.otw-column-control-add' ).click( function( event ){
			
			close_dropdowns();
			
			if( typeof( otw_shortcode_component ) != 'object' ){
				alert( 'Error: Please include OTW Shortcode component' );
			}else{
				var row_id = get_row_number_from_controls( this );
				var column_id = get_column_number_from_controls( this );
				
				close_dropdowns();
				
				otw_shortcode_component.open_drowpdown_menu( this );
				
				otw_shortcode_component.insert_code = function( shortcode_object ){
					
					rows[ row_id ].columns[ column_id ].add_shortcode( shortcode_object );
					tb_remove();
					preview();
				};
			};
			event.preventDefault();
			event.stopPropagation();
		} );
		
		this.preview_container.find( 'a.otw-column-control-edit' ).click( function( event ){
			
			close_dropdowns();
			
			if( typeof( otw_shortcode_component ) != 'object' ){
			
				alert( 'Error: Please include OTW Shortcode component' );
			}else{
				var row_id = get_row_number_from_controls( this );
				var column_id = get_column_number_from_controls( this );
				
				jQuery.get( 'admin-ajax.php?action='+ add_column_action ,function(b){
					
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
					}
					init_column_dialog( row_id, column_id );
					var f=jQuery(window).width();
					b=jQuery(window).height();
					f=920<f?920:f;
					f-=80;
					/*b-=84;*/
					b=760<b?760:b;
					b-=110; 
					
					tb_show( add_columns_title, "#TB_inline?width="+f+"&height="+b+"&inlineId=otw-dialog" );
				} );
			};
			event.preventDefault();
			event.stopPropagation();
		} );
		
		this.preview_container.find( 'a.otw-column-control-copy' ).click( function( event ){
			
			close_dropdowns();
			
			var row_id = get_row_number_from_controls( this );
			var column_id = get_column_number_from_controls( this );
			
			if( ( row_id > -1 ) && ( column_id > -1 ) ){
				
				show_copy_popup( event, jQuery( this ), rows[ row_id ].columns[ column_id ].get_shortcode_code( rows[ row_id ].columns.length, column_id ) );
			};
		} );

		
		this.preview_container.find( 'a.otw-column-control-clone' ).click( function(){
			
			close_dropdowns();
			
			var row_id = get_row_number_from_controls( this );
			var column_id = get_column_number_from_controls( this );
			
			if( ( row_id > -1 ) && ( column_id > -1 ) ){
				clone_column( row_id, column_id );
			};
		} );
		this.preview_container.find( 'a.otw-column-control-delete' ).click( function(){
			
			close_dropdowns();
			
			if( confirm( get_label( 'Please confirm to remove the column' ) ) ){
				
				var row_id = get_row_number_from_controls( this );
				
				var column_id = get_column_number_from_controls( this );
				
				if( ( row_id > -1 ) && ( column_id > -1 ) ){
					remove_column( row_id, column_id )
				}
			};
		} );
		
		this.preview_container.find( 'a.otw-shortcode-control-copy' ).click( function( event ){
			
			close_dropdowns();
			
			var row_id = get_row_number_from_controls( this );
			var column_id = get_column_number_from_controls( this );
			var shortcode_id = get_shortcode_number_from_controls( this );
			
			if( ( row_id > -1 ) && ( column_id > -1 ) && ( shortcode_id > -1 ) ){
			
				var shortcode = rows[ row_id ].columns[ column_id ].shortcodes[ shortcode_id ];
				
				show_copy_popup( event, jQuery( this ), shortcode.shortcode_code );
			}
		} );

		
		this.preview_container.find( 'a.otw-shortcode-control-clone' ).click( function(){
			
			close_dropdowns();
			
			var row_id = get_row_number_from_controls( this );
			var column_id = get_column_number_from_controls( this );
			var shortcode_id = get_shortcode_number_from_controls( this );
			
			if( ( row_id > -1 ) && ( column_id > -1 ) && ( shortcode_id > -1 ) ){
				clone_shortcode( row_id, column_id, shortcode_id );
			};
		} );
		this.preview_container.find( 'a.otw-shortcode-control-edit' ).click( function(){
			
			close_dropdowns();
			
			var row_id = get_row_number_from_controls( this );
			var column_id = get_column_number_from_controls( this );
			var shortcode_id = get_shortcode_number_from_controls( this );
			
			if( ( row_id > -1 ) && ( column_id > -1 ) && ( shortcode_id > -1 ) ){
				
				var shortcode = rows[ row_id ].columns[ column_id ].shortcodes[ shortcode_id ];
				var shortcode_type = rows[ row_id ].columns[ column_id ].shortcodes[ shortcode_id ].shortcode_type;
				
				var post_data = {};
				for( var s_item in shortcode ){
					
					if( typeof( shortcode[ s_item ] ) != 'function' ){
						post_data[ 'otw-shortcode-element-' + s_item ] = shortcode[ s_item ];
					};
				};
				
				jQuery.post( 'admin-ajax.php?action=otw_shortcode_editor_dialog&shortcode=' + shortcode_type, { shortcode_object: post_data }, function(b){
				
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
						
						jQuery( '#TB_ajaxContent' ).css( 'width', '950px' );
						jQuery( '#TB_ajaxContent' ).css( 'padding', '0' );
					}
					var f=jQuery(window).width();
					b=jQuery(window).height();
					f=1000<f?1000:f;
					f-=80;
					/*b-=84;*/
					b=760<b?760:b;
					b-=110; 
					
					jQuery( "#otw-dialog").find( '#otw-shortcode-btn-insert' ).val( get_label( 'Update' ) );
					jQuery( "#otw-dialog").find( '#otw-shortcode-btn-insert-bottom' ).val( get_label( 'Update' ) );
					otw_form_init_fields();
					
					otw_shortcode_editor = new otw_shortcode_editor_object( shortcode_type );
					otw_shortcode_editor.init_fields();
					otw_shortcode_editor.shortcode_created = function( shortcode_object ){
						
						for( var sh_item in shortcode_object ){
							rows[ row_id ].columns[ column_id ].shortcodes[ shortcode_id ][ sh_item ] = shortcode_object[ sh_item ];
						};
						preview();
						tb_remove();
					};
					tb_show( get_label( 'Modify' ) + ' OTW ' + otw_shortcode_component.shortcodes[shortcode_type].title, "#TB_inline?width="+f+"&height="+b+"&inlineId=otw-dialog" );
				});
			}
		} );
		
		this.preview_container.find( 'a.otw-shortcode-control-delete' ).click( function(){
			
			close_dropdowns();
			
			if( confirm( get_label( 'Please confirm to remove the shortcode' ) ) ){
				
				var row_id = get_row_number_from_controls( this );
				var column_id = get_column_number_from_controls( this );
				var shortcode_id = get_shortcode_number_from_controls( this );
				
				if( ( row_id > -1 ) && ( column_id > -1 ) && ( shortcode_id > -1 ) ){
					remove_shortcode( row_id, column_id, shortcode_id );
				}
			};
		} );
		this.preview_container.sortable( {
			opacity: 0.6,
			cursor: 'move',
			placeholder: 'otw-grid-manager-row-placeholder',
			forcePlaceholderSize: true,
			handle: '.otw-row-control-move',
			start: function( param1, param2 ){
				close_dropdowns();
				this.sorted = false;
				param2.item.find( '.otw-shortcode-preview' ).html( '' );
			},
			stop: function( param1, param2 ){
				if( !this.sorted ){
					preview();
				};
			},
			update: function( event, ui ){
				this.sorted = true;
				order_rows();
			},
			items: 'div.otw-grid-manager-row',
			dropOnEmpty: true
		} );
		
		with( this ){
			preview_container.find( '.otw-grid-manager-row .otw-row-columns' ).sortable( {
				opacity: 0.6,
				cursor: 'move',
				placeholder: 'otw-grid-manager-column-placeholder',
				forcePlaceholderSize: true,
				handle: '.otw-column-control-move',
				start: function( param1, param2 ){
					close_dropdowns();
					this.sorted = false;
					param2.item.find( '.otw-shortcode-preview' ).html( '' );
					
					var full_row = param2.placeholder.parents( 'div.otw-row-columns' );
					
					if( full_row.size() ){
						param2.placeholder.initial_parent = full_row[0];
					};
				},
				stop: function( event, ui ){
					
					if( is_target_row_full( ui.item, ui.item ) ){
						ui.item.hide();
					};
					
					if( !this.sorted ){
						preview();
					}else{
						order_columns();
					}
				},
				update: function( event, ui ){
					this.sorted = true;
				},
				change: function( event, ui ){
					
					var no_columns_div = ui.placeholder.parent().find( 'div.otw-row-nocolumn' );
					if( no_columns_div.size() ){
						preview_container.find( 'div.otw-row-nocolumn' ).show();
						no_columns_div.hide();
					}else{
						preview_container.find( 'div.otw-row-nocolumn' ).show();
					};
					
					row_column_nodes.removeClass( 'otw-row-error' );
					var cc_row = ui.placeholder.parents( 'div.otw-row-columns' );
					
					if( ( ui.placeholder.initial_parent !== cc_row[0] ) &&  is_target_row_full( ui.placeholder, ui.item ) ){
						cc_row.addClass( 'otw-row-error' );
						ui.placeholder.hide();
					}else{
						ui.placeholder.show();
					};
				},
				items: 'div.otw-columns',
				connectWith: 'div.otw-row-columns',
				dropOnEmpty: true
			} );
			
			preview_container.find( '.otw-column-shortcodes' ).sortable( {
				opacity: 0.6,
				cursor: 'move',
				forcePlaceholderSize: true,
				handle: '.otw-shortcode-control-move',
				placeholder: 'otw-grid-manager-shortcode-placeholder',
				start: function( param1, param2 ){
					close_dropdowns();
					this.sorted = false;
					param2.item.find( '.otw-shortcode-preview' ).html( '' );
				},
				stop: function( param1, param2 ){
					if( !this.sorted ){
						preview();
					};
				},
				change: function( event, ui ){
					/*check if there no items div*/
					var no_items_div = ui.placeholder.parent().find( 'div.otw-column-noshortcode' );
					if( no_items_div.size() ){
						preview_container.find( 'div.otw-column-noshortcode' ).show();
						no_items_div.hide();
					}else{
						preview_container.find( 'div.otw-column-noshortcode' ).show();
					}
				},
				update: function( event, ui ){
					this.sorted = true;
					order_shortcodes();
				},
				items: 'div.otw-column-shortcode',
				connectWith: '.otw-column-shortcodes',
				dropOnEmpty: true
			} );
		}
	};
};
otw_grid_manager_object.prototype.is_target_row_full = function( target_child, item ){
	
	var full_row = target_child.parents( 'div.otw-full-row' );
	
	if( full_row.size() ){
		return true;
	};
	
	var current_columns = Number( target_child.parents( '.otw-row-columns' ).attr( 'data-columns' ) );
	var new_columns = Number( item.attr( 'data-columns' ) );
	
	if( ( current_columns + new_columns ) > this.grid_size ){
		return true;
	}
	
	return false;
};
otw_grid_manager_object.prototype.order_rows = function(){
	
	var rows_order = new Array();
	
	var h_rows = this.preview_container.find( 'div.otw-grid-manager-row' );
	
	for( var hR = 0; hR < h_rows.length; hR++ ){
		
		var matches = false;
		if( matches = jQuery( h_rows[ hR ] ).attr( 'class' ).match( /otw\-row\-n([0-9]+)/ ) ){
			rows_order[ hR ] = matches[1];
		};
	};
	
	var tmp_rows = this.rows;
	
	this.rows = new Array();
	
	for( var cR = 0; cR < rows_order.length; cR++ ){
		
		this.rows[ cR ] = tmp_rows[ rows_order[cR] ];
	};
	
	this.preview();
};
otw_grid_manager_object.prototype.order_columns = function( column_order ){
	
	var all_columns = {};
	
	for( var cR = 0; cR < this.rows.length; cR++ ){
		
		for( var cC = 0; cC < this.rows[cR].columns.length; cC++ ){
			
			all_columns[ cR + '_' + cC] = this.rows[cR].columns[ cC ];
		};
	};
	
	//need to check if all are valid number of columns
	for( var cR = 0; cR < this.rows.length; cR++ ){
	
		var html_columns = this.preview_container.find( 'div.otw-row-columns-r' + cR + ' div.otw-columns');
		
		var row_columns = new Array();
		
		for( cS = 0; cS < html_columns.length; cS ++){
		
			var matches = false;
			if( matches = jQuery( html_columns[cS] ).attr('class').match( /otw-column-r([0-9]+)-n([0-9]+)/ ) ){
			
				row_columns[ row_columns.length ] = new Array( all_columns[ matches[1] + '_' +  matches[2] ].rows, all_columns[ matches[1] + '_' +  matches[2] ].from_rows );
			};
		};
		
		if( !this.valid_column_numbers( -1, row_columns ) ){
			
			var valid_string = this.get_label( 'Row with columns' );
			
			for( var cV = 0; cV < row_columns.length; cV++ ){
				
				valid_string = valid_string + ' ' + row_columns[ cV ][0] + '/' + row_columns[ cV ][1]
			};
			valid_string = valid_string + this.get_label( ' is not valid' );
			
			with( this ){
				preview();
				row_error( cR, 'The row is already full.' );
			}
			return;
		}
	};
	
	for( var cR = 0; cR < this.rows.length; cR++ ){
		
		this.rows[cR].columns = new Array();
		
		var html_columns = this.preview_container.find( 'div.otw-row-columns-r' + cR + ' div.otw-columns');
		
		for( cS = 0; cS < html_columns.length; cS ++){
			
			var matches = false;
			if( matches = jQuery( html_columns[cS] ).attr('class').match( /otw-column-r([0-9]+)-n([0-9]+)/ ) ){
				
				this.rows[ cR ].columns[ this.rows[ cR ].columns.length ] = all_columns[ matches[1] + '_' +  matches[2] ];
			};
		};
	};
	this.preview();
};
otw_grid_manager_object.prototype.order_shortcodes = function( column_order ){
	
	var all_shortcodes = {};
	for( var cR = 0; cR < this.rows.length; cR++ ){
		
		for( var cC = 0; cC < this.rows[cR].columns.length; cC++ ){
			
			for( var cS = 0; cS < this.rows[cR].columns[cC].shortcodes.length; cS++ ){
				
				all_shortcodes[ cR + '_' + cC + '_' + cS ] = this.rows[cR].columns[cC].shortcodes[ cS ];
			};
		};
	};
	for( var cR = 0; cR < this.rows.length; cR++ ){
	
		for( var cC = 0; cC < this.rows[cR].columns.length; cC++ ){
		
			var html_shortcodes = this.preview_container.find( 'div.otw-column-shortocode-r' + cR + '-n' + cC +' div.otw-column-shortcode');
			
			this.rows[ cR ].columns[ cC ].shortcodes = new Array();
			
			for( cS = 0; cS < html_shortcodes.length; cS ++){
			
				var matches = false;
				
				if( matches = jQuery( html_shortcodes[cS] ).attr('class').match( /otw-column-shortcode\-r([0-9]+)\-n([0-9]+)\-s([0-9]+)/ ) ){
				
					this.rows[cR].columns[ cC ].add_shortcode( all_shortcodes[ matches[1] + '_' +  matches[2] + '_' +  matches[3] ] );
				};
			};
		};
		
	};
	
	this.preview();
};
otw_grid_manager_object.prototype.clone_row = function( row_id ){

	var tmp_rows = this.rows;
	
	this.rows = new Array();
	
	for( var cR = 0; cR < tmp_rows.length; cR++ ){
	
		this.rows[ this.rows.length ] = tmp_rows[ cR ];
		
		if( cR == row_id ){
			var new_row_id = this.rows.length;
			
			this.rows[ new_row_id ] = new otw_grid_manager_row();
			
			for( var cC = 0; cC < this.rows[ row_id ].columns.length; cC++ ){
			
				var new_column_id = this.add_column( new_row_id, this.rows[ row_id ].columns[ cC ].rows, this.rows[ row_id ].columns[cC].from_rows, this.rows[ row_id ].columns[cC].mobile_rows, this.rows[ row_id ].columns[cC].mobile_from_rows );
				
				for( var cS = 0; cS < this.rows[ row_id ].columns[ cC ].shortcodes.length; cS++ ){
					this.rows[ new_row_id ].columns[ new_column_id ].add_shortcode( this.rows[ row_id ].columns[ cC ].shortcodes[ cS ] );
				};
				
			};
		};
	};
	
	this.preview();
};

otw_grid_manager_object.prototype.clone_column = function( row_id, column_id ){
	
	//vadate if possible to add column before add it
	if( !this.valid_column_numbers( row_id, [ [ this.rows[row_id].columns[ column_id ].rows, this.rows[row_id].columns[ column_id ].from_rows ] ], [] ) )
	{
		this.row_error( row_id, this.get_label( 'The row is already full.' ) );
		return;
	};
	
	var tmp_columns = this.rows[row_id].columns;
	
	this.rows[ row_id ].columns = new Array();
	
	for( var cR = 0; cR < tmp_columns.length; cR++ ){
	
		this.rows[ row_id ].columns[ this.rows[ row_id ].columns.length ] = tmp_columns[ cR ];
		if( cR == column_id ){
			var new_column_id = this.rows[ row_id ].columns.length;
			this.rows[ row_id ].columns[ new_column_id ] = new otw_grid_manager_column( tmp_columns[ cR ].rows, tmp_columns[ cR ].from_rows, tmp_columns[ cR ].mobile_rows, tmp_columns[ cR ].mobile_from_rows );
			
			for( var cS = 0; cS < tmp_columns[ column_id ].shortcodes.length; cS++ ){
				this.rows[ row_id ].columns[ new_column_id ].add_shortcode( tmp_columns[ column_id ].shortcodes[ cS ] );
			}
		};
	};
	
	this.preview();
};

otw_grid_manager_object.prototype.clone_shortcode = function( row_id, column_id, shortcode_id ){
	
	var tmp_shortcodes = this.rows[ row_id ].columns[ column_id ].shortcodes;
	
	this.rows[ row_id ].columns[ column_id ].shortcodes = new Array();
	
	for( var cR = 0; cR < tmp_shortcodes.length; cR++ ){
		
		this.rows[ row_id ].columns[ column_id ].shortcodes[ this.rows[ row_id ].columns[ column_id ].shortcodes.length ] = tmp_shortcodes[ cR ];
		if( cR == shortcode_id ){
			this.rows[ row_id ].columns[ column_id ].shortcodes[ this.rows[ row_id ].columns[ column_id ].shortcodes.length ] = new otw_grid_manager_shortcode( tmp_shortcodes[ cR ] );
		};
	};
	this.preview();
};

otw_grid_manager_object.prototype.remove_shortcode = function( row_id, column_id, shortcode_id ){

	var tmp_shortcodes = this.rows[ row_id ].columns[ column_id ].shortcodes;
	
	this.rows[ row_id ].columns[ column_id ].shortcodes = new Array();
	
	for( var cR = 0; cR < tmp_shortcodes.length; cR++ ){
	
		if( cR != shortcode_id ){
			this.rows[ row_id ].columns[ column_id ].shortcodes[ this.rows[ row_id ].columns[ column_id ].shortcodes.length ] = tmp_shortcodes[ cR ];
		};
	};
	
	this.preview();

};
otw_grid_manager_object.prototype.remove_row = function( row_id ){
	
	var tmp_rows = this.rows;
	
	this.rows = new Array();
	
	for( var cR = 0; cR < tmp_rows.length; cR++ ){
	
		if( cR != row_id ){
			this.rows[ this.rows.length ] = tmp_rows[ cR ];
		};
	};
	
	this.preview();
};
otw_grid_manager_object.prototype.remove_column = function( row_id, column_id ){
	
	var tmp_columns = this.rows[ row_id ].columns;
	
	this.rows[ row_id ].columns = new Array();
	
	for( var cR = 0; cR < tmp_columns.length; cR++ ){
	
		if( cR != column_id ){
			this.rows[ row_id ].columns[ this.rows[ row_id ].columns.length ] = tmp_columns[ cR ];
		};
	};
	
	this.preview();
};
otw_grid_manager_object.prototype.get_shortcode_number_from_controls = function( control ){
	
	var parentClass = jQuery( control ).parents( 'div.otw-column-shortcode').attr( 'class' );
	return this.get_shortcode_number_from_class( parentClass );
};
otw_grid_manager_object.prototype.get_column_number_from_controls = function( control ){
	
	var parentClass = jQuery( control ).parents( 'div.otw-columns').attr( 'class' );
	return this.get_column_number_from_class( parentClass );

};
otw_grid_manager_object.prototype.get_row_number_from_controls = function( control ){
	
	var parentClass = jQuery( control ).parents( 'div.otw-grid-manager-row').attr( 'class' );
	return this.get_row_number_from_class( parentClass );

};
otw_grid_manager_object.prototype.get_row_number_from_class = function( objectClass ){
	
	var matches = false;
	if( matches = objectClass.match( /otw\-row\-n([0-9]+)/ ) ){
		return Number( matches[1] );
	}

	return -1;
};
otw_grid_manager_object.prototype.get_column_number_from_class = function( objectClass ){
	
	var matches = false;
	if( matches = objectClass.match( /otw\-column\-r([0-9]+)\-n([0-9]+)/ ) ){
		return Number( matches[2] );
	}
	
	return -1;
};
otw_grid_manager_object.prototype.get_shortcode_number_from_class = function( objectClass ){
	
	var matches = false;
	if( matches = objectClass.match( /otw\-column\-shortcode\-r([0-9]+)\-n([0-9]+)\-s([0-9]+)/ ) ){
		return Number( matches[3] );
	}
	
	return -1;
};
otw_grid_manager_object.prototype.get_column_class = function( rows, from_rows ){
	
	var class_number = ( this.grid_size / from_rows ) * rows;
	
	return this.number_names[ class_number ];
};

otw_grid_manager_object.prototype.add_row = function( rows, from_rows, mobile_rows, mobile_from_rows ){

	var row_id = this.rows.length;
	
	this.rows[ row_id ] = new otw_grid_manager_row();
	
	return row_id;
};

otw_grid_manager_object.prototype.row_columns_number = function( row_id, ignore_columns ){
	
	var total_columns = 0;
	
	if( this.rows[ row_id ] ){
	
		for( var cC = 0; cC < this.rows[ row_id ].columns.length; cC++ ){
			
			var ignore_column = false;
			
			for( cI = 0; cI < ignore_columns.length; cI++ ){
				
				if( cC == ignore_columns[ cI ] ){
					ignore_column = true;
					break;
				};
			};
			
			if( !ignore_column ){
				total_columns = total_columns + ( ( this.grid_size / this.rows[ row_id ].columns[ cC ].from_rows ) * this.rows[ row_id ].columns[ cC ].rows );
			};
		};
	};
	
	return total_columns;
};

otw_grid_manager_object.prototype.valid_column_numbers = function( row_id, new_columns, ignore_columns ){
	
	
	var current_columns_number = 0;
	
	if( row_id > -1 ){
		current_columns_number = this.row_columns_number( row_id, ignore_columns );
	};
	
	for( var cC = 0; cC < new_columns.length; cC++ ){
		current_columns_number = current_columns_number + ( ( this.grid_size / new_columns[cC][1] ) * new_columns[cC][0] );
	};
	
	if( this.grid_size < current_columns_number )
	{
		return false;
	};
	
	return true;
};

otw_grid_manager_object.prototype.row_error = function( row_id, error_string ){
	
	with( this ){
	
		var row = preview_container.find( '.otw-row-n' + row_id );
		
		row.addClass( 'otw-row-error' );
		
		if( !row_error_message ){
			
			row_error_message = jQuery( '<div id="otw-row-error-message"><div class="otw-row-error-head"><a>x</a></div><div class="otw-row-error-text">' + error_string + '</div></div>' );
			row_error_message.appendTo( jQuery( 'body' ) );
			row_error_message.find( '.otw-row-error-head a' ).click( function(){
				row_error_message.fadeOut();
			});
		}else{
			row_error_message.find( '.otw-row-error-text' ).html( error_string );
			
			try{
				clearTimeout( window.rowermsgtime );
			}catch( e ){};
		}
		
		row_error_message.show();
		
		row_error_message.css( 'top', ( row.offset().top + ( row.height() / 2 ) ) - ( row_error_message.height() / 2 ) );
		row_error_message.css( 'left', ( row.offset().left +  ( row.width() / 2 ) ) - ( row_error_message.width() / 2 ) );
		
		setTimeout( function(){
			row.removeClass( 'otw-row-error' );
		}, 2000 );
		
		window.rowermsgtime = setTimeout( function(){
			row_error_message.fadeOut();
		}, 2000 );
	}
};

otw_grid_manager_object.prototype.add_column = function( row_id, rows, from_rows, mobile_rows, mobile_from_rows ){
	
	if( this.rows[ row_id ] )
	{
		if( this.valid_column_numbers( row_id, [ [ rows, from_rows ] ], [] ) ){
			
			var column_id = this.rows[ row_id ].columns.length;
			
			this.rows[ row_id ].columns[ column_id ] = new otw_grid_manager_column( rows, from_rows, mobile_rows, mobile_from_rows );
			
			return column_id;
		}else{
			alert( this.get_label( 'Can not add column ' ) + rows + '/' + from_rows  );
		}
	};
	
	return -1;
};

otw_grid_manager_row = function(){

	this.columns = new Array();
};

otw_grid_manager_column = function( rows, from_rows, mobile_rows, mobile_from_rows ){
	
	this.rows = Number( rows );
	
	this.from_rows = Number( from_rows );
	
	this.mobile_rows = Number( mobile_rows );
	
	this.mobile_from_rows = Number( mobile_from_rows );
	
	this.shortcodes = new Array();
};
otw_grid_manager_column.prototype.add_shortcode = function( code ){
	
	this.shortcodes[ this.shortcodes.length ] = new otw_grid_manager_shortcode( code );
};
otw_grid_manager_column.prototype.get_shortcode_code = function( total_columns, column_id ){
	
	var shortcode_code = '';
	
	var is_last = '';
	if( total_columns  == ( column_id + 1 ) ){
		
		is_last = ' last="1" ';
	}
	
	shortcode_code = shortcode_code + '[otw_shortcode_grid_column rows="' + this.rows + '" from_rows="'+ this.from_rows + '" mobile_rows="' + this.mobile_rows + '" mobile_from_rows="' + this.mobile_from_rows + '"' + is_last + ']';
	
	if( this.shortcodes.length ){
	
		for( var cS = 0; cS < this.shortcodes.length; cS++ ){
		
			shortcode_code = shortcode_code + this.shortcodes[ cS ].shortcode_code;
		};
	};
	shortcode_code = shortcode_code + '[/otw_shortcode_grid_column]';
	
	return shortcode_code;
}

otw_grid_manager_shortcode = function( settings ){
	
	for( var setting in settings ){
	
		this[ setting ] = settings[ setting ]
	}
}
otw_grid_manager_shortcode.prototype.html_code = function( object_name, row_id, column_id, shortcode_id, parent, total_shortcodes ){
	
	var matches = false;
	var post_id = 0;
	if( matches = location.href.match( /post\=([0-9]+)/ ) ){
		post_id = matches[1];
	}
	
	var last_class = '';
	
	if( total_shortcodes  == ( shortcode_id + 1 ) ){
		last_class = ' otw-last-shortcode';
	};
	
	var html = '';
	html = html + '<div class="otw-column-shortcode otw-column-shortcode-r' + row_id + '-n' + column_id + '-s' + shortcode_id + last_class + '">';
			html = html + '<div class="otw-column-shortcode-content">';
				html = html + '<div class="otw-shortcode-controls">';
				
					//show title
					if( typeof( otw_shortcode_component.shortcodes[ this.shortcode_type ] ) != 'undefined' ){
						if( typeof( this.iname ) != 'undefined' ){
							html = html + '<div class="otw-shortcode-control-move"><span>' + otw_shortcode_component.shortcodes[ this.shortcode_type ].title  + ' - ' + this.iname + '</span>';
						}else{
							html = html + '<div class="otw-shortcode-control-move"><span>' + otw_shortcode_component.shortcodes[ this.shortcode_type ].title + '</span>';
						}
					}
					html = html + '<div class=\"otw-column-controls-rightalign\"><a href="javascript:;" class=\"otw-shortcode-control-edit\" title="' + parent.get_label( 'Edit' ) + '"></a>';
					html = html + '<a href="javascript:;" class=\"otw-shortcode-control-copy\" title="' + parent.get_label( 'Copy shortcode' ) + '"></a>';
					html = html + '<a href="javascript:;" class=\"otw-shortcode-control-clone\" title="' + parent.get_label( 'Clone' ) + '"></a>';
					html = html + '<a href="javascript:;" class=\"otw-shortcode-control-delete\" title="' + parent.get_label( 'Delete' ) + '"></a></div>';
				html = html + '</div>';
	html = html + '</div>';
				html = html + '<div class="otw-shortcode-preview">';
				
				var post_data = {};
				for( var s_item in this ){
					
					if( typeof( this[ s_item ] ) != 'function' ){
						post_data[ s_item ] = this[ s_item ];
					};
				};
				
				var frame_id = 'otw-shortcode-preview_' + object_name + '_' + row_id + '_' + column_id + '_' + shortcode_id;
				
				html = html + '<iframe width="100%" src="about:blank" scrolling="no" height="70" id="' + frame_id + '" style="height: 70px;"></iframe>';
				
				html = html + '</div>';
			html = html + '</div>';
	html = html + '</div>';
	return html;
};

otw_grid_manager_object.prototype.init_column_dialog = function( row_id, column_id ){
	
	otw_form_init_fields();
	
	if( column_id > -1 ){
		this.edit_row_column = row_id;
		this.edit_column = column_id;
		this.selected_column = [ this.rows[ row_id ].columns[ column_id ].rows,  this.rows[ row_id ].columns[ column_id ].from_rows ];
		
		if( this.rows[ row_id ].columns[ column_id ].mobile_rows > 0 && this.rows[ row_id ].columns[ column_id ].mobile_from_rows > 0 ){
			jQuery( '#otw_mobile_column_size' ).val( this.rows[ row_id ].columns[ column_id ].mobile_rows + '_' + this.rows[ row_id ].columns[ column_id ].mobile_from_rows );
			jQuery( '#otw_mobile_column_size' ).change();
		}
		
	}else{
		this.selected_column = new Array();
		this.edit_row_column = -1;
		this.edit_column = -1;
	}
	this.column_dialog_mark_selected();
	
	this.init_add_column_dialog_buttons();
	
	this.init_add_column_dialog_columns();
	
};
otw_grid_manager_object.prototype.column_dialog_mark_selected = function(){
	jQuery( '.otw_grid_manager_column_dlg_row .otw-columns' ).removeClass( 'otw-selected-column' );
	
	if( this.selected_column.length == 2 ){
		jQuery( '.otw_grid_manager_column_dlg_row .otw-column-' + this.selected_column[0] + '_' + this.selected_column[1] ).parent().addClass('otw-selected-column' );
	};
};
otw_grid_manager_object.prototype.init_add_column_dialog_buttons = function(){
	
	with( this ){
		jQuery( '#adv_settings_mobile_container > .otw_mobile' ).click( function(){
		
			var content = jQuery( '#adv_settings_mobile_content' );
			
			if( content.css( 'display' ) == 'none' ){
				content.fadeIn();
				jQuery( this ).addClass( 'adv_opened' );
				var matches = false;
				var img_src = jQuery( this ).find( 'img' ).attr( 'src' );
				if( matches = img_src.match( /gm\-advanced\-(up|down)\-arrow\.png/ ) ){
					jQuery( this ).find( 'img' ).attr( 'src', img_src.replace( 'gm-advanced-' + matches[1] + '-arrow.png', 'gm-advanced-up-arrow.png' ) );
				};
			}else{
				content.fadeOut();
				jQuery( this ).removeClass( 'adv_opened' );
				var matches = false;
				var img_src = jQuery( this ).find( 'img' ).attr( 'src' );
				if( matches = img_src.match( /gm\-advanced\-(up|down)\-arrow\.png/ ) ){
					jQuery( this ).find( 'img' ).attr( 'src', img_src.replace( 'gm-advanced-' + matches[1] + '-arrow.png', 'gm-advanced-down-arrow.png' ) );
				};
			};
		});
		jQuery( '#otw-shortcode-btn-cancel' ).click( function(){
			tb_remove();
		});
		jQuery( '#otw-shortcode-btn-save' ).click( function(){
			
			//get the mobile size;
			var mobile_size = new Array( 0 , 0 );
			var matches = '';
			if( matches = jQuery( '#otw_mobile_column_size' ).val().match( /^([0-9])\_([0-9])$/ ) ){
				mobile_size[0] = matches[1];
				mobile_size[1] = matches[2];
			}
			
			if( ( edit_row_column > - 1 ) && ( edit_column > -1 ) ){
				
				if( valid_column_numbers( edit_row_column, [ [ selected_column[0], selected_column[1] ] ], [ edit_column ] ) ){
					rows[ edit_row_column ].columns[ edit_column ].rows = selected_column[0];
					rows[ edit_row_column ].columns[ edit_column ].from_rows = selected_column[1];
					rows[ edit_row_column ].columns[ edit_column ].mobile_rows = mobile_size[0];
					rows[ edit_row_column ].columns[ edit_column ].mobile_from_rows = mobile_size[1];
					preview();
					tb_remove();
				}else{
					alert( get_label( 'Can not replace ' ) + rows[ edit_row_column ].columns[ edit_column ].rows + '/' + rows[ edit_row_column ].columns[ edit_column ].from_rows + get_label( ' with ' ) + selected_column[0] + '/' +selected_column[1] );
				}
			}else{
				var new_column_id = add_column( add_column_dropdown_menu.attr( 'data-row-id' ), selected_column[0], selected_column[1], mobile_size[0], mobile_size[1] );
				
				if( new_column_id > -1 ){
					preview();
					tb_remove();
				};
			};
			
		});
	};
};
otw_grid_manager_object.prototype.init_add_column_dialog_columns = function(){
	
	with( this ){
		jQuery( '.otw_grid_manager_column_dlg_row .otw-column-content').click( function(){
			
			var matches = false;
			if( matches = jQuery( this ).attr( 'class').match( /otw\-column\-([0-9]+)\_([0-9]+)/ ) ){
				selected_column[ 0 ] = matches[1];
				selected_column[ 1 ] = matches[2];
			};
			column_dialog_mark_selected();
		} );
	};
};

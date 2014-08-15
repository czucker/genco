var otw_sbm_pcm = null;

var otw_sbm_pcm_object = function(){

	this.codeCont = jQuery( '#otw-sbm-pcm-code' );
	
	this.previewCont = jQuery( '#otw-sbm-pcm-preview' );
	
	this.shortcodesCont = jQuery( '#otw-sbm-pcm-shortcode-dialog' );
	
	this.texts = {};
	
	this.rows = [];
	
	this.shortcodes = {
		otw_sidebar: {title: 'OTW Sidebar', enabled: false, children: false}
	};
	
	this.nonce = '';
	
	this.texts.confirm_delete_row = jQuery( '#otw_sbm_pcm_texts_confirm_delete_row' ).html();
	this.texts.confirm_delete_shortcode = jQuery( '#otw_sbm_pcm_texts_confirm_delete_shortcode' ).html();
	
};

otw_sbm_pcm_init = function(){

	otw_sbm_pcm.load_from_json( otw_sbm_pcm.codeCont.val() );
	
	var insertRowButton = jQuery( '#otw_sbm_pcm_insert_row' );
	insertRowButton.attr( 'name', 'Insert Row' );
	
	insertRowButton.click( function(){
	
		jQuery.get( 'admin-ajax.php?action=otw_sbm_pcm_columns' ,function(b){
			
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
			
			var f=jQuery(window).width();
			b=jQuery(window).height();
			f=720<f?720:f;
			f-=80;
			/*b-=84;*/
			b=760<b?760:b;
			b-=80; 
			
			tb_show( "Insert OtwThemes Sidebar Shortcode", "#TB_inline?width="+f+"&height="+b+"&inlineId=otw-dialog" );
		});
	} );
};

otw_sbm_pcm_object.prototype.load_from_json = function( json_code ){

	var row_id = 0;
	if( json_code.length ){
	
		var json_object = eval( json_code );
		
		for( var json_o = 0; json_o < json_object.length; json_o++ ){
			
			row_id = this.add_row( json_object[ json_o ].code );
			
			if( row_id != -1 ){
				
				for( var cell_o = 0; cell_o < json_object[ json_o ].cells.length; cell_o++ ){
					
					for( var shortcode_o = 0; shortcode_o < json_object[ json_o ].cells[ cell_o ].shortcodes.length; shortcode_o++ ){
						this.rows[row_id].cells[ cell_o ].add_shortcode( json_object[ json_o ].cells[ cell_o ].shortcodes[ shortcode_o ].code, json_object[ json_o ].cells[ cell_o ].shortcodes[ shortcode_o ].name );
					}
				}
			}
		}
	};
	this.preview();
};


otw_sbm_pcm_object.prototype.action_link = function( row_id, cell_id ){

	var e = userSettings.url + 'wp-admin/admin-ajax.php?action=otw_editor_dialog';
	with( this ){
		jQuery.get( e ,function(b){
			
			jQuery( "#otw-dialog").remove();
			var cont = jQuery( '<div id="otw-dialog">' + b + '</div>' );
			jQuery( "body").append( cont );
			jQuery( "#otw-dialog").hide();
			
			
			var f=jQuery(window).width();
			b=jQuery(window).height();
			f=720<f?720:f;
			f-=80;
			/*b-=84;*/
			b= 720;
			
			tb_show( "Insert OtwThemes Sidebar Shortcode", "#TB_inline?width="+f+"&height="+b+"&inlineId=otw-dialog" );
			jQuery( '#TB_window' ).find( 'input' )[1].onclick = function(){
				
				var select_box = jQuery( '#o_sidebar' )
				if( rows[ row_id ].cells[ cell_id ].add_shortcode( '[otw_is sidebar=' + select_box.val() +']', select_box.find(":selected").text() ) ){
					
					tb_remove();
					otw_sbm_pcm.set_code();
					otw_sbm_pcm.preview();
				};
				return false;
			};
		
		});
	};
	
	return;
};

otw_sbm_pcm_object.prototype.add_row = function( row_code ){
	var new_row = new otw_sbm_pcm_row();
	if( new_row.create( row_code, this.rows.length ) ){
		var row_id = this.rows.length;
		this.rows[ row_id ] = new_row;
		return row_id;
	};
	return -1;
};

otw_sbm_pcm_object.prototype.set_code = function(){

	code = JSON.stringify( this.rows );
	
	this.codeCont.val( code );
};

otw_sbm_pcm_object.prototype.init_content_actions = function(){
	
	with( this ){
		previewCont.find( 'div.otw_sbm_pcm_rr' ).click( function(){
			
			if( confirm( texts.confirm_delete_row ) ){
				var matches = new Array();
				if( matches = this.id.match( /^otw_sbm_pcm_rr_([0-9]+)$/ ) ){
					remove_row( matches[1] );
				};
			};
		} );
		previewCont.find( 'div.otw_sbm_pcm_add_action' ).click( function( event ){
			
			var matches = new Array();
			if( matches = this.id.match( /^otw-sbm-pcm-add-([0-9]+)-([0-9]+)$/ ) ){
				action_link( matches[1], matches[2] );
				event.preventDefault();
				event.stopPropagation();
			};
		});
		previewCont.find( 'div.otw_sbm_pcm_shortcode_remove' ).click( function(){
			
			if( confirm( texts.confirm_delete_shortcode ) ){
				var matches = new Array();
				if( matches = this.id.match( /^otw_sbm_pcm_shortcode_([0-9]+)_([0-9]+)_([0-9]+)$/ ) ){
					remove_shortcode( matches[1], matches[2], matches[3] );
				};
			};
		});
		previewCont.find( 'ul.ui-sortable' ).sortable( { opacity: 0.6, cursor: 'move', update: function( event, ui ){
			//var order = jQuery(this).sortable("serialize") + '&action=updateRecordsListings';
			var f_li_id = jQuery( this ).find( 'li' )[0].id;
			var f_matches = false;
			if( f_matches = f_li_id.match( /^otm_sbm_sortable_([0-9]+)_([0-9]+)_([0-9]+)$/ ) ){
				
				var all_lis = jQuery( this ).find( 'li' );
				var order = new Array();
				for( var cO = 0; cO < all_lis.length; cO++ ){
					
					var tmp_match = false;
					
					if( tmp_match = all_lis[cO].id.match( /^otm_sbm_sortable_([0-9]+)_([0-9]+)_([0-9]+)$/ ) ){
						order[ order.length ] = tmp_match[3];
					}
				}
				sort_shortcodes( f_matches[1], f_matches[2], order );
			};
			
		} } );
	}
};

otw_sbm_pcm_object.prototype.sort_shortcodes = function( row_id, cell_id, order ){
	
	var tmp_shortcodes = this.rows[ row_id ].cells[ cell_id ].shortcodes;
	this.rows[ row_id ].cells[ cell_id ].shortcodes = new Array();
	
	for( var cO = 0; cO < order.length; cO++ ){
	
		this.rows[ row_id ].cells[ cell_id ].shortcodes[ this.rows[ row_id ].cells[ cell_id ].shortcodes.length ] = tmp_shortcodes[ order[ cO ] ];
	}
	this.set_code();
	this.preview();
};

otw_sbm_pcm_object.prototype.remove_shortcode = function( row_id, cell_id, shortcode_id ){

	var new_codes = [];
	if( this.rows[ row_id ].cells[ cell_id].shortcodes.length ){
		
		for( var shortcode = 0; shortcode < this.rows[ row_id ].cells[ cell_id].shortcodes.length; shortcode++ ){
			if( shortcode != shortcode_id ){
				new_codes[ new_codes.length ] = this.rows[ row_id ].cells[ cell_id].shortcodes[ shortcode ];
			}
		}
	}
	
	this.rows[ row_id ].cells[ cell_id].shortcodes = new_codes;
	
	this.set_code();
	this.preview();
};

otw_sbm_pcm_object.prototype.remove_row = function( row_id ){

	var tmp_rows = [];
	
	for( var row_num = 0; row_num < this.rows.length; row_num++ ){
		
		if( row_id != row_num ){
		
			tmp_rows[ tmp_rows.length ] = this.rows[ row_num ];
		};
	};
	this.rows = tmp_rows;
	this.set_ids();
	this.set_code();
	this.preview();
};


otw_sbm_pcm_object.prototype.set_ids = function(){

	for( var cR in this.rows ){
		this.rows[ cR ].row_id = cR;
		for( var cC in this.rows[ cR ].cells ){
		
			this.rows[ cR ].cells[ cC ].row_id = cR;
			this.rows[ cR ].cells[ cC ].cell_id = cC;
		};
	};
};


otw_sbm_pcm_object.prototype.get_shortcode_type = function( shortcode, param ){

	if( this.shortcodes[ shortcode ] ){
		
		return this.shortcodes[ shortcode ][param];
		
	}else{
		for( var i_shortcode in this.shortcodes ){
		
			if( this.shortcodes[ i_shortcode ].children && this.shortcodes[ i_shortcode ].children[ shortcode ] ){
				
				return this.shortcodes[ i_shortcode ].children[ shortcode ][ param ];
			}
		}
	}
};

otw_sbm_pcm_object.prototype.preview = function(){

	var html = '<div>';
	
	for( var cR = 0; cR < this.rows.length; cR++ ){
		
		var cell_codes = new Array();
		html = html + '<table width="100%" class="otw_sbm_pcm_row">';
		
		html = html + '<tr><td class="row_action" colspan="' + this.rows[ cR ].total_cells + '" ><div id="otw_sbm_pcm_rr_' + cR + '" class="otw_sbm_pcm_rr"></div></td></tr>';
		html = html + '<tr>';
		
		for( var cC = 0; cC < this.rows[ cR ].cells.length; cC++ ){
			cell_codes[ cC ] = this.rows[ cR ].cells[ cC ].get_code( this.rows[ cR ].total_cells );
			
			html = html + cell_codes[cC][0];
		};
		html = html + '</tr>';
		html = html + '<tr>';
		for( var cC = 0; cC < this.rows[ cR ].cells.length; cC++ ){
			html = html + cell_codes[cC][1];
		}
		html = html + '</tr>';
		html = html + '</table>';
	};
	
	html = html + '</div>';

	this.previewCont.html( html );
	
	this.init_content_actions();
};

function otw_sbm_pcm_row(){

	this.code = '';
	
	this.row_id = 0;
	
	this.total_cells = 0;
	
	this.cells = [];
};
otw_sbm_pcm_row.prototype.create = function( row_code, row_id ){
	
	this.code = row_code;
	
	this.row_id = row_id;
	
	var matches = this.code.match( /\[([a-z\_^[]+)]/gi );
	
	if( !matches ){
		return false;
	}
	
	if( !this.total_cells  ){
		
		var m_parts = matches[0].replace('[sbm_','').replace(']','').split( '_' );
		
		if( !m_parts ){
			return;
		}
		
		switch( m_parts[0] ){
			case 'onecol': 
					this.total_cells = 1;
				break;
			case 'twocol': 
					this.total_cells = 2;
				break;
			case 'threecol': 
					this.total_cells = 3;
				break;
			case 'fourcol': 
					this.total_cells = 4;
				break;
			case 'fivecol': 
					this.total_cells = 5;
				break;
			case 'sixcol': 
					this.total_cells = 6;
				break;
			default:
					alert( 'Invalid number of columns' );
					return false;
				break;
		}
	}
	
	for( var match_key = 0; match_key < matches.length; match_key++ ){
		this.cells[ this.cells.length ] = new otw_sbm_pcm_cell( matches[ match_key ], this.row_id, this.cells.length );
	};
	
	return true;
};

function otw_sbm_pcm_cell( cell_tag, row_id, cell_id ){

	var cell_tag = cell_tag.replace( '[sbm_', '' );
	cell_tag = cell_tag.replace( ']', '' );
	
	this.tag = cell_tag;
	
	this.row_id = row_id;
	
	this.cell_id = cell_id;
	
	this.shortcodes = [];
	
	var cell_name_parts = cell_tag.split( '_' );
	
	this.colspan = 1;
	
	this.content = '&nbsp;';

	switch( cell_name_parts[1] ){
		case 'one': 
				this.colspan = 1;
			break;
		case 'two': 
				this.colspan = 2;
			break;
		case 'three': 
				this.colspan = 3;
			break;
		case 'four': 
				this.colspan = 4;
			break;
		case 'five': 
				this.colspan = 5;
			break;
		case 'six': 
				this.colspan = 6;
			break;
	};

};

otw_sbm_pcm_cell.prototype.add_shortcode = function( shortcode, shortcode_name ){
	
	var matches = '';
	
	if( matches = shortcode.match( /\[\/([a-zA-Z\_]+)\]/ ) ){
		
		var shortcodekey = this.shortcodes.length;
		switch( matches[1] ){
		
			default:
					this.shortcodes[ shortcodekey ] = {
						type: matches[1],
						code: shortcode,
						name: shortcode_name
					};
				break;
		}
	}else if( matches = shortcode.match( /^\[otw_is sidebar\=(.*)\]$/ ) ){
		
		var shortcodekey = this.shortcodes.length;
		this.shortcodes[ shortcodekey ] = {
		
			type: 'otw_sidebar',
			code: shortcode,
			name: shortcode_name
		};
		
	};
	return true;
};

otw_sbm_pcm_cell.prototype.get_code = function( total_cells ){


	var cell_width = 100 / total_cells;
	
	var code_array = new Array();
	
	code_array[ 0 ] = '<td class="cell_shortcodes" valign="top"';
	code_array[ 1 ] = '<td class="cell_actions" valign="top"';
	if( this.colspan > 1 ){
		code_array[ 0 ] = code_array[ 0 ] + ' colspan="' + this.colspan + '" ';
		code_array[ 1 ] = code_array[ 1 ] + ' colspan="' + this.colspan + '" ';
	};
	code_array[ 0 ] = code_array[ 0 ] + ' width="' + ( cell_width * this.colspan ) + '%"';
	code_array[ 0 ] = code_array[ 0 ] + '>';
	code_array[ 1 ] = code_array[ 1 ] + '>';
	
	code_array[ 0 ] = code_array[ 0 ] + '<ul class="ui-sortable">';
	
	if( this.shortcodes.length ){
		var count_codes = 0;
		
		for( var shortcode = 0; shortcode < this.shortcodes.length; shortcode++ ){
		
			code_array[ 0 ] = code_array[ 0 ] + '<li id="otm_sbm_sortable_' + this.row_id + '_'+ this.cell_id + '_' + count_codes + '"><div class="otw_sbm_pcm_shortcode otw_sbm_pcm_shortcode_' + this.shortcodes[ shortcode ].type + '" >';
			code_array[ 0 ] = code_array[ 0 ] + '<div id="otw_sbm_pcm_shortcode_' + this.row_id + '_'+ this.cell_id + '_' + count_codes + '" class="otw_sbm_pcm_shortcode_remove"></div>';
			code_array[ 0 ] = code_array[ 0 ] + '<div class="otw_sbm_pcm_shortcode_text">' + this.shortcodes[ shortcode ].name + '</div>';
			code_array[ 0 ] = code_array[ 0 ] + '</div></li>';
			count_codes++;
		}
	}else{
		code_array[ 0 ] = code_array[ 0 ] + this.content;
	}
	
	code_array[ 1 ] = code_array[ 1 ] + '<table width="100%"><tr><td>';
	code_array[ 1 ] = code_array[ 1 ] + '<div class="otw_sbm_pcm_add_action" id="otw-sbm-pcm-add-' + this.row_id + '-' + this.cell_id + '">' + jQuery( '#otw_sbm_pcm_texts_add_item' ).html() + '</div>';
	code_array[ 1 ] = code_array[ 1 ] + '</td><td>';
	code_array[ 1 ] = code_array[ 1 ] + '<div class="otw_sbm_pcm_cell_size">' + this.colspan + '/' + total_cells + '</div>';
	code_array[ 1 ] = code_array[ 1 ] + '</td></tr></table>';
	code_array[ 1 ] = code_array[ 1 ] + '</td>';
	
	code_array[ 0 ] = code_array[ 0 ] + '</ul></td>';
	
	return code_array;
};

function otw_sbm_init_column_dialog(){
	var column_dialog = new otw_sbm_column_dialog();
};

function otw_sbm_column_dialog(){

	this.selected_columns = new Array();
	
	this.column_names = new Array( '','one', 'two', 'three', 'four', 'five', 'six' );
	
	this.columnSelector = jQuery( '#otw_sbm_number_columns' );
	
	this.selectedBoard = jQuery( '#otw_sbm_selected' );
	
	this.removeSelectedButton = jQuery( '#otw_sbm_remove_selected' );
	
	this.bContainer = jQuery( '#otw_sbm_column_buttons' );
	
	with( this ){
		removeSelectedButton.click( function(){
			remove_last_selected();
		} );
		columnSelector.change( function(){
			columnSelector.parent().find( 'span' ).html( this.options[ this.selectedIndex ].text );
			setup_buttons( Number( this.value )  );
		} );
		jQuery( '#otw-sbm-pcm-btn-cancel').click( function(){
			tb_remove();
		} );
		jQuery( '#otw-sbm-pcm-btn-insert').click( function(){
			var shortcode = get_shortcode();
			if( shortcode != -1 ){
				if( otw_sbm_pcm.add_row( shortcode ) > -1 ){
					otw_sbm_pcm.set_code();
					otw_sbm_pcm.preview();
					tb_remove();
				};
			}
		} );
	}
	jQuery( '#TB_ajaxContent' ).css( 'width', '670' );
	
};
otw_sbm_column_dialog.prototype.get_shortcode = function(){
	
	var total_cols = this.columnSelector.val();
	
	var selected_cols = 0;
	
	var code_prefix = this.column_names[ total_cols ] + 'col';
	
	var code = '';
	
	for( var cR = 0; cR < this.selected_columns.length; cR++ ){
		
		selected_cols = selected_cols + this.selected_columns[ cR ];
		
		code = code + '[sbm_' + code_prefix + '_' + this.column_names[ this.selected_columns[ cR ] ];
		
		if( ( cR + 1 ) == this.selected_columns.length ){
			code = code + '_last';
		}
		
		code = code + ']';
		code = code + 'Column ' + this.selected_columns[ cR ] + '/' + total_cols;
		
		code = code + '[/sbm_' + code_prefix + '_' + this.column_names[ this.selected_columns[ cR ] ];
		
		if( ( cR + 1 ) == this.selected_columns.length ){
			code = code + '_last';
		}
		
		code = code + ']';
	};
	if( total_cols != selected_cols ){
		jQuery( '#otw_sbm_pcm_insert_error' ).show();
		return -1;
	};
	return code;
};
otw_sbm_column_dialog.prototype.setup_buttons = function( number_columns ){

	with( this ){
		
		bContainer.html( '' );
		
		var bSize = 340 / number_columns;
		
		for( var cN = 1; cN <= number_columns; cN++  ){
			
			var input = jQuery( '<input type="button" style="width: ' + bSize * cN + 'px;" value="' + cN + '/' + number_columns + '" name="' + cN + '" class="otw_sbm_column_button" />' );
			input.click( function(){ set_selected( this ) } );
			bContainer.append( input );
		}
		
		selected_columns = new Array();
		display_selected();
	}
}

otw_sbm_column_dialog.prototype.set_selected = function( button ){

	var c_number = Number( jQuery( button ).attr( 'name' ) );
	
	var total_cols = this.columnSelector.val();
	var total_selected = 0;
	
	for( var cS = 0; cS < this.selected_columns.length; cS++ ){
		total_selected = total_selected + this.selected_columns[cS];
	}
	if( total_cols >= ( total_selected + c_number ) ){
		this.selected_columns[ this.selected_columns.length ] = c_number;
		this.display_selected();
	};
};

otw_sbm_column_dialog.prototype.display_selected = function(){
	
	var s_text = '';
	var total_selected = 0;
	var total_cols = this.columnSelector.val();
	
	var total_size = 340 - ( this.selected_columns.length * 4 );
	var bSize = total_size / total_cols;
	
	for( var cS = 0; cS < this.selected_columns.length; cS++ ){
		
		s_text = s_text + '<div style="width: '+ bSize * this.selected_columns[cS] +'px;">&nbsp;' + this.selected_columns[cS] + '/' + total_cols + '<a href="javascript:;" class="otw_sbm_pcm_rem_column" id="cl_' + cS  + '"><span>X</span></a></div>';
		
		total_selected = total_selected + this.selected_columns[cS];
	}
	
	var left = total_cols - total_selected;
	
	this.bContainer.find( 'input' ).each( function(){
		
		var input = jQuery( this );
		
		if( Number( input.attr( 'name' ) ) > left ){
			input.attr( 'disabled', 'disabled' );
		}else{
			input.removeAttr( 'disabled' );
		}
		
	});
	this.selectedBoard.html( s_text );
	with( this ){
		selectedBoard.find( 'div a.otw_sbm_pcm_rem_column' ).click( function(){
			
			var matches = false;
			if( matches = this.id.match( /^cl_([0-9]+)$/ ) ){
				remove_selected( matches[1] );
			};
		});
	}
	
	jQuery( '#otw_sbm_pcm_insert_error' ).hide();
};
otw_sbm_column_dialog.prototype.remove_selected = function( remove_number ){
	
	var tmp_array = this.selected_columns;
	
	this.selected_columns = new Array();
	
	for( var cS = 0; cS < tmp_array.length; cS++ ){
		
		if( cS != remove_number ){
			this.selected_columns[ this.selected_columns.length ] = tmp_array[ cS ];
		};
	};
	
	this.display_selected();
};
otw_sbm_column_dialog.prototype.remove_last_selected = function(){
	
	var tmp_array = this.selected_columns;
	
	this.selected_columns = new Array();
	
	for( var cS = 0; cS < tmp_array.length; cS++ ){
		
		if( ( cS + 1 ) < tmp_array.length ){
		
			this.selected_columns[ this.selected_columns.length ] = tmp_array[ cS ];
		};
	};
	
	this.display_selected();
};
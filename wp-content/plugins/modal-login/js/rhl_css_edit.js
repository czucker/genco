
rhl_jQuery(document).ready(function($){	
	//-- bootstrap accordion
	$('.accordion-body').on('show',function(){
		$(this).parent().find('a.accordion-toggle').addClass('open');
	});
	$('.accordion-body').on('hidden',function(){
		$(this).parent().find('a.accordion-toggle').removeClass('open');	
	});
	/* if clicking on the tab is being blocked by some other mysterius plugin, try commenting out this lines.
	$(".accordion-toggle").click(function(e){
		var target_id = $(this).attr('href');
		if( $(this).hasClass('open') ){
			$(target_id).collapse('hide');
		}else{
			$(target_id).collapse('show');
		}
	});		
	*/	
	//-- minicolors ----
	$('.input-minicolors').each(function(i,o){
		var opacity = $(o).hasClass('with-opacity')?true:false;
		$(o).miniColors({
			opacity: opacity,
			change: function(e){
				$(this).trigger('change');
			}
		});	
	});	
	//--- tooltip
	//not working.
	//$('.bootstrap-tooltip').tooltip({position:'fixed'});
		
	//save button
	$('#btn-save').click(function(e){
		css_save(e);
	});
	
	//generic clear button
	$('.btn_clear_generic').click(function(e){
		$(this).parents('.input-field').find('.input-field-input').each(function(i,inp){	
			$(this).val('')
				.trigger('change')
				.trigger('fieldCleared')
			;
		});
	});
	
	//clear gradient button
	$('.btn_clear_gradient').click(function(e){
		$(this).parent()
			.find('input.sub_colorpicker_gradient')
				.val('')
				.css('background-color','#eee')
				.end()
			.find('input.colorpicker_gradient').val('').trigger('change').end()
		;
	});
	
	//text shadow clear button
	$('.btn_clear_text_shadow').click(function(e){
		$(this).parent().parent()
			.find('input.text-shadow-field').val('').end()
			.find('input.colorpicker_textshadow').val('').trigger('change').end()
		;
	});
	
	//image url clear
	$('.btn_clear_image_url').click(function(e){
		var _parent = $(this).parent().parent().parent();
		_parent.find('.rhl_image_uploader').val('').trigger('change');
		_parent.find('.rhl-image-upoader-helper').addClass('helper-closed');
	});
	//----------------
	
	//--
	$('#rh-modal-login').on('shown.bs.modal',function(){
		fill_default_values();
	});
	//$('#rh-modal-login').trigger('shown');
	
	$('#btn-reset-css').on('click',function(){
		restore_default_values();	
	});
	//----
	$('.pop_rangeinput').each(function(i,inp){
		var sel 	= $(inp).attr('data-css-selector');
		var arg 	= $(inp).attr('data-css-property');
		var unit	= $(inp).attr('data-input-unit');
		var id = $(inp).attr('id');
		
		$(inp).pop_rangeinput();
		if(sel)$('#'+id).attr('data-css-selector',sel);
		if(arg)$('#'+id).attr('data-css-property',arg);
		if(unit)$('#'+id).attr('data-input-unit',unit);	
	});
	$('.rhlogin-edit .handle').mousedown(function(e){
		$(this).parent().parent().find('.pop_rangeinput').focus();
	});
	
	$('.pop_rangeinput').bind('onSlide',function(e,value){
		var sel = $(this).attr('data-css-selector');
		var arg = $(this).attr('data-css-property');
		var unit = $(this).attr('data-input-unit');
		
		var val = normalize_css_value( arg, $(sel).css(arg) );
		//var new_val = normalize_input_value( this, arg, $(this).val() );
		var new_val = normalize_input_value( this, arg, value );
		new_val = unit?new_val + unit:new_val;
		
		$(sel).css(arg, new_val);
	});	
		
	//----
	
	$('.real-time').on('change',function(e){
		set_css_from_input_value(this);
		return true;
	});
	
	//-- gradient sub field change
	$('.sub_colorpicker_gradient').change(function(e){
		var colors = [];
		var last_val = '#ffffff';
		$(this).parents('.input-field').find('.sub_colorpicker_gradient').each(function(i,o){
			var val=$(o).val();
			if(val){
				//add opacity
				var opacity = $(o).miniColors('opacity');
				opacity = opacity>=0&&opacity<=1?opacity:1;
				if(opacity<1){
					var tiny = tinycolor(val);
					//var tiny = tinycolor(tiny.toRgbString());//convert internally to rgb.
					tiny.alpha = opacity;					
					if(tiny.ok){	
						val = tiny.toRgbString();				
					}
				}
			}else{
				val = last_val;
				$(o).val(val);
			}
			colors[colors.length]=val;
			last_val=val;
		});
		$(this).parents('.input-field').find('.input-field-input')
			.val( colors.join('|') )
			.trigger('change')
		;
	});
	
	//-- text-shadow sub field change
	$('.text-shadow-field').change(function(e){
		var p = $(this).parent().parent();
		//rgba(0, 0, 0, 0.247059) 0px -0.9090908765792847px 0px
		var arr = [];
		arr[0] = p.find('.text-shadow-h').val();
		arr[0] = arr[0]?arr[0]+'px':'0';  
		arr[1] = p.find('.text-shadow-v').val();
		arr[1] = arr[1]?arr[1]+'px':'0';
		arr[2] = p.find('.text-shadow-b').val();
		arr[2] = arr[2]?arr[2]+'px':'0';
		arr[3] = p.find('.text-shadow-color').val();
		val = arr[3]==''?'':arr.join(' ');
		p.find('.colorpicker_textshadow')
			.val(val)
			.trigger('change')
		;
	});
	
	//-- image uploader helper
	$('.rhl-image-uploader-helper-trigger').on('click',function(e){
		$(this).parent().parent().parent().find('.rhl-image-upoader-helper').toggleClass('helper-closed');
	});
	
	//-- image uploader change
	$('.rhl_image_uploader').on('change',function(e){
		var val = $(this).val();
		var el = $(this).parent().find('.dropdown-content img');
		var status = $(this).parent().find('.dropdown-content .dropdown-status');
		var grad = $(this).parent().find('.dropdown-content .dropdown-gradient');
		if( ''==val ){
			el.attr('src','').hide();
			status.show();
			grad.hide();
		}else if( isURL(val) ){
			el.attr('src',val).show();			
			status.hide();
			grad.hide();
		}else{
			el.attr('src','').hide();
			status.hide();
			grad.show();
			var tiny = tinycolor(val);
			if(tiny.ok){
				//;
				var sel = $(this).attr('data-css-selector');
				var arg = $(this).attr('data-css-property');
				grad.css(arg, $(sel).css(arg) );
			}
		}		
	});
	
	//-- background_image control
	$('.input-field-bakground_image').bind('UpdateChildControls',function(e){	
		var inp = this;
		var id = $(inp).attr('id');
		var val = $(inp).val();		
		var arr = val.split('|');
		if(arr.length==2){
			set_colorpicker_color( '#'+ id + '-start', arr[0]);
			set_colorpicker_color( '#'+ id + '-end', arr[1]);		
			$(inp).parents('.input-field').find('a.rhl-image-gradient')
				.tab('show')
			;
		}
	});
		
	//--
	/*
	$('.uploaded_image_url_thumb').on('click',function(e){					
		var sel = $(this).data('click_target');
		$(sel).val( $(this).data('click_source') ).trigger('change');						
	});
	*/
	
	//-- background_size control
	$('.input-field-input.background_size').bind('UpdateChildControls',function(e){
		var inp = this;
		var id = $(inp).attr('id');
		var val = $(inp).val();		
		var holder = $(this).parents('.input-field');
		if( holder.find('.bgsize_options option[value="' + val + '"]').length > 0 ){
			holder.find('.bgsize_options').val( val );
			holder.find('.bgsize_value').val('');
		}else{
			var arr = val.match(/([0-9.]*)(%|px)/gi);
			if(arr && arr.length>0){
				$('.bgsize_value').val('');
				$.each(arr,function(i,val){
					if(i>1)return;
					var brr = val.match(/([0-9.]*)(%|px)/i);
					if(i==0){
						if( brr[2] && brr[2]=='%' ){
							holder.find('.bgsize_options').val( 'percentage' );
						}else if( brr[2] && brr[2].toLowerCase()=='px' ){
							holder.find('.bgsize_options').val( 'length' );
						}
						holder.find('.bgsize_h').val( Math.round(brr[1]*100)/100 );
					}else{
						holder.find('.bgsize_w').val( Math.round(brr[1]*100)/100 );
					}
				});
			}
		}
	
		switch( holder.find('.bgsize_options').val() ){
			case '':
			case 'auto':
			case 'cover':
			case 'contain':
				holder.find('.bgsize_value_holder').stop().fadeOut();
				break;
			default:
				holder.find('.bgsize_value_holder').stop().fadeIn();
		}

	});
	$('.bgsize_value').change(function(e){
		$(this).parents('.input-field').find('.bgsize_options').trigger('change');
	});
	$('.bgsize_options').change(function(e){	
		var holder = $(this).parents('.input-field');
		var val = $(this).val();
		var sel = $(this).data('target-selector');
		var h = holder.find('.bgsize_h').val();
		var w = holder.find('.bgsize_w').val();
		var str = '';
		var unit = '';
		switch(val){
			case '':
			case 'auto':
			case 'cover':
			case 'contain':
				holder.find('.bgsize_value_holder').stop().fadeOut();
				$(sel).val(val).trigger('change');
				break;
			case 'percentage':
			case 'length':
				unit = val=='percentage'?'%':'px';
				str = h==''? str : str + h + unit;
				str = w==''? str : str + ' ' + w + unit;
				$(sel).val(str).trigger('change');
				holder.find('.bgsize_value_holder').stop().fadeIn();
				break;	
			default:
				holder.find('.bgsize_value_holder').stop().fadeIn();
				$(sel).val('');
		}
		switch(val){
			case 'length':
				$('.bgsize-unit').html('px');
				break;
			case 'percentage':
				$('.bgsize-unit').html('%');
				break;
		}
	});
	//-- end bgsize control
	
	//-- hide loading
	$('.rhl_loading').stop().fadeOut();
	
	//-- color_or_something else select
	$('.alternate-color-values').on('change',function(e){
		var sel = $(this).attr('data-target-selector');
		var val = $(this).val();
		if('color'==val){
			var colorpicker_sel = sel + '-color';
			$(colorpicker_sel).trigger('change');
			//--
			$(this).parents('.input-field').find('.input-minicolors-hold').fadeIn();
		}else{
			$(sel).val(val)
				.trigger('change')
			;
			//--
			$(this).parents('.input-field').find('.input-minicolors-hold').fadeOut();
		}
	});
	
	$('.color_or_something_else').bind('UpdateChildControls',function(e){
		var value = $(this).val();
		if( $(this).parents('.input-field').find('.color-or-something-options option[value="' + value + '"]').length > 0 ){
			//its an alternate value ie transparent or none
			$(this).parents('.input-field').find('.alternate-color-values')
				.val(value)
				.trigger('change')
			;
		}else{
			var sel = '#' + $(this).attr('id') + '-color';		
			set_colorpicker_color(sel,value);
			$(this).parents('.input-field').find('.alternate-color-values')
				.val('color')
				.trigger('change')
			;
		}
	});
	
	$('.input-field-color_or_something_else .input-minicolors').change(function(e){
		var options_sel = $(this).attr('data-target-selector') + '-options';
		if( 'color'==$(options_sel).val() ){
			var sel = $(this).attr('data-target-selector');	
			$(sel).val( get_miniColors_color(this) )
				.trigger('change')
			;
		}
		return true;
	});
	//-- end color_or_something_else
	
	$('.sup-input-font-helper').click(function(e){
		var sel = $(this).data('input-parent');
		if( !$(this).hasClass('active') ){
			$(sel).val( $(sel).data('selected-value') )
				.trigger('change')
			;
		}else{
			$(sel).val( 'normal' )
				.trigger('change')
			;
		}
		return false;
	});
	
	$('.sup-input-font').change(function(e){
		var sel = '#'+$(this).attr('id')+'-helper';
		var val = $(this).val();
		val = val.replace(' ','');
		if( val==$(this).data('selected-value') ){
			$(sel).addClass('active');
		}else{
			$(sel).removeClass('active');
		}
	});
	
	$('.btn-collapse').click(function(e){
		var sel = '#rhl-css-form';
		if( $(sel).is(':visible') ){
			var left = parseInt(($(sel).width()+20)) * -1;
			$(sel)
				.stop()
				.animate({left:left},'fast',function(){
					$(this).hide();
				})
			;
			$(this).twbutton('loading');
		}else{
			$(sel)
				.stop()
				.show()
				.animate({left:0},'fast')
			;
			$(this).twbutton('reset');
		}
	});
	
	$('#btn-remove-css').click(function(e){
		css_remove();
	});

	load_saved_settings();
	
	$('#btn-add-backup').click(function(e){
		css_backup();
	});
	
	$('.rhl-backup-item a').on('click',function(e){
		css_restore(this);
	});
	
	$('#btn-restore-backup').on('click',function(e){
		css_restore();
	});
});



function get_miniColors_color(inp){
	var val = rhl_jQuery(inp).val();
	if(val=='#')return '';
				var opacity = rhl_jQuery(inp).miniColors('opacity');
				opacity = opacity>=0&&opacity<=1?opacity:1;
				if(opacity<1){
					var tiny = tinycolor(val);
					//var tiny = tinycolor(tiny.toRgbString());//convert internally to rgb.
					tiny.alpha = opacity;				
					if(tiny.ok){
						val = tiny.toRgbString();				
					}
				}
	return val;
}

if(!uploaded_files){
	var uploaded_files = [];//-- upload list
}

var default_values = [];
function fill_default_values(){
	var fill_default_values = default_values.length>0?false:true;
	rhl_jQuery(document).ready(function($){
		$('.default-value-from-css').each(function(i,inp){
			if( $(inp).attr('data-css-selector')!='' ){
				var sel = $(inp).attr('data-css-selector');
				var arg = $(inp).attr('data-css-property');
				var val = normalize_css_value( inp, arg, get_css_value(inp,sel,arg) );			
				if(fill_default_values){
					default_values[default_values.length] = {
						'sel':sel,
						'arg':arg,
						'val':val
					};
				}
				//-------colorpicker		
				if( $(inp).is('.colorpicker-input-field') ){
					$(inp)
						.val(val)
						.trigger('change')
					;							
					set_colorpicker_color( '#'+$(inp).attr('id') ,val);	
				}	
				//-------gradient color picker	
				if( val && $(inp).is('.colorpicker_gradient') ){
					var arr = val.split('|');
					if(arr.length==2){
						set_colorpicker_color( '#'+$(inp).attr('id') + '-start', arr[0]);
						set_colorpicker_color( '#'+$(inp).attr('id') + '-end', arr[1]);					
					}else{
						$('#'+$(inp).attr('id') + '-start').val('');
						$('#'+$(inp).attr('id') + '-end').val('');			
					}
				}
				//-------- set text-shadow sub-fields
				if( val && $(inp).is('.colorpicker_textshadow') ){
					var tiny = tinycolor(val);			
					if(tiny.ok){
						var id = $(inp).attr('id');
						str = val.replace(tiny.m,'');
						var sel1 = '#'+ id + '-color';
						var color = tiny.toHexString();
						set_colorpicker_color(sel1,color);
						str = $.trim(val.replace(tiny.m,''));				
						var arr = str.split(' ');	
						if(arr.length==3){
							var sel1 = '#'+ id + '-h';
							var sel2 = '#'+ id + '-v';
							var sel3 = '#'+ id + '-b';	
							var sel4 = '#'+ id + '-color';				
							$(sel1).val( (Math.ceil(parseFloat(arr[0])*10))/10 );
							$(sel2).val( (Math.ceil(parseFloat(arr[1])*10))/10 );
							$(sel3).val( (Math.ceil(parseFloat(arr[2])*10))/10 );
							$(sel4).val( color );
							$(sel1).trigger('change');
						}
					}	
				}
				if( $(inp).is('select') ){
					val = val?val:'';
					$(inp).val(val)
						.trigger('change')
					;
				}		

				if( $(inp).is('.rhl_image_uploader') ){
					$(inp)
						.trigger('change')
					;
				}
				
				if( $(inp).val()=='' ){
					val = val!=undefined?val:'';
					$(inp).val(val)
						.trigger('change')
					;
				}else if( $(inp).is('.pop_rangeinput') ){
					var api = $(inp).data('pop_rangeinput');
					api.setValue(val);
					$(inp).trigger('change');
				}

				$(inp).trigger('UpdateChildControls');
			}
		});	
	});
}

function set_colorpicker_color(sel,color){	
	if( rhl_jQuery(sel).hasClass('input-minicolors') ){
		var opacity = 1;
		var tiny = tinycolor(color);
		if(tiny.ok){
			opacity = tiny.alpha;
			hexcolor = tiny.toHexString();
			rhl_jQuery(sel).miniColors('value',hexcolor);
			rhl_jQuery(sel).miniColors('opacity',opacity);
		}
	}else if( rhl_jQuery(sel).hasClass('farbtastic-holder') ){
		//farbtastic
		sel = sel + '-farbtastic';
		var picker = rhl_jQuery.farbtastic(sel);
		picker.setColor(color);		
	}
}

function restore_default_values(){
	rhl_jQuery(document).ready(function($){
		if(default_values.length>0){
			$.each(default_values,function(i,values){
				var sel = values.sel;
				var arg = values.arg;
				var val = values.val;
				var inp = $('[data-css-selector="'+sel+'"][data-css-property="'+arg+'"]')[0];			
				//-------		
				$(inp).val(val)
					.trigger('change')
				;			
			});
			fill_default_values();
		}			
	});
}

function css_save(e){
	rhl_jQuery(document).ready(function($){
		$('.btn-save-settings').twbutton('loading');
		var data = [];
		$('.input-field-input').each(function(i,inp){
			var sel = $(this).attr('data-css-selector');
			var arg = $(this).attr('data-css-property');
			var unit = $(this).attr('data-input-unit');
			var val = $(this).val();
			
			var subset = get_array_of_css_blocks(sel,inp,arg,val);
			if(subset.length>0){
				data = data.concat(subset);
			}
		});
		
		var pop = [];
		$('.input-pop-option').each(function(i,inp){
			pop[pop.length] = {
				'name': $(inp).attr('name'),
				'value': $(inp).val()
			};
		});
		
		var arg = {
			action: 'rhl_save_css',
			data: data,
			pop: pop,
			default_values: default_values
		};	

		$.post(rhl_ajax_url,arg,function(data){

			$('.btn-save-settings').twbutton('reset');
			if(data.R=='OK'){
				var _msg = '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
			}else if(data.R=='ERR'){
				var _msg = '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
			}else{
				var _msg = '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>'+_unexpected_error+'</div>';
			}
			$('.ajax-result-messages')
				.empty()
				.append(_msg)
			;			
		},'json');

	});
}

function css_remove(){
	rhl_jQuery(document).ready(function($){
		$('.rhl_loading').stop().fadeIn();
		
		var arg = {
			action: 'rhl_remove_css'
		};
		$.post(rhl_ajax_url,arg,function(data){
			$('.rhl_loading').stop().fadeOut('fast');
			if(data.R=='OK'){
				var _msg = '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
				location.reload(true);
			}else if(data.R=='ERR'){
				var _msg = '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
			}else{
				var _msg = '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>'+_unexpected_error+'</div>';
			}
			$('.ajax-result-messages')
				.empty()
				.append(_msg)
			;			
		},'json');		
	});
}

function css_backup(){
	rhl_jQuery(document).ready(function($){
		$('#btn-add-backup').twbutton('loading');
		
		var arg = {
			action: 'rhl_backup_css',
			label: $('#rhl_backup_name').val()
		};
		$.post(rhl_ajax_url,arg,function(data){
			$('#btn-add-backup').twbutton('reset');
			if(data.R=='OK'){
				var _msg = '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
				load_saved_settings();
			}else if(data.R=='ERR'){
				var _msg = '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
			}else{
				var _msg = '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>'+_unexpected_error+'</div>';
			}
			$('#add_backup_msg')
				.empty()
				.append(_msg)
			;			
		},'json');		
	});	
}

function css_restore(){
	rhl_jQuery(document).ready(function($){
		$('#btn-restore-backup').twbutton('loading');
		var label = $('input[name=rhl_css_saved]:checked').val();
		label = label?label:'';
		
		var arg = {
			action: 'rhl_restore_css',
			label: label
		};
		$.post(rhl_ajax_url,arg,function(data){
			$('#btn-restore-backup').twbutton('reset');
			if(data.R=='OK'){
				var _msg = '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
				location.reload(true);
			}else if(data.R=='ERR'){
				var _msg = '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
			}else{
				var _msg = '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>'+_unexpected_error+'</div>';
			}
			$('#add_backup_msg')
				.empty()
				.append(_msg)
			;			
		},'json');		
	});	
}


function load_saved_settings(){
	rhl_jQuery(document).ready(function($){
		var arg = {
			action: 'rhl_saved_list'
		};	
		$.post(rhl_ajax_url,arg,function(data){
			if(data.R=='OK'){
				render_saved_settings(data.DATA);
			}
		},'json');
	});		
}

function render_saved_settings(data){
	rhl_jQuery(document).ready(function($){
		$('.saved_settings_list_cont')
			.empty()
		;
		
		if(data.length>0){
			$('.saved_settings_list_cont').show();
			$('.empty_saved_settings').hide();
			$('#btn-restore-backup').show();
			$.each(data,function(i,d){

				$('<label class="radio"><input type="radio" name="rhl_css_saved" value="' + d.name + '">' + d.name + '</label>')
					.appendTo( $('.saved_settings_list_cont') )
				;
			});
		}else{
			$('.saved_settings_list_cont').hide();
			$('.empty_saved_settings').show();
			$('#btn-restore-backup').hide();
		}
	});		
}

function set_css_from_input_value(inp){
	rhl_jQuery(document).ready(function($){
		var sel = $(inp).attr('data-css-selector');
		var arg = $(inp).attr('data-css-property');

		var blocks = get_array_of_css_blocks(sel,inp,arg,$(inp).val());
		if(blocks.length>0){

			$.each(blocks,function(i,block){
				$.each(block.css,function(j,item){
					$( block.sel ).css( item );
				});
			});
		}
	});
}

function get_array_of_css_blocks(sel,inp,arg,val){
	var ret=[];
	var blocks = [];
	
	blocks[blocks.length]={
		'id':rhl_jQuery(inp).attr('id'),
		'sel':sel,
		'arg':arg,
		'val':val,
		'css':get_css_array(inp,arg,val)
	};
	
	//--- generic derived styles
	try {
		var derived = rhl_jQuery(inp).data('derived');
		var arr = eval(unescape(derived));
		if(arr && arr.length>0){
			rhl_jQuery.each(arr,function(i,o){
				var value_set = false;
				var property_value = '';
				//filter value
				if(o.type=='gradient_darken'){
					var grr = val.split('|');			
					var tiny = tinycolor(grr[1]);
					if(tiny.ok){			
						var alpha = tiny.alpha;			
						color = tinycolor.darken(tiny, o.val ).toRgbString();					
				//add parents opacity
						var tiny = tinycolor(color);
						tiny.alpha = alpha;
						
						color = tiny.toRgbString();
						//---
						property_value = color;									
						value_set =true;			
					}else{
	
					}
				}
				
				if(value_set){
					var _property = o.arg;
					items=[];					
					for(a=0;a<_property.length;a++){				
						var p = {};
						tpl = _property[a].tpl?_property[a].tpl:'__value__';
						tpl = tpl.replace('__value__',property_value);
						p[ _property[a].name ] = tpl;			
						items[items.length]=p;			
					}								
					blocks[blocks.length]={
						'id':rhl_jQuery(inp).attr('id'),
						'sel':o.sel,
						'arg':arg,
						'val':val,						
						'css':items
					};										
				}
			});		
		}
	}catch(e){
	
	}
	
	return blocks;
}

function get_css_array(inp,arg,val){
	var ret = [];
	//--- special conditions -- todo: put this in some generic procedure.
	if( 'rhl-footer-bg-color'==rhl_jQuery(inp).attr('id') ){
		var tiny = tinycolor(val);
		if(tiny.ok){			
			color = tinycolor.lighten(tiny,10).toRgbString();
			//add parents opacity
			var tiny = tinycolor(color);
			if(rhl_jQuery(inp).data('opacity')){
				tiny.alpha = rhl_jQuery(inp).data('alpha');
			}
			color = tiny.toRgbString();
			//---
			var box_shadow = [
				'-webkit-box-shadow',
				'-moz-box-shadow',
				'box-shadow'
			];
			for(a=0;a<box_shadow.length;a++){
				var o = {};
				o[ box_shadow[a] ] = 'inset 0 1px 0 ' + color;
				ret[ret.length]=o;
			}
		}		
	}

	//---
	if(arg=='background-color'){
		//-- TODO if color with opacity, add solid colors and use the element opacity
	}
	
	//---
	if(arg=='background-image'){
		if( !isURL(val) ){
			var arr = val.split('|');
			if(arr.length==2){
				var background_image = [
					'-webkit-gradient(linear, left top, left bottom, color-stop(0, _c1), color-stop(1, _c2))',/* Webkit (Safari/Chrome 10) */ 
					'-webkit-linear-gradient(top, _c1 0%, _c2 100%)',/* Webkit (Chrome 11+) */ 
					'-ms-linear-gradient(top, _c1 0%, _c2 100%)',/* IE10 Consumer Preview */ 
					'-o-linear-gradient(top, _c1 0%, _c2 100%)',/* Opera */ 
					'linear-gradient(to bottom, _c1 0%, _c2 100%)',/* W3C Markup, IE10 Release Preview */ 
					'-moz-linear-gradient(top, _c1 0%, _c2 100%)'/* Mozilla Firefox */ 
				];
				
				for(a=0;a<background_image.length;a++){
					var o = {};	
					var val = background_image[a];
					val = val.replace("_c1",arr[0]);
					val = val.replace("_c2",arr[1]);		
					o[arg]=val;					
					ret[ret.length]=o;
				}
				/*ie9 todo transparency support or pre9?*/
				
				
				var iecolor1 = get_hex_color_with_opacity(arr[0]);
				var iecolor2 = get_hex_color_with_opacity(arr[1]);
				ret[ret.length]={
					'filter':'progid:DXImageTransform.Microsoft.gradient(startColorstr='+iecolor1+', endColorstr='+iecolor2+')'
				}
				/*
				ret[ret.length]={
					'-ms-filter':'progid:DXImageTransform.Microsoft.Alpha(Opacity=50)'
				}
				*/
				
				/* this interferes with double background effects.
				ret[ret.length]={
					'background-color':arr[1]
				}	
				*/		
				return ret;
			}
		}
	}
	//---
	val = normalize_input_value(inp,arg,val);
	var o = {};
	o[arg]=val;
	ret[ret.length]=o;
	return ret;
}

function get_css_value( inp, sel, arg ){
	var value = rhl_jQuery(sel).css(arg);
	return value||'';
}

function normalize_input_value(inp,arg,val){
	if(arg=='background-image'||arg=='background-image'){
		if(isURL(val)){
			if(val==''||val=='none'){
				return 'none';
			}else{	
				return 'url(' + val + ')';
			}		
		}else{
			return '';
		}
	}

	switch(arg){
		case 'width':
		case 'height':
		case 'margin-top':
		case 'min-height':
		case 'line-height':
		case 'font-size':
		case 'border-top-left-radius':
		case 'border-top-right-radius':
		case 'border-bottom-left-radius':
		case 'border-bottom-right-radius':			
			val = get_value_with_unit(val,inp);
	}
		
	var blank_value = rhl_jQuery(inp).attr('data-blank-value');
	if(blank_value && ''==val){
		return blank_value;
	}

	if( rhl_jQuery(inp).hasClass('miniColors') ){
		var opacity = rhl_jQuery(inp).miniColors('opacity');
		if( opacity && opacity<1 ){
			var tiny = tinycolor(val);
			if(tiny.ok){
				tiny.alpha = opacity;
				val = tiny.toRgbString();
			}
		}
	}
	
	return val;
}

function normalize_css_value(inp,arg,val){
	switch(arg){
		case 'width':
		case 'height':
		case 'margin-top':
		case 'min-height':
		case 'font-size':
		case 'line-height':
		case 'border-top-left-radius':
		case 'border-top-right-radius':
		case 'border-bottom-left-radius':
		case 'border-bottom-right-radius':	
			return parseInt(val);
		case 'text-shadow':	
			return val;
		case 'background-image':
			return get_normalized_background_image(val);
		case 'color':
		case 'border-color':
		case 'border-top-color':
		case 'border-bottom-color':
		case 'border-left-color':
		case 'border-right-color':
			return get_normalized_sring_color(val,inp);
		case 'background-color':
			return get_normalized_background_color(val,inp);
		case 'background-position':
			return get_normalized_background_position(val,inp);
	}
	
	
	return val;
}

function get_value_with_unit(str,inp){
	var unit = rhl_jQuery(inp).attr('data-input-unit');
	if(unit && ''!=str){
		str=str+unit;
	}
	return str;
}

function render_uploaded_files(id){
	rhl_jQuery(document).ready(function($){
		//----
		var sel = '#'+id+'-upload-list';
		list = $(sel).val().split("\n"); 
		if( list.length>0 ){
			var tmp=[];
			$.each(list,function(i,item){
				if( item.replace(' ','')=='' )return;
				tmp[tmp.length]=item;
			});
			list=tmp;
		}
		//----		
		var sel = '#'+id+'-uploaded';
		$(sel).empty();
		var cont = '#'+id+'-holder';
		if( list.length==0 ){
			$(cont).find('.rhl-uploaded-images-tab').hide();
			rhl_jQuery(cont).find('.rhl-upload-new').tab('show');
		}else{
			$(cont).find('.rhl-uploaded-images-tab').show();
			//---
			$.each(list,function(i,item){
				var img = $('<img />')
					.attr('src',item)
				;
				
				$('<a></a>')
					.addClass('uploaded_image_url_thumb')
					.data('click_source',item)
					.data('click_target','#'+id)
					.append(img)
					.appendTo(sel)
					.on('click',function(e){					
						var sel = $(this).data('click_target');
						$(sel).val( $(this).data('click_source') ).trigger('change');						
					})
				;	
			});
		}
	});
}	
	
function init_image_uploader(settings){  
	
	render_uploaded_files( settings.id );
	
    rhl_jQuery(document).ready(function($){
      var uploader = new plupload.Uploader(settings);
      uploader.bind('Init', function(up){
        var uploaddiv = $('#'+settings.container);

        if(up.features.dragdrop){
          uploaddiv.addClass('drag-drop');
            $('#'+settings.drop_element)
              .bind('dragover.wp-uploader', function(){ uploaddiv.addClass('drag-over'); })
              .bind('dragleave.wp-uploader, drop.wp-uploader', function(){ uploaddiv.removeClass('drag-over'); });
        }else{
          uploaddiv.removeClass('drag-drop');
          $('#'+settings.drop_element).unbind('.wp-uploader');
        }
      });
      uploader.init();

      // a file was added in the queue
      uploader.bind('FilesAdded', function(up, files){
        var hundredmb = 100 * 1024 * 1024, max = parseInt(up.settings.max_file_size, 10);

        plupload.each(files, function(file){
          if (max > hundredmb && file.size > hundredmb && up.runtime != 'html5'){
            // file size error?

          }else{

          }
        });

        up.refresh();
        up.start();
      });

      	uploader.bind('UploadFile', function(up,file){
			$('.rhl_loading').stop().fadeIn();	
		});
		uploader.bind('FileUploaded', function(up, file, response) {
			if(response.status==200){
				try {
					data = eval("(" + response.response + ')');
					if(data.R=='OK'){
						$('#'+data.ID).val( data.URL ).trigger('change');
						$('#'+data.ID+'-upload-ui').parent().parent().parent().addClass('helper-closed');
						//--
						var sel = '#' + data.ID + '-upload-list';
						$(sel).val( data.UPLOADED );
						//--
						render_uploaded_files( data.ID );
					}else if(data.R=='ERR'){
						var sel = '#'+data.ID + '-msg';
						var _msg = '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
						$(sel).empty().append(_msg);
					}else{
						var sel = '#'+data.ID + '-msg';
						var _msg = '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>'+_unexpected_error+'</div>';
						$(sel).empty().append(_msg);
					}	
					$('.rhl_loading').stop().fadeOut();
					return true;			
				}catch(e){
				
				}
				
			}
			$('.rhl_loading').stop().fadeOut();
			alert('Unknown server response while uploading image');
		});
    });   
}
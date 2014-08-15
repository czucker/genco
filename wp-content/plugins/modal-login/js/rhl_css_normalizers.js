
function get_normalized_background_image(str){
	switch(str){
		case 'none':
			return '';
			//return str;
	}
	//unwrap url.
	arr = str.match(/url\(\"?([^)"]*)\"?\)/i);
	if(arr && arr.length==2 && isURL(arr[1])){
		str = arr[1];
	}
	if(isURL(str)){
		return str;
	}else{
		var colors = [];
		var tiny = tinycolor(str);			
		if(tiny.ok){
			if(tiny.alpha==1){
				colors[colors.length]=tiny.toHexString();
			}else{
				colors[colors.length]=tiny.toRgbString();
			}
			str = str.replace(tiny.m,'');			
			var tiny = tinycolor(str);	
			if(tiny.ok){
				if(tiny.alpha==1){
					colors[colors.length]=tiny.toHexString();
				}else{
					colors[colors.length]=tiny.toRgbString();
				}			
				return colors.join('|');
			}			
		}
	}
	
	return '';
}

function get_normalized_sring_color(str,inp){
	var tiny = tinycolor(str);
	if(tiny.ok){	
		if(tiny.alpha==1){
			return tiny.toHexString();
		}else{
			return tiny.toRgbString();
		}
	}

	return '';
}

function get_normalized_background_color(str,inp){
	if(jQuery(inp).is('.with-alternate-color-value')){
		//value is in dropdown of alternate values.
		if( jQuery(inp).parents('.input-field').find('.alternate-color-value[value="'+str+'"]').length>0 ){
			return str;
		}
	}
	
	var tiny = tinycolor(str);
	if(tiny.ok){	
		if(tiny.alpha==0){
			return 'transparent';
		}else if(tiny.alpha==1){
			return tiny.toHexString();
		}else{
			return tiny.toRgbString();
		}
	}

	return '';	
}

function get_normalized_background_repeat(str,inp){
	switch(str){
		case 'repeat repeat':
			return 'repeat';
		case 'repeat no-repeat':
			return 'repeat-x';
		case 'no-repeat repeat':
			return 'repeat-y';
		case 'no-repeat no-repeat':
			return 'no-repeat';
	}
	return str;
}

function get_normalized_background_position(str,inp){
	switch(str){
		case '0% 0%':
			return 'left top';
		case '0% 50%':
			return 'left center';
		case '0% 100%':
			return 'left bottom';
		case '100% 0%':
			return 'right top';
		case '100% 50%':
			return 'right center';
		case '100% 100%':
			return 'right bottom';
		case '50% 0%':
			return 'center top';
		case '50% 50%':
			return 'center center';
		case '50% 100%':
			return 'center bottom';
	}
	return str;
}

/* */
function get_hex_color_with_opacity(color){
	var tiny = tinycolor(color);
	if(tiny.ok){
		return tiny.toHexOpacityString();
	}
	return null;
}
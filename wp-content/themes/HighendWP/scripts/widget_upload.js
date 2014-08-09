var image_field;
jQuery(document).on('click', 'input.select-image', function(evt){
		image_field = jQuery(this).siblings('.img');
		tb_show('Select Image', 'media-upload.php?type=image&amp;TB_iframe=false');
		return false;
	});
	window.send_to_editor = function(html) {
	imgurl = jQuery("<div>" + html + "</div>").find('img').attr('src');
	image_field.val(imgurl);
	tb_remove();
}
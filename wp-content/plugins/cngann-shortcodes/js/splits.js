jQuery(function($){
	$('p:empty').remove();
	$(window).on('tabs_loaded',function(){
		$('.splits').each(function(){
			$(this).children().each(function(){
				if( ! $(this).hasClass('split') ) $(this).remove();
			});
			$(this).children().first().addClass('l');
			$(this).children().last().addClass('r');
			$(this).append('<div style="clear:both"></div>');
		});
	});
});
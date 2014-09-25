jQuery(function ($) {
	$(window).load(function(){
		$('.more').show();
		$('.more a').each(function(){
			$(this).click(function(e){
				e.preventDefault();
				$(this).hide();
				$(this).parent().children('.the_more').show();
			});
		});
	});
});
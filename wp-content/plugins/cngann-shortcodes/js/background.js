jQuery(function ($) {
	$(window).ready(function(){
		$("h1 + .background").each(function(){
			$(this).prev().prependTo($(this));
			if($(this).next().is('br')) $(this).next().remove();
		});
	});
});
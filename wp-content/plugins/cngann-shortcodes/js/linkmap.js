if ('registerElement' in document) {
	document.registerElement('link-map');
	document.registerElement('map-link');
}
jQuery(function ($) {
	$(window).load(function(){
		$('link-map').each(function(){
			if($(this).hasClass('fc')){
				$(this).wrap('<figure class="front"></figure>')
				$(this).parent().wrap("<div class='card'></div>")
				$(this).parent().parent().append('<figure class="back"></figure>');
				$(this).parent().parent().wrap($("<div class='flashcard linkmap'></div>").addClass($(this).attr('class')));
				$(this).parent().parent().parent().css({'height':$(this).attr('h'), 'width' : $(this).attr('w') });
				$(this).find('map-link').each(function(){
					var $back_area = $("<div></div>").addClass($(this).attr('fc')).addClass('copy');
					$back_area.html($(this).html()).hide();
					$(this).parents('.card').find('.back').append($back_area);
				});
			}
			$clean_holder = $('<div></div>');
			$(this).find('map-link').each(function(){
				$(this).html('');
				$(this).appendTo($clean_holder);
			});
			$(this).html('')
			$clean_holder.children().appendTo($(this));

			$(this).find('map-link').each(function(){
				$(this).hover(
					function(e){
						if($(this).parents('.card').hasClass('flipped')) return;
						if(!$(this).parent().attr('hoverSrc')) return;
						$(this).css({'background':"transparent url('"+$(this).parent().attr('hoverSrc')+"') no-repeat -"+$(this).attr('lleft')+" -"+$(this).attr('ltop')});
					},
					function(e){
						if($(this).parents('.card').hasClass('flipped')) return;
						if(!$(this).parent().attr('hoverSrc')) return;
						$(this).css({'background':"none"});
					}
				);
				$(this).click(function(e){
					$(this).css({'background':"none"});
					if($(this).parent().hasClass('fc')){
						$(this).parents('.card').first().find('.back .copy').hide();
						$(this).parents('.card').first().find('.back .'+$(this).attr('fc')).show();
						$(this).parents('.card').addClass('flipped').addClass('flipping');
						window.setTimeout(function($t){
							$t.removeClass('flipping');
						},'1500', $(this).parents('.card'));
					}
					else window.location = $(this).attr('href');
				});
				$(this).parents('.card').first().find('.back').click(function(){
					$(this).parents('.card').addClass('flipping').removeClass('flipped');
					window.setTimeout(function($t){
						$t.removeClass('flipping');
					},'1500', $(this).parents('.card'));
				});
			});
		});
	});
});
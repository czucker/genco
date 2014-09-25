var $current_slider;
var is_auto = false;
function shift_slider(num){
	is_auto = true;
	$current_slider = jQuery('.slider_'+num);
	if($current_slider.find('.ttl.current').is(':last-child')) $current_slider.find('.ttl').first().click();
	else $current_slider.find('.ttl.current').next().click();
	is_auto = false;
}
var slider_intervals = [];
var current_slider_number = 0;
jQuery(function ($) {
	$(window).ready(function(){
		$('.slider').each(function(){
			var $outer = $('<div class="slider_outer_bg slider_number_'+current_slider_number+'"></div>');
			var $cngann_contents = $('<div class="cngann_contents"></div>');
			var $titles = $('<div class="ttls"></div>');
			$(this).addClass('slider_'+current_slider_number);

			var h = $(this).attr('hh');
			$(this).height(h);

			if($(this).hasClass('first')){
				$('body').prepend($outer);
				var offset = $( this ).offset();

				$father = $(this).parent();

				if ($('article').length > 0)  $main = $('article').first();
				else if ($('.page').length > 0)  $main = $('.page').first();
				else $main = $('.content');

				$main.prepend($(this));
				var pos = $( this ).position();
				$main.css({'position':'relative'})
				$(this).css({'position':'absolute', 'top' : pos.top + 36, 'left': 0, 'right':0 })
				$father.css({'padding-top' : $(this).outerHeight() - 10 });
				$outer.css( { 'top' : offset.top, 'height' : $(this).outerHeight() } )
				if($('#wpadminbar').length > 0) $outer.addClass('has_bar').css( { 'top' : "+=32" } )

			}
			var num_slides = $(this).find('.slide').length;
			var w = $(this).width();
			var tab_ctr = 0;
			$(this).find('.slide').each(function(){
				if(h) $cngann_contents.height(h);
				else if ($(this).height() > $cngann_contents.height()) $cngann_contents.height($(this).height());
				tab_ctr++;
				$titles.append($("<div class='ttl slide_"+tab_ctr+"' ctr='"+tab_ctr+"'></div>").click(function(e){
					e.preventDefault();
					$(this).parents('.slider').first().find('.slide').fadeOut(1000);
					$(this).parents('.slider').first().find('.current').removeClass('current');
					$(this).addClass('current');
					$(this).parents('.slider').first().find('.slide_'+$(this).attr('ctr')).fadeIn(1000);
					if(!is_auto){
						var id = $(this).parents('.slider').attr('slider_number');
						clearInterval(slider_intervals[id]);
						return false;
					}
				}));
				$(this).addClass('slide_'+tab_ctr);
				$(this).hide().css({'background': "transparent url('" + $(this).attr('src') + "') no-repeat top left", 'height' : h });
				$(this).append("<div style='clear:both;'></div>");
				$(this).click(function(){ window.location = $(this).attr('href'); });
				$cngann_contents.append($(this));
			});
			$(this).html("");
			$(this).append($cngann_contents);
			$(this).append($titles);
			current_slider_number++;
		});
	});
	var current_slider = 0;
	var ran_slider = false;
	$(window).load(function(){
		$('.slider').each(function(){
			$(this).attr('slider_number',current_slider);
			$("slider_outer_bg.slider_number_"+current_slider).height($(this).find('.cngann_contents').height());
			is_auto = true;
			$(this).find('.ttl').first().click();
			is_auto = false;
			$(this).append("<div style='clear:both;'></div>");
			$current_slider = $(this);
			slider_intervals[current_slider] = (function(current_slider){ return setInterval(function(){ shift_slider( current_slider ); },9000); })( current_slider );
			ran_slider = true;
			current_slider++;
		});
	});
});
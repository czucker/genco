jQuery(function ($) {
	$(window).load(function(){
		$('.tabs').each(function(){
			var num_tabs = $(this).find('.tab').length;
			var hash = window.location.hash.replace('#','').replace('-',' ').toLowerCase();
			$(this).show();
			var w = $(this).innerWidth();  //.width();
			var $cngann_contents = $('<div class="cngann_contents"></div>');
			var $titles = $('<div class="ttls"></div>');
			var tab_ctr = 0;
			$(this).find('.tab').each(function(){
				tab_ctr++;
				var c_ttl = $(this).attr('ttl').toLowerCase();
				var $ctab = $("<div class='ttl tab_"+tab_ctr+"' ctr='"+tab_ctr+"'>"+$(this).attr('ttl')+"</div>").css({'width' : ( ( w / num_tabs )   ) + 'px' , 'left' : ( w / num_tabs ) * (tab_ctr - 1) });
				if(hash == c_ttl) $ctab.addClass("current_ttl");
				$titles.append($ctab.click(function(e){
					$(this).parents('.tabs').first().find('.tab').hide();
					$(this).parents('.tabs').first().find('.current').removeClass('current');
					$(this).parents('.tabs').first().find('.currentsleft').removeClass('currentsleft');
					$(this).parents('.tabs').first().find('.currentsright').removeClass('currentsright');
					$(this).addClass('current');
					$(this).next().addClass('currentsright');
					$(this).prev().addClass('currentsleft');
					$(this).parents('.tabs').first().find('.tab_'+$(this).attr('ctr')).show();
				}));
				$(this).addClass('tab_'+tab_ctr).attr('tab', tab_ctr);
				$(this).children().first().each(function(){
					if($(this).is('br')) $(this).remove();
				});
				$cngann_contents.append($(this).hide());
				$(this).append("<div style='clear:both;'></div>");
			});
			$(this).html("");
			$(this).append($cngann_contents);
			$(this).prepend($titles);
			$(this).show();
			if ($(this).find('.current_ttl').length > 0){
				$(this).find('.current_ttl').click();
				var the_top = $(this).position().top;
				$(window).scrollTop(the_top);
			}
			else $(this).find('.ttls .ttl').first().click();
			$(this).append("<div style='clear:both;'></div>");
		});
		$(window).trigger('tabs_loaded');
	});
});
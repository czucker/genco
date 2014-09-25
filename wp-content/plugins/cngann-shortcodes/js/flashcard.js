jQuery(function ($) {
	$(window).load(function(){
		$('.flashcard figure').each(function(){
			if($(this).attr('click') == 'all') $this = $(this);
			else $this = $(this).find($(this).attr('click'));
			$this.click(function(e){
				e.preventDefault();
				$(this).parents('.flashcard').first().find('.card').toggleClass('flipped');
			});
		});
	});
});
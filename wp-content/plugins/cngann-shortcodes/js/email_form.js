jQuery(function ($) {
	$(window).load(function(){
		$('.email_form .button').click(function(){
			$(this).parents('.email_form').find('.fail').removeClass('fail');
			var pass = true;
			var submit_arr = {};
			$(this).parents('.email_form').find('input:not([type=submit]):not([type=file]):not([type=checkbox]):not([type=radio]), textarea').each(function(){
				if($(this).val() == ''){
					pass = false;
					$(this).addClass('fail');
				}
				submit_arr[$(this).attr('name')] = $(this).val();
			});
			if(! pass ) return false;
			$(this).parents('.email_form').find('input[type=checkbox]').each(function(){
				if($(this).is(':checked')) submit_arr[$(this).attr('name')] = 'y';
				else  submit_arr[$(this).attr('name')] = 'n';
			});
			var sent = false;
			var resp = $.ajax({
				'url'	  : '?cngann_email_form=y',
				'data'	  : submit_arr,
				'async'   : false,
				'type'	  : 'POST',
				'success' : function(r){
					if(r == 'Success') sent = true;
				}

			});

			$(this).parents('.email_form').each(function(){
				if( ! sent)	$(this).html("<div class='error'>"+$(this).attr('error')+"</div>");
				else	$(this).html("<div class='success'>"+$(this).attr('success')+"</div>");
			});


		});
	});
});
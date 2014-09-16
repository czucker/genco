jQuery(function($){
	$('.anps_custom li').on('click', function() {
		if( $(this).hasClass('selected') ) {
			return true;
		}
		var prevVal = $('.anps_custom_val').val();
		if (prevVal != '') {
			prevVal += ',';
		}
		$('.anps_custom_val').val( prevVal + $(this).attr('data-val') );

		$('.anps_custom_vals').html($('.anps_custom_vals').html() + '<li data-val="' + $(this).attr('data-val') + '">' + $(this).html() + '<button>×</button></li>');

		$('.anps_custom_vals li button').on('click', function() {
			anpsRemove($(this).parent());
			anpsChange();
		});

		anpsChange();
	});

	/* On remove */

	function anpsRemove(el) {
		var vals = $('.anps_custom_val').val().split(",");
		var newVals = '';
		for (var i = 0; i < vals.length; i++) {
			if( vals[i] != el.attr('data-val') ) {
				if(newVals != '') {
					newVals += ','; 
				}
				newVals += vals[i];
			}
		};
		$('.anps_custom_val').val(newVals);
		el.remove();
	}

	/* On change */

	function anpsChange() {
		$('.anps_custom li').removeClass('selected');
		var vals = $('.anps_custom_val').val().split(",");
		for (var i = 0; i < vals.length; i++) {
			$('.anps_custom li[data-val="' + vals[i] + '"]').addClass('selected');
		};
	}

	/* If values are already added */

	$('.anps_custom_vals li button').on('click', function() {
		anpsRemove($(this).parent());
		anpsChange();
	});

	/* Hide */

	$('body').on('click', function() {
		$('.anps_custom_vals').removeClass('active');
	});

	/* Focus */

	$('.anps_custom_vals, .anps_custom').on('click', function(e) {
		$('.anps_custom_vals').addClass('active');
		e.stopPropagation();
	});
})
var PopupAllyDependencyBinder = (function() {
	var self = {}, bound_dependency_elements = [], $ = jQuery;

	self.bind_dependency_elements = function() {
		$('[data-dependency][data-dependency-value]').each(function() {
			var $this = $(this);

			var dependency_name = $this.attr('data-dependency');

			if(0 > $.inArray(dependency_name, bound_dependency_elements)) {
				bound_dependency_elements.push(dependency_name);

				$('#' + dependency_name).on('change click', function(event) {
					var $element = $(this);

					var value = 'false';
					if($element.is('[type="checkbox"]')) {
						if ($element.is(':checked')){
							value = 'true';
						}
					} else {
						value = $element.val();
					}

					var $dependencies = $('[data-dependency="' + dependency_name + '"]');

					$dependencies.filter('[hide-toggle]').hide();
					$dependencies.filter('[hide-toggle][data-dependency-value="' + value + '"]').show();
					$dependencies.filter('[readonly-toggle]').prop('readonly', true);
					$dependencies.filter('[readonly-toggle][data-dependency-value="' + value + '"]').prop('readonly', false);
					$dependencies.filter('[disable-toggle]').prop('disabled', true);
					$dependencies.filter('[disable-toggle][data-dependency-value="' + value + '"]').prop('disabled', false);
				}).change();
			}
		});
	}
	return self;
})();

jQuery(document).ready(function($) {
	PopupAllyDependencyBinder.bind_dependency_elements();
	$('#add-new-popup').on('click', function(e) {
		$this.before();
	});
	var colorPickerOptions = {
    change: function(event, ui){
			$(this).val(ui.color.toIEOctoHex().replace('#ff', '#'));
			$(this).trigger("propertychange");
		}
	};
	if (!!$.prototype.wpColorPicker) {
		$('.nqpc-picker-input-iyxm').wpColorPicker(colorPickerOptions);
	}
	$("[click-target][click-value]").on('click', function(e) {
		var selector = $(this).attr('click-target');
		$(selector).val($(this).attr('click-value')).change();
		return false;
	});
	$("[click-target][click-value]").change();
	$("[input-empty-check]").on('change propertychange keyup input paste', function(e) {
		var selector = $(this).attr('input-empty-check');
		if ($(this).val()) {
			$(selector).val('block').change();
		} else {
			$(selector).val('none').change();
		}
	});
	$("[input-empty-check]").change();
	$("[input-all-empty-check]").on('change propertychange keyup input paste', function(e) {
		var is_empty = true;
		var selector = $(this).attr('input-all-empty-check');
		$('[input-all-empty-check=' + selector + ']').each(function(index) {
			if ($(this).val()) {
				is_empty = false;
			}
		});
		if (is_empty) {
			$(selector).val('none').change();
		} else {
			$(selector).val('block').change();
		}
	});
	$("[input-all-empty-check]").change();
	$("[input-all-false-check]").on('change propertychange', function(e) {
		var is_checked = false;
		var selector = $(this).attr('input-all-false-check');
		$('[input-all-false-check=' + selector + ']').each(function(index) {
			if ($(this).attr('checked')) {
				is_checked = true;
			}
		});
		if (is_checked) {
			$('.' + selector).show()
		} else {
			$('.' + selector).hide();
		}
	});
	$("[input-all-false-check]").change();
	$('.sign-up-form-raw-html').change(function(e) {
		var $this = $(this);
		var id = $this.attr('popup-id');
		var $dependents = $('.sign-up-form-valid-dependent-' + id);
		var $error = $('#sign-form-error-' + id);
		var $parent = $this.parents('table')
		var form_code = $.trim($this.val());

		$error.hide();
		$('.sign-up-form-generated-' + id).remove();
		if('' == form_code) {
			$('#sign-up-form-action-' + id).val('');
			$dependents.hide();
			$('.sign-up-form-select-' + id).empty();
			return;
		}
		$parsed_form = $(form_code);

		var $form = $parsed_form.find('form');
		if(0 == $form.size()) {
			$form = $parsed_form.filter('form');
		}
		if(0 == $form.size()) {
			$error.show().text('A <form> element could not be found in the Sign-up form HTML Code you entered. Please copy the entire HTML code block from your mailing list provider into the Sign-up form HTML field.');
			$('#sign-up-form-action-' + id).val('');
			$dependents.hide();
			$('.sign-up-form-select-' + id).empty();
			return;
		}
		$dependents.show();

		var form_action = $form.attr('action');

		$('#sign-up-form-action-' + id).val(form_action);

		var other_inputs = [];
		var lowercased = '';
		var email_input_name = '';
		var name_input_name = '';
		var count = 0;

		$parsed_form.find('input[type!="submit"]').each(function(index, input) {
			var $input = $(input);
			var input_name =$input.attr('name')
			var input_type = $input.attr('type')
			var input_value = $input.val();

			if (input_name) {
				count += 1;
				if('hidden' == input_type) {
					$parent.before($('<input class="sign-up-form-generated-' + id + '" type="hidden" name="' + data_object.setting_variable + '[' + id + ']' + '[hidden-form-fields-name][' + count + ']"/>').val(input_name));
					$parent.before($('<input class="sign-up-form-generated-' + id + '" type="hidden" name="' + data_object.setting_variable + '[' + id + ']' + '[hidden-form-fields-value][' + count + ']"/>').val(input_value));
				} else {
					$parent.before($('<input class="sign-up-form-generated-' + id + '" type="hidden" name="' + data_object.setting_variable + '[' + id + ']' + '[other-form-fields-name][' + count + ']"/>').val(input_name));
					$parent.before($('<input class="sign-up-form-generated-' + id + '" type="hidden" name="' + data_object.setting_variable + '[' + id + ']' + '[other-form-fields-value][' + count + ']"/>').val(input_value));
					other_inputs.push(input_name);

					lowercased = input_name.toLowerCase();

					if('' === email_input_name && -1 < lowercased.indexOf('email')) {
						email_input_name = input_name;
					} else if('' === name_input_name && -1 < lowercased.indexOf('name')) {
						name_input_name = input_name;
					}
				}
			}
		});

		$('.sign-up-form-select-' + id).each(function(index, select) {
			var $select = $(select);
			var previous_value = $select.val();
			var splash_field = $select.attr('sign-up-form-field');

			$select.empty();

			$.each(other_inputs, function(other_inputs_index, other_input) {
				$select.append($('<option></option>').attr('value', other_input).text(other_input));
			});

			if('' != previous_value && -1 < $.inArray(previous_value, other_inputs)) {
				$select.val(previous_value);
			} else {
				if('email' == splash_field && '' != email_input_name) {
					$select.val(email_input_name);
				} else if('name' == splash_field && '' != name_input_name) {
					$select.val(name_input_name);
				}
			}
		});
	});
	$('.sign-up-form-raw-html').change();
	function update_selected_status(elem) {
		var all_selector = $(elem).attr('update-all-trigger'),
			num_selector = $(elem).attr('update-num-trigger');

		if (all_selector) {
			if ($(all_selector).prop('checked')) {
				$(elem).val('all');
				return;
			}
		}
		$(elem).val($(num_selector + ':checked').length);
	}
	$('[update-all-trigger]').each(function(index, elem) {
		var selector = $(elem).attr('update-all-trigger');
		$(selector).on('change propertychange', function(e) {
			update_selected_status(elem);
		});
		update_selected_status(elem);
	});
	$('[update-num-trigger]').each(function(index, elem) {
		var selector = $(elem).attr('update-num-trigger');
		$(document).on('change propertychange', selector, function(e) {
			update_selected_status(elem);
		});
		update_selected_status(elem);
	});
});

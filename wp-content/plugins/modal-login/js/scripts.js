function isURL(str) {
	var pattern = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
 /*
  var pattern = new RegExp('^(https?:\/\/)?'+
    '((([a-z\d]([a-z\d-]*[a-z\d])*)\.)+[a-z]{2,}|'+
    '((\d{1,3}\.){3}\d{1,3}))'+
    '(\:\d+)?(\/[-a-z\d%_.~+]*)*'+
    '(\?[;&a-z\d%_.~+=-]*)?'+
    '(\#[-a-z\d_]*)?$','i');
*/
  if(!pattern.test(str)) {
    return false;
  } else {
    return true;
  }
}

function parseUri (str) {
// parseUri 1.2.2
// (c) Steven Levithan <stevenlevithan.com>
// MIT License
	var	o   = parseUri.options,
		m   = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
		uri = {},
		i   = 14;

	while (i--) uri[o.key[i]] = m[i] || "";

	uri[o.q.name] = {};
	uri[o.key[12]].replace(o.q.parser, function ($0, $1, $2) {
		if ($1) uri[o.q.name][$1] = $2;
	});

	return uri;
};

parseUri.options = {
	strictMode: false,
	key: ["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"],
	q:   {
		name:   "queryKey",
		parser: /(?:^|&)([^&=]*)=?([^&]*)/g
	},
	parser: {
		strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
		loose:  /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
	}
};

jQuery(document).ready(function() {

jQuery('#icon_style_group').hide();
if (jQuery('#main_template option:selected').text().toLowerCase().indexOf("banner") >= 0){
	jQuery('#icon_style_group').show();
}
	/* Autodetect API Connection Handler */
	jQuery('#rh_social_login_autodetect_api_connection_handler').click(function(){
		var message_string;
		var message_container;
		var is_success;

		var data = {
				_ajax_nonce: objectL10n.rh_social_login_ajax_nonce,
				action: 'autodetect_api_connection_handler'
			};

		message_container = jQuery('#rh_social_login_api_connection_handler_result');
		message_container.removeClass('success_message error_message').addClass('working_message');
		message_container.html(objectL10n.rh_admin_js_1);

		jQuery.post(ajaxurl,data, function(response) {

			/* CURL/FSOCKOPEN Radio Boxs */
			var radio_curl = jQuery("#rh_social_login_api_connection_handler_curl");
			var radio_fsockopen = jQuery("#rh_social_login_api_connection_handler_fsockopen");
			var radio_use_http_1 = jQuery("#rh_social_login_api_connection_handler_use_https_1");
			var radio_use_http_0 = jQuery("#rh_social_login_api_connection_handler_use_https_0");

			radio_curl.removeAttr("checked");
			radio_fsockopen.removeAttr("checked");
			radio_use_http_1.removeAttr("checked");
			radio_use_http_0.removeAttr("checked");

			/* CURL detected, HTTPS */
			if (response == 'success_autodetect_api_curl_https')
			{
				is_success = true;
				radio_curl.attr("checked", "checked");
				radio_use_http_1.attr("checked", "checked");
				message_string = objectL10n.rh_admin_js_201a;
			}
			/* CURL detected, HTTP */
			else if (response == 'success_autodetect_api_curl_http')
			{
				is_success = true;
				radio_curl.attr("checked", "checked");
				radio_use_http_0.attr("checked", "checked");
				message_string = objectL10n.rh_admin_js_201b;
			}
			/* FSOCKOPEN detected, HTTPS */
			else if (response == 'success_autodetect_api_fsockopen_https')
			{
				is_success = true;
				radio_fsockopen.attr("checked", "checked");
				radio_use_http_1.attr("checked", "checked");
				message_string = objectL10n.rh_admin_js_202a;
			}
			/* FSOCKOPEN detected, HTTP */
			else if (response == 'success_autodetect_api_fsockopen_http')
			{
				is_success = true;
				radio_fsockopen.attr("checked", "checked");
				radio_use_http_0.attr("checked", "checked");
				message_string = objectL10n.rh_admin_js_202b;
			}
			/* No handler detected */
			else
			{
				is_success = false;
				radio_curl.attr("checked", "checked");
				message_string = objectL10n.rh_admin_js_211;
			}

			message_container.removeClass('working_message');
			message_container.html(message_string);

			if (is_success){
				message_container.addClass('success_message');
			} else {
				message_container.addClass('error_message');
			}
		});
		return false;
	});

	/* Test API Settings */
	jQuery('#rh_social_login_test_api_settings').click(function(){
		var message_string;
		var message_container;
		var is_success;

		// var radio_fsockopen_val = jQuery("#rh_social_login_api_connection_handler_fsockopen:checked").val();
		// var radio_use_http_0 = jQuery("#rh_social_login_api_connection_handler_use_https_0:checked").val();

		var subdomain = jQuery('#api_subdomain').val();
		var key = jQuery('#api_key').val();
		var secret = jQuery('#api_secret').val();
		var handler ='curl'; // (radio_fsockopen_val == 'fsockopen' ? 'fsockopen' : 'curl');
		var use_https = '0'; //(radio_use_http_0 == '0' ? '0' : '1');

		var data = {
			_ajax_nonce: objectL10n.rh_social_login_ajax_nonce,
			action: 'check_api_settings',
			api_connection_handler: handler,
			api_connection_use_https: use_https,
			api_subdomain: subdomain,
			api_key: key,
			api_secret: secret
		};

		message_container = jQuery('#rh_social_login_api_test_result');
		//message_container.removeClass('success_message error_message').addClass('working_message');
		message_container.html(objectL10n.rh_admin_js_1);

		jQuery.post(ajaxurl,data, function(response) {
			if (response == 'error_selected_handler_faulty'){
				is_success = false;
				message_string = objectL10n.rh_admin_js_116;
			}
			else if (response == 'error_not_all_fields_filled_out'){
				is_success = false;
				message_string = objectL10n.rh_admin_js_111;
			}
			else if (response == 'error_subdomain_wrong'){
				is_success = false;
				message_string = objectL10n.rh_admin_js_112;
			}
			else if (response == 'error_subdomain_wrong_syntax'){
				is_success = false;
				message_string = objectL10n.rh_admin_js_113;
			}
			else if (response == 'error_communication'){
				is_success = false;
				message_string = objectL10n.rh_admin_js_114;
			}
			else if (response == 'error_authentication_credentials_wrong'){
				is_success = false;
				message_string = objectL10n.rh_admin_js_115;
			}
			else {
				is_success = true;
				message_string = objectL10n.rh_admin_js_101;
			}

			message_container.removeClass('working_message');
			message_container.html(message_string);

			if (is_success){
				message_container.addClass('success_message');
			} else {
				message_container.addClass('error_message');
			}
		});
		return false;
	});

	jQuery('#verify-settings').click(function(){
		jQuery('#rh_social_login_test_api_settings').click();
	});

	jQuery('#main_template').change(function(){
		var str = jQuery(this).find('option:selected').text();
		//load custom icon options only if a banner style button is selected
		if (str.toLowerCase().indexOf("banner") >= 0){
			jQuery('#icon_style_group').show('slow');
		} else {
			jQuery('#icon_style_group').hide('slow');
		}
	});

	jQuery('a[rel=popover]').popover&&jQuery('a[rel=popover]').popover({
		  html: true,
		  trigger: 'hover',
		  placement: 'right',
		  content: function () {
		    return '<img src="'+jQuery(this).data('img') + '" />';
		}
	});
});


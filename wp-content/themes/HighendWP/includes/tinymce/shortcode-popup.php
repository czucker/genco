<?php
// registers the buttons for use
function hbthemes_register_buttons($buttons) {
	array_push($buttons, "hbthemes_shortcodes");
	return $buttons;
}

// filters the tinyMCE buttons and adds our custom buttons
function hbthemes_shortcode_buttons() {
	// Don't bother doing this stuff if the current user lacks permissions
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;
	 
	// Add only in Rich Editor mode
	if ( get_user_option('rich_editing') == 'true') {
		// filter the tinyMCE buttons and add our own
		add_filter("mce_external_plugins", "hbthemes_add_tinymce_plugin");
		add_filter('mce_buttons', 'hbthemes_register_buttons');
	}
}
// init process for button control
add_action('init', 'hbthemes_shortcode_buttons');

// add the button to the tinyMCE bar
function hbthemes_add_tinymce_plugin($plugin_array) {
	$plugin_array['hbthemes_shortcodes'] = get_template_directory_uri() . '/includes/tinymce/hbthemes-shortcodes-popup.js';
	return $plugin_array;
}

?>
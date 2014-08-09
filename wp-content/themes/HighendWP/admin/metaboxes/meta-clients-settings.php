<?php
return array(
	array(
		'type' => 'notebox',
		'name' => 'hb_clients_info',
		'label' => __('Featured Image', 'hbthemes'),
		'description' => __('Please use the featured image metabox to upload your Clients Logo and then assign to the post.', 'hbthemes'),
		'status' => 'normal',
	),
	array(
		'type' => 'upload',
		'name' => 'hb_client_logo',
		'label' => __('Logo', 'hbthemes'),
		'description' => __('Upload an the client logo. ', 'hbthemes'),
	),
	array(
		'type' => 'textbox',
		'name' => 'hb_client_url',
		'label' => __('URL to Clients Website (optional)','hbthemes'),
		'description' => 'Enter URL to your clients website and make sure you include http:// in the URL.',
		'default' => '',
	),
);
?>
<?php
$social_links = array("envelop" => "Mail", "dribbble" => "Dribbble" , "facebook" => "Facebook", "flickr" => "Flickr", "forrst"=>"Forrst", "google-plus" => "Google Plus", "html5"=> "HTML 5", "cloud" => "iCloud", "lastfm"=> "LastFM", "linkedin"=> "LinkedIn", "paypal"=> "PayPal", "pinterest"=> "Pinterest", "reddit"=>"Reddit", "feed2"=>"RSS", "skype"=>"Skype", "stumbleupon"=> "StumbleUpon", "tumblr"=>"Tumblr", "twitter"=>"Twitter", "vimeo"=>"Vimeo", "wordpress"=>"WordPress", "yahoo"=>"Yahoo", "youtube"=>"YouTube", "github"=>"Github", "yelp"=>"Yelp", "mail"=>"Mail", "instagram"=>"Instagram", "foursquare"=>"Foursquare", "xing"=>"Xing");

$employee_settings = array();

$employee_settings[] = array(
	'type' => 'notebox',
	'name' => 'hb_employees_info',
	'label' => __('Team Member Image', 'hbthemes'),
	'description' => __('<p>Featured Image will be used as Team Member image.</p><p>Suggested image dimensions are 360 x 360px (1:1 image ratio).</p>', 'hbthemes'),
	'status' => 'normal',
);

$employee_settings[] = array(
	'type' => 'textbox',
	'name' => 'hb_employee_position',
	'label' => __('Team Member Position', 'hbthemes'),
	'description' => __("Please enter team member's position in your company.",'hbthemes'),
	'default' => '',
);

foreach ($social_links as $social_class => $social_name) {
	$employee_settings[] = array(
		'type' => 'textbox',
		'name' => 'hb_employee_social_' . $social_class,
		'label' => $social_name,
		'default' => '',
	);
}
return $employee_settings;
?>
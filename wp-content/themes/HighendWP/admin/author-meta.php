<?php
global $social_links;
$social_links = array("envelop" => "Mail", "dribbble" => "Dribbble" , "facebook" => "Facebook", "flickr" => "Flickr", "forrst"=>"Forrst", "google-plus" => "Google Plus", "html5"=> "HTML 5", "cloud" => "iCloud", "lastfm"=> "LastFM", "linkedin"=> "LinkedIn", "paypal"=> "PayPal", "pinterest"=> "Pinterest", "reddit"=>"Reddit", "feed2"=>"RSS", "skype"=>"Skype", "stumbleupon"=> "StumbleUpon", "tumblr"=>"Tumblr", "twitter"=>"Twitter", "vimeo"=>"Vimeo", "wordpress"=>"WordPress", "yahoo"=>"Yahoo", "youtube"=>"YouTube", "github"=>"Github", "yelp"=>"Yelp", "mail"=>"Mail", "instagram"=>"Instagram", "foursquare"=>"Foursquare", "xing"=>"Xing");

/*-----------------------------------------------------------------------------------*/
# Add user's social accounts
/*-----------------------------------------------------------------------------------*/
add_action( 'show_user_profile', 'hb_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'hb_show_extra_profile_fields' );
function hb_show_extra_profile_fields( $user ) { ?>
	<h3><?php _e( 'Social Networking', 'hbthemes' ) ?></h3>
	<table class="form-table">
		<?php
			global $social_links;
			
			foreach ( $social_links as $soc => $soc_name ) { ?>
				<tr>
					<th><label for="<?php echo $soc; ?>"><?php echo $soc_name; ?></label></th>
					<td>
						<input type="text" name="<?php echo $soc; ?>" id="<?php echo $soc; ?>" value="<?php echo esc_attr( get_the_author_meta( $soc , $user->ID ) ); ?>" class="regular-text" /><br />
					</td>
				</tr>	
			<?php }	?>
	</table>
<?php }

## Save user's social accounts
add_action( 'personal_options_update', 'hb_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'hb_save_extra_profile_fields' );
function hb_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) return false;
	
	global $social_links;
		
	foreach ( $social_links as $soc => $soc_name ) {
		update_user_meta( $user_id, $soc, $_POST[$soc] );
	}
}

function hb_get_user_socials ( $user_id ) {
	global $social_links;	
	$return = array();
	
	foreach ( $social_links as $soc => $soc_name ) {
		$return[$soc] = array();
		$return[$soc]['soc_name'] = $soc_name;
		$return[$soc]['soc_link'] = get_user_meta( $user_id, $soc, true ); 
		
		/*array_push ($return[$soc], $soc);
		array_push ($return[$soc], $soc_name);
		array_push ($return[$soc], get_user_meta( $user_id, $soc, true ));
		*/
	}
	
	
	return $return;	
}

?>
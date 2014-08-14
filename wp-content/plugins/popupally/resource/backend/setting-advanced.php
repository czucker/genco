<div class="wrap">
	<h2><?php _e('Popup Advanced Settings'); ?></h2>
	<?php settings_errors('popupally_advanced'); ?>

	<p>Need help setting up the popups? See the tutorial on <a href="<?php echo PopupAlly::HELP_URL; ?>">our website</a>!</p>
	<div class="popupally-display-sidebar">
		<a class="popupally-display-sidebar-1" target="_blank" href="http://30daylistbuildingchallenge.com/?utm_source=popupallyplugin&utm_medium=sidebarad&utm_campaign=30daylistbuildingchallenge">
			<img src="<?php echo $plugin_dir; ?>/resource/backend/popupally-side.png" alt="Check out the 30 Day List Building Challenge!" width="300" height="350">
		</a>
		<a class="popupally-display-sidebar-2" target="_blank" href="<?php echo PopupAlly::POPUPALLY_PRO_URL; ?>">
			<img src="<?php echo $plugin_dir; ?>/resource/backend/popupally-side2.png" alt="Upgrade to PopupAlly Pro!" width="300" height="350">
		</a>
		<a class="popupally-display-sidebar-3" target="_blank" href="http://wordpress.org/plugins/popupally/">
			<img src="<?php echo $plugin_dir; ?>/resource/backend/popupally-side3.png" alt="Leave us a review!" width="300" height="115">
		</a>
	</div>
	<form class="popupally-display-form" method="post" action="options.php"> 
		<?php settings_fields( 'popupally_advanced_settings' ); ?>
		<div class="popupally-setting-div">
			<fieldset class="popupally-fieldset">
				<legend>Script settings</legend>
				<table class="form-table form-table-popupally-style-integration">
					<tbody>
						<tr valign="top">
							<th scope="row"><label for="no-inline-checkbox">Do NOT use inline Javascript/CSS</label></th>
							<td>
								<input id="no-inline-checkbox" type="checkbox" name="<?php echo PopupAlly::SETTING_KEY_ADVANCED; ?>[no-inline]" <?php checked($advanced['no-inline'], 'true'); ?> value="true"/>
								<label for="no-inline-checkbox"><small>Enabling this option is NOT recommended, as it can affect performance. Only enable if your theme does not implement the 'wp_head' function.</small></label>
							</td>
						</tr>
					</tbody>
				</table>
			</fieldset>
		</div>
		<div class="popupally-setting-div">
			<fieldset class="popupally-fieldset">
				<legend>Page/post loading in Display Settings</legend>
				<table class="form-table form-table-popupally-style-integration">
					<tbody>
						<tr valign="top">
							<th scope="row"><label for="max-page">Max number of pages to load</label></th>
							<td>
								<input id="max-page" type="text" name="<?php echo PopupAlly::SETTING_KEY_ADVANCED; ?>[max-page]" value="<?php echo $advanced['max-page']; ?>"/>
								<label for="max-page"><small>-1 to show all. Loading too many pages could prevent the "Display Settings" screen from loading due to time out.</small></label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="max-post">Max number of posts to load</label></th>
							<td>
								<input id="max-post" type="text" name="<?php echo PopupAlly::SETTING_KEY_ADVANCED; ?>[max-post]" value="<?php echo $advanced['max-post']; ?>"/>
								<label for="max-post"><small>-1 to show all. Loading too many posts could prevent the "Display Settings" screen from loading due to time out.</small></label>
							</td>
						</tr>
					</tbody>
				</table>
			</fieldset>
		</div>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
</div>

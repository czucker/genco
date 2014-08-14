<div class="wrap">
	<h2><?php _e('Popup Style Settings'); ?></h2>
	<?php settings_errors('popupally_style'); ?>

	<p>Need help setting up the popups? See the tutorial on <a href="<?php echo PopupAlly::HELP_URL; ?>">our website</a>!</p>
	<form enctype="multipart/form-data" method="post" action="options.php"> 
		<?php settings_fields( 'popupally_style_settings' ); ?>

		<?php foreach ($style as $id => $setting) { ?>
		<a class="anchor" name="popup-<?php echo $id; ?>"></a> 
		<div class="popupally-setting-div">
			<h3><?php echo $id; ?>. <input name="<?php echo $setting_variable . '[' . $id . ']'; ?>[name]" type="text" value="<?php echo esc_attr($setting['name']); ?>"/></h3>

			<div>
				<fieldset class="popupally-fieldset">
					<legend>Integration settings</legend>
					<input type="hidden" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[sign-up-form-action]" id="sign-up-form-action-<?php echo $id; ?>" value="<?php echo $setting['sign-up-form-action']; ?>" />
					<table class="form-table form-table-popupally-style-integration">
						<tbody>
							<tr valign="top">
								<th scope="row">Sign-up form HTML</th>
								<td>
									<textarea class="full-width sign-up-form-raw-html" popup-id="<?php echo $id; ?>" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[signup-form]" rows="6"><?php echo esc_attr($setting['signup-form']); ?></textarea>
									<small class="sign-up-error" id="sign-form-error-<?php echo $id;?>"></small>
								</td>
							</tr>
							<tr valign="top" class="sign-up-form-valid-dependent-<?php echo $id; ?>">
								<th scope="row">Name field</th>
								<td>
									<select class="sign-up-form-select-<?php echo $id; ?>" sign-up-form-field="name" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[sign-up-form-name-field]">
										<?php if (isset($setting['other-form-fields-name'])) {
										foreach($setting['other-form-fields-name'] as $field_id => $name) { ?>
										<option value="<?php echo $name; ?>" <?php selected($setting['sign-up-form-name-field'], $name); ?>><?php echo $name; ?></option>
										<?php }
										} ?>
									</select>
								</td>
							</tr>
							<tr valign="top" class="sign-up-form-valid-dependent-<?php echo $id; ?>">
								<th scope="row">Email field</th>
								<td>
									<select class="sign-up-form-select-<?php echo $id; ?>" sign-up-form-field="email" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[sign-up-form-email-field]">
										<?php if (isset($setting['other-form-fields-name'])) {
										foreach($setting['other-form-fields-name'] as $field_id => $name) { ?>
										<option value="<?php echo $name; ?>" <?php selected($setting['sign-up-form-email-field'], $name); ?>><?php echo $name; ?></option>
										<?php }
										} ?>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
				</fieldset>
				<div class="popupally-template-selection">
				<label>Popup Template</label><select id="template-selector-<?php echo $id; ?>" name="<?php echo $setting_variable. '[' . $id . ']'; ?>[selected-template]">
				<?php foreach (PopupAlly::$available_templates as $template_uid => $template_obj) { ?>
					<option value="<?php echo $template_uid; ?>" <?php selected($setting['selected-template'], $template_uid); ?>><?php echo $template_obj->template_name; ?></option>
				<?php } ?>
				</select>
				</div>
				<?php foreach (PopupAlly::$available_templates as $template_uid => $template_obj) { ?>
					<div hide-toggle data-dependency="template-selector-<?php echo $id; ?>" data-dependency-value="<?php echo $template_uid; ?>" >
						<?php include $template_obj->backend_php; ?>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php } ?>

		<p class="submit">
			<input type="submit" id="popupally-style-submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
</div>
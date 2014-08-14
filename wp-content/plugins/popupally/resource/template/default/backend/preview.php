<fieldset class="popupally-fieldset popupally-style-preview">
	<legend>Preview</legend>
	<div id="popup-box-preview-<?php echo $id; ?>" class="popupally-outer-sxzw">
		<div class="popupally-inner-sxzw">
			<div class="popupally-center-sxzw">
				<div class="desc-sxzw customizable-color-text-<?php echo $id; ?>" id="preview-headline-<?php echo $id; ?>"></div>
				<div class="logo-row-sxzw" id="logo-row-<?php echo $id; ?>">
					<div class="clear-sxzw"></div>
					<img class="logo-img-sxzw" id="preview-img-<?php echo $id; ?>" src="" alt="">
					<div class="logo-text-sxzw customizable-color-text-<?php echo $id; ?>" id="preview-sales-text-<?php echo $id; ?>"></div>
					<div class="clear-sxzw"></div>
				</div>
				<div class="content-sxzw">
					<input type="text" id="preview-name-<?php echo $id; ?>" name="name" class="field-sxzw" placeholder="Enter your first name here"/>
					<input type="text" id="preview-email-<?php echo $id; ?>" name="email" class="field-sxzw" placeholder="Enter a valid email here"/>
					<input type="button" id="subscribe-button-<?php echo $id; ?>" class="submit-sxzw no-click-through" value=""/>
				</div>
				<div class="privacy-sxzw customizable-color-text-<?php echo $id; ?>" id="privacy-text-<?php echo $id; ?>"></div>
			</div>
		</div>
	</div>
</fieldset>
<fieldset class="popupally-fieldset popupally-style-customization">
	<legend>Customization</legend>
	<input type="hidden" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[logo-img-action]" id="logo-img-<?php echo $id; ?>" value="<?php echo empty($setting['image-url']) ? 'upload' : 'url'; ?>" />
	<input type="hidden" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[display-headline]" id="display-headline-<?php echo $id; ?>" preview-update-target-css-hide="#preview-headline-<?php echo $id; ?>" value="<?php echo $setting['display-headline']; ?>" />
	<input type="hidden" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[display-logo-row]" id="display-logo-row-<?php echo $id; ?>" preview-update-target-css-hide="#logo-row-<?php echo $id; ?>" value="<?php echo $setting['display-logo-row']; ?>" />
	<input type="hidden" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[display-logo-img]" id="display-logo-img-<?php echo $id; ?>" preview-update-target-css-hide="#preview-img-<?php echo $id; ?>" value="<?php echo $setting['display-logo-img']; ?>" />
	<input type="hidden" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[display-privacy]" id="display-privacy-<?php echo $id; ?>" preview-update-target-css-hide="#privacy-text-<?php echo $id; ?>" value="<?php echo $setting['display-privacy']; ?>" />
	<table class="form-table form-table-popupally-style-customization">
		<tbody>
			<tr valign="top">
				<th scope="row">Background color</th>
				<td>
					<input size="8" class="nqpc-picker-input-iyxm" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[background-color]" type="text" value="<?php echo $setting['background-color']; ?>" preview-update-target-css="#popup-box-preview-<?php echo $id; ?>" preview-update-target-css-property="background-color" data-default-color="#FFFFFF">
					<div class="popupally-style-same-line-block">
						<strong class="popupally-style-same-line-label">Text color</strong>
						<input size="8" class="nqpc-picker-input-iyxm" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[text-color]" type="text" value="<?php echo $setting['text-color']; ?>" preview-update-target-css=".customizable-color-text-<?php echo $id; ?>" preview-update-target-css-property="color" data-default-color="#444444">
					</div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Headline (HTML code allowed)</th>
				<td>
					<textarea rows="3" class="full-width" input-empty-check="#display-headline-<?php echo $id; ?>" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[headline]" preview-update-target="#preview-headline-<?php echo $id; ?>"><?php echo esc_attr($setting['headline']); ?></textarea>
					<small>Need to use a different font for the headline? <a href="<?php echo PopupAlly::POPUPALLY_PRO_URL; ?>">PopupAlly Pro</a> can help with that!</small>
				</td>
			</tr>
			<tr valign="top" hide-toggle data-dependency="logo-img-<?php echo $id; ?>" data-dependency-value="upload">
				<th scope="row">Logo Image<br />
					<small><a click-value="url" click-target="#logo-img-<?php echo $id; ?>" href="#">Specify a url instead</a></small>
				</th>
				<td>
					<input type="file" name="img-file-<?php echo $id; ?>"><br />
					<small>The image will be uploaded on submit. Leave this field blank if you do not want to show an image with the popup.</small>
				</td>
			</tr>
			<tr valign="top" hide-toggle data-dependency="logo-img-<?php echo $id; ?>" data-dependency-value="url">
				<th scope="row">Logo Image<br />
					<small><a click-value="upload" click-target="#logo-img-<?php echo $id; ?>" href="#">Upload an image instead</a></small>
				</th>
				<td>
					<input class="full-width" type="text" input-empty-check="#display-logo-img-<?php echo $id; ?>" input-all-empty-check="#display-logo-row-<?php echo $id; ?>" preview-update-target-img="#preview-img-<?php echo $id; ?>" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[image-url]" value="<?php echo(esc_attr($setting['image-url'])); ?>" /><br />
					<small>Leave this field blank if you do not want to show an image with the popup.</small>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Introduction Text (HTML code allowed)</th>
				<td><textarea rows="3" class="full-width" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[sales-text]" preview-update-target="#preview-sales-text-<?php echo $id; ?>" input-all-empty-check="#display-logo-row-<?php echo $id; ?>"><?php echo esc_attr($setting['sales-text']); ?></textarea></td>
			</tr>
			<tr valign="top">
				<th scope="row">Name Input Placeholder</th>
				<td><input class="full-width" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[name-placeholder]" type="text" value="<?php echo esc_attr($setting['name-placeholder']); ?>" preview-update-target-placeholder="#preview-name-<?php echo $id; ?>"></td>
			</tr>
			<tr valign="top">
				<th scope="row">Email Input Placeholder</th>
				<td><input class="full-width" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[email-placeholder]" type="text" value="<?php echo esc_attr($setting['email-placeholder']); ?>" preview-update-target-placeholder="#preview-email-<?php echo $id; ?>"></td>
			</tr>
			<tr valign="top">
				<th scope="row">Subscribe button text</th>
				<td><input class="full-width" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[subscribe-button-text]" type="text" value="<?php echo esc_attr($setting['subscribe-button-text']); ?>" preview-update-target-value="#subscribe-button-<?php echo $id; ?>"></td>
			</tr>
			<tr valign="top">
				<th scope="row">Subscribe button color</th>
				<td>
					<input size="8" class="nqpc-picker-input-iyxm" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[subscribe-button-color]" type="text" value="<?php echo $setting['subscribe-button-color']; ?>" preview-update-target-css="#subscribe-button-<?php echo $id; ?>" preview-update-target-css-property="background-color" data-default-color="#00c98d">
					<div class="popupally-style-same-line-block">
						<strong class="popupally-style-same-line-label">Subscribe button text color</strong>
						<input size="8" class="nqpc-picker-input-iyxm" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[subscribe-button-text-color]" type="text" value="<?php echo $setting['subscribe-button-text-color']; ?>" preview-update-target-css="#subscribe-button-<?php echo $id; ?>" preview-update-target-css-property="color" data-default-color="#ffffff">
					</div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Privacy Text (HTML code allowed)</th>
				<td><textarea rows="3" class="full-width" input-empty-check="#display-privacy-<?php echo $id; ?>" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[privacy-text]" preview-update-target="#privacy-text-<?php echo $id; ?>"><?php echo esc_attr($setting['privacy-text']); ?></textarea></td>
			</tr>
		</tbody>
	</table>
</fieldset>
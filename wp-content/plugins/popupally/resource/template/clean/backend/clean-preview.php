<fieldset class="popupally-fieldset popupally-style-preview-horizontal">
	<legend>Preview</legend>
	<div class="popupally-style-full-size-scroll">
		<div id="plsbvs-popup-box-preview-<?php echo $id; ?>" class="popupally-outer-plsbvs">
			<div class="popupally-inner-plsbvs">
				<div class="popupally-center-plsbvs">
					<div class="desc-plsbvs plsbvs-customizable-color-text-<?php echo $id; ?>" style="cursor: pointer;" id="plsbvs-preview-headline-<?php echo $id; ?>"></div>
					<div class="content-plsbvs">
						<input type="text" id="plsbvs-preview-name-<?php echo $id; ?>" name="name" class="field-plsbvs" placeholder="Name"/>
						<input type="text" id="plsbvs-preview-email-<?php echo $id; ?>" name="email" class="field-plsbvs" placeholder="Email"/>
						<input type="button" id="plsbvs-subscribe-button-<?php echo $id; ?>" class="submit-plsbvs no-click-through" value=""/>
					</div>
				</div>
			</div>
		</div>
	</div>
</fieldset>
<fieldset class="popupally-fieldset popupally-style-customization-horizontal">
	<legend>Customization</legend>
	<input type="hidden" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-background-img-action]" id="plsbvs-background-img-<?php echo $id; ?>" value="<?php echo empty($setting['plsbvs-image-url']) ? 'upload' : 'url'; ?>" />
	<table class="form-table form-table-popupally-style-customization">
		<tbody>
			<tr valign="top">
				<th scope="row">Background color</th>
				<td><input size="8" class="nqpc-picker-input-iyxm" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-background-color]" type="text" value="<?php echo $setting['plsbvs-background-color']; ?>" preview-update-target-css="#plsbvs-popup-box-preview-<?php echo $id; ?>" preview-update-target-css-property="background-color" data-default-color="#d3d3d3"></td>
			</tr>
			<tr valign="top" hide-toggle data-dependency="plsbvs-background-img-<?php echo $id; ?>" data-dependency-value="upload">
				<th scope="row">Background Image<br />
					<small><a click-value="url" click-target="#plsbvs-background-img-<?php echo $id; ?>" href="#">Specify a url instead</a></small>
				</th>
				<td>
					<input type="file" name="plsbvs-img-file-<?php echo $id; ?>"><br />
					<small>The image will be uploaded on submit. Leave this field blank if you do not want to show a background image for the popup.</small>
				</td>
			</tr>
			<tr valign="top" hide-toggle data-dependency="plsbvs-background-img-<?php echo $id; ?>" data-dependency-value="url">
				<th scope="row">Background Image<br />
					<small><a click-value="upload" click-target="#plsbvs-background-img-<?php echo $id; ?>" href="#">Upload an image instead</a></small>
				</th>
				<td>
					<input class="full-width" type="text" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-image-url]" value="<?php echo(esc_attr($setting['plsbvs-image-url'])); ?>" preview-update-target-css-background-img="#plsbvs-popup-box-preview-<?php echo $id; ?>" /><br />
					<small>Leave this field blank if you do not want to show an image with the popup.</small>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Popup Box Size</th>
				<td>
					<div>
						<span class="two-by-two-input">
							Width
							<input size="8" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-width]" type="text" value="<?php echo $setting['plsbvs-width']; ?>" preview-update-target-css="#plsbvs-popup-box-preview-<?php echo $id; ?>" preview-update-target-css-property-px="width">px
						</span>
						<span class="two-by-two-input">
							Height
							<input size="8" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-height]" type="text" value="<?php echo $setting['plsbvs-height']; ?>" preview-update-target-css="#plsbvs-popup-box-preview-<?php echo $id; ?>" preview-update-target-css-property-px="height">px
						</span>
					</div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Headline color</th>
				<td><input size="8" class="nqpc-picker-input-iyxm" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-text-color]" type="text" value="<?php echo $setting['plsbvs-text-color']; ?>" preview-update-target-css=".plsbvs-customizable-color-text-<?php echo $id; ?>" preview-update-target-css-property="color" data-default-color="#444444"></td>
			</tr>
			<tr valign="top">
				<th scope="row">Headline (HTML code allowed)</th>
				<td>
					<textarea rows="3" class="full-width" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-headline]" preview-update-target="#plsbvs-preview-headline-<?php echo $id; ?>"><?php echo esc_attr($setting['plsbvs-headline']); ?></textarea>
					<small>Need to use a different font for the headline? <a href="<?php echo PopupAlly::POPUPALLY_PRO_URL; ?>">PopupAlly Pro</a> can help with that!</small>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Headline Position</th>
				<td>
					<div>
						<span class="two-by-two-input">
							Vertical offset
							<input size="8" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-headline-top]" type="text" value="<?php echo $setting['plsbvs-headline-top']; ?>" preview-update-target-css="#plsbvs-preview-headline-<?php echo $id; ?>" preview-update-target-css-property-px="top">px
						</span>
						<span class="two-by-two-input">
							Horizontal offset
							<input size="8" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-headline-left]" type="text" value="<?php echo $setting['plsbvs-headline-left']; ?>" preview-update-target-css="#plsbvs-preview-headline-<?php echo $id; ?>" preview-update-target-css-property-px="left">px
						</span>
					</div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Name Input Placeholder</th>
				<td>
					<input size="12" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-name-placeholder]" type="text" value="<?php echo esc_attr($setting['plsbvs-name-placeholder']); ?>" preview-update-target-placeholder="#plsbvs-preview-name-<?php echo $id; ?>">
					<div class="popupally-style-same-line-block">
						<strong class="popupally-style-same-line-label">Name Input Box Position</strong>
						<span class="two-by-two-input">
							Vertical offset
							<input size="8" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-name-field-top]" type="text" value="<?php echo $setting['plsbvs-name-field-top']; ?>" preview-update-target-css="#plsbvs-preview-name-<?php echo $id; ?>" preview-update-target-css-property-px="top">px
						</span>
						<span class="two-by-two-input">
							Horizontal offset
							<input size="8" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-name-field-left]" type="text" value="<?php echo $setting['plsbvs-name-field-left']; ?>" preview-update-target-css="#plsbvs-preview-name-<?php echo $id; ?>" preview-update-target-css-property-px="left">px
						</span>
					</div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Email Input Placeholder</th>
				<td>
					<input size="12" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-email-placeholder]" type="text" value="<?php echo esc_attr($setting['plsbvs-email-placeholder']); ?>" preview-update-target-placeholder="#plsbvs-preview-email-<?php echo $id; ?>">
					<div class="popupally-style-same-line-block">
						<strong class="popupally-style-same-line-label">Email Input Box Position</strong>
						<span class="two-by-two-input">
							Vertical offset
							<input size="8" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-email-field-top]" type="text" value="<?php echo $setting['plsbvs-email-field-top']; ?>" preview-update-target-css="#plsbvs-preview-email-<?php echo $id; ?>" preview-update-target-css-property-px="top">px
						</span>
						<span class="two-by-two-input">
							Horizontal offset
							<input size="8" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-email-field-left]" type="text" value="<?php echo $setting['plsbvs-email-field-left']; ?>" preview-update-target-css="#plsbvs-preview-email-<?php echo $id; ?>" preview-update-target-css-property-px="left">px
						</span>
					</div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Subscribe Button Text</th>
				<td>
					<input size="20" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-subscribe-button-text]" type="text" value="<?php echo esc_attr($setting['plsbvs-subscribe-button-text']); ?>" preview-update-target-value="#plsbvs-subscribe-button-<?php echo $id; ?>">
					<div class="popupally-style-same-line-block">
						<strong class="popupally-style-same-line-label">Subscribe Button Position</strong>
						<span class="two-by-two-input">
							Top
							<input size="8" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-subscribe-button-top]" type="text" value="<?php echo $setting['plsbvs-subscribe-button-top']; ?>" preview-update-target-css="#plsbvs-subscribe-button-<?php echo $id; ?>" preview-update-target-css-property-px="top">px
						</span>
						<span class="two-by-two-input">
							Left
							<input size="8" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-subscribe-button-left]" type="text" value="<?php echo $setting['plsbvs-subscribe-button-left']; ?>" preview-update-target-css="#plsbvs-subscribe-button-<?php echo $id; ?>" preview-update-target-css-property-px="left">px
						</span>
					</div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Subscribe Button Color</th>
				<td>
					<input size="8" class="nqpc-picker-input-iyxm" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-subscribe-button-color]" type="text" value="<?php echo $setting['plsbvs-subscribe-button-color']; ?>" preview-update-target-css="#plsbvs-subscribe-button-<?php echo $id; ?>" preview-update-target-css-property="background-color" data-default-color="#00c98d">
					<div class="popupally-style-same-line-block">
						<strong class="popupally-style-same-line-label">Subscribe Button Text Color</strong>
						<input size="8" class="nqpc-picker-input-iyxm" name="<?php echo $setting_variable . '[' . $id . ']'; ?>[plsbvs-subscribe-button-text-color]" type="text" value="<?php echo $setting['plsbvs-subscribe-button-text-color']; ?>" preview-update-target-css="#plsbvs-subscribe-button-<?php echo $id; ?>" preview-update-target-css-property="color" data-default-color="#ffffff">
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>
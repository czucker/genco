<div class="wrap">
	<h2><?php _e('Popup Display Settings'); ?></h2>
	<?php settings_errors('popupally_display'); ?>

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
		<?php settings_fields( 'popupally_display_settings' ); ?>

		<?php foreach ($display as $id => $setting) { ?>
		<div class="popupally-setting-div">
			<h3><?php echo $id; ?>. <?php echo esc_attr($style[$id]['name']); ?></h3>
			<fieldset class="popupally-fieldset">
				<legend>Show this popup as</legend>
				<small>Want more ways to open the popup, such as open-on-click or embedded at the top of the page? Check out <a href="<?php echo PopupAlly::POPUPALLY_PRO_URL; ?>">PopupAlly Pro</a>!</small>
				<table class="form-table form-table-popupally-style-integration">
					<tbody>
						<tr valign="top">
							<th scope="row">Time-delayed popup</th>
							<td>
								<input type="checkbox" input-all-false-check="popupally-conditional-display-<?php echo $id; ?>" id="timed-<?php echo $id; ?>" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[timed]" <?php checked($setting['timed'], 'true'); ?> value="true"/>
								<label>Show after <input type="text" size="4" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[timed-popup-delay]" readonly-toggle data-dependency="timed-<?php echo $id; ?>" data-dependency-value="true" value="<?php echo $setting['timed-popup-delay']; ?>"/> seconds</label>
								<small>(-1 to disable; 0 to show immediately on load)</small>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Exit-intent popup</th>
							<td>
								<input type="checkbox" input-all-false-check="popupally-conditional-display-<?php echo $id; ?>" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[enable-exit-intent-popup]" <?php checked($setting['enable-exit-intent-popup'], 'true'); ?> value="true"/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Embedded sign up</th>
							<td>
								<input type="checkbox" input-all-false-check="popupally-conditional-display-<?php echo $id; ?>" id="embedded-<?php echo $id; ?>" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[enable-embedded]" <?php checked($setting['enable-embedded'], 'true'); ?> value="true"/>
								<label hide-toggle data-dependency="embedded-<?php echo $id; ?>" data-dependency-value="true">Show sign up box at
									<select name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[embedded-location]">
										<option <?php selected($setting['embedded-location'], 'none'); ?> value="none">None</option>
										<option <?php selected($setting['embedded-location'], 'post-start'); ?> value="post-start">start of post/page content</option>
										<option <?php selected($setting['embedded-location'], 'post-end'); ?> value="post-end">end of post/page content</option>
										<option <?php selected($setting['embedded-location'], 'page-end'); ?> value="page-end">bottom of the page</option>
									</select>
								</label>
							</td>
						</tr>
					</tbody>
				</table>
			</fieldset>
			<fieldset class="popupally-fieldset popupally-conditional-display-<?php echo $id; ?>">
				<legend>Show this popup on which posts/pages?</legend>
				<table id="page-settings-<?php echo $id; ?>" class="form-table form-table-popupally-style-integration">
					<tbody>
						<tr valign="top">
							<th scope="row">Show for all pages?</th>
							<td>
								<input type="checkbox" id="show-all-<?php echo $id; ?>" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[show-all]" <?php checked($setting['show-all'], 'true'); ?> value="true"/>
							</td>
						</tr>
						<tr valign="top" hide-toggle data-dependency="show-all-<?php echo $id; ?>" data-dependency-value="false">
							<th scope="row">Use for only these posts/pages</th>
							<td>
								<div class="page-selection-wrapper">
									<input readonly type="text" class="selected-num-status" update-all-trigger="#include-all-pages-<?php echo $id; ?>" update-num-trigger=".include-page-<?php echo $id; ?>"><label> pages selected</label>
									<div class="include-selection page-selection-scroll">
										<input type="checkbox" <?php echo isset($setting['include']['all-pages'])?'checked':''; ?> id="include-all-pages-<?php echo $id; ?>" value="true" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[include][all-pages]"><label for="include-all-pages-<?php echo $id; ?>">All pages</label>
										<ul>
											<li>
												<label>Special Pages</label>
												<ul>
													<li>
														<input class="include-page-<?php echo $id; ?>" <?php echo isset($setting['include']['front-page'])?'checked':''; ?> id="include-<?php echo $id; ?>-front-page" disable-toggle data-dependency="include-all-pages-<?php echo $id; ?>" data-dependency-value="false" type="checkbox" value="true" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[include][front-page]"><label for="include-<?php echo $id; ?>-front-page">Front Page</label>
													</li>
													<li>
														<label>Category Pages</label>
														<ul>
															<?php foreach ($categories as $category) { ?>
																<li>
																	<input class="include-page-<?php echo $id; ?>" <?php echo isset($setting['include']['category-' . $category->cat_ID])?'checked':''; ?> id="include-<?php echo $id; ?>-category-<?php echo $category->cat_ID; ?>" disable-toggle data-dependency="include-all-pages-<?php echo $id; ?>" data-dependency-value="false" type="checkbox" value="true" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[include][category-<?php echo $category->cat_ID; ?>]"><label for="include-<?php echo $id; ?>-category-<?php echo $category->cat_ID; ?>"><?php echo esc_attr($category->name); ?></label>
																</li>
															<?php } ?>
														</ul>
													</li>
												</ul>
											</li>
										</ul>
										<ul>
										<?php $depth = array();
										foreach ($pages as $page) {
											if (0 === $page->post_parent) {
												if (count($depth) > 0) {
													while(count($depth) > 0) {
														array_pop($depth);
														?></ul></li><?php
													}
												} else {
													?></li><?php
												}
											} elseif (end($depth) === $page->post_parent) {
											} elseif (in_array($page->post_parent, $depth)) {
												while(end($depth) !== $page->post_parent) {
													array_pop($depth);
													?></ul></li><?php
												}
											} else {
												$depth []= $page->post_parent;
												?><ul><?php
											}
										?>
											<li>
												<input class="include-page-<?php echo $id; ?>" <?php echo isset($setting['include'][$page->ID])?'checked':''; ?> id="include-<?php echo $id; ?>-<?php echo $page->ID; ?>" disable-toggle data-dependency="include-all-pages-<?php echo $id; ?>" data-dependency-value="false" type="checkbox" value="true" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[include][<?php echo $page->ID; ?>]"><label for="include-<?php echo $id; ?>-<?php echo $page->ID; ?>"><?php echo $page->post_title . ' (' . $page->ID . ')'; ?></label>
										<?php }

										if (count($depth) > 0) {
											while(count($depth) > 0) {
												array_pop($depth);
												?></ul></li><?php
											}
										} else {
											?></li><?php
										}
										?>
										</ul>
									</div>
								</div>
								<div class="page-selection-wrapper">
									<input readonly type="text" class="selected-num-status" update-all-trigger="#include-all-posts-<?php echo $id; ?>" update-num-trigger=".include-post-<?php echo $id; ?>"><label> posts selected</label>
									<div class="include-selection page-selection-scroll">
										<input type="checkbox" <?php echo isset($setting['include']['all-posts'])?'checked':''; ?> id="include-all-posts-<?php echo $id; ?>" value="true" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[include][all-posts]"><label for="include-all-posts-<?php echo $id; ?>">All posts</label>
										<ul>
										<?php foreach ($posts as $post) { ?>
											<li>
												<input class="include-post-<?php echo $id; ?>" <?php echo isset($setting['include'][$post->ID])?'checked':''; ?> id="include-<?php echo $id; ?>-<?php echo $post->ID; ?>" disable-toggle data-dependency="include-all-posts-<?php echo $id; ?>" data-dependency-value="false" type="checkbox" value="true" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[include][<?php echo $post->ID; ?>]"><label for="include-<?php echo $id; ?>-<?php echo $post->ID; ?>"><?php echo $post->post_title . ' (' . $post->ID . ')'; ?></label>
											</li>
										<?php } ?>
										</ul>
									</div>
								</div>
							</td>
						</tr>
						<tr valign="top" hide-toggle data-dependency="show-all-<?php echo $id; ?>" data-dependency-value="true">
							<th scope="row">Except for these posts/pages</th>
							<td>
								<div class="page-selection-wrapper">
									<input readonly type="text" class="selected-num-status" update-all-trigger="#exclude-all-pages-<?php echo $id; ?>" update-num-trigger=".exclude-page-<?php echo $id; ?>"><label> pages selected</label>
									<div class="exclude-selection page-selection-scroll">
										<input type="checkbox" <?php echo isset($setting['exclude']['all-pages'])?'checked':''; ?> id="exclude-all-pages-<?php echo $id; ?>" value="true" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[exclude][all-pages]"><label for="exclude-all-pages-<?php echo $id; ?>">All pages</label>
										<ul>
											<li>
												<label>Special Pages</label>
												<ul>
													<li>
														<input class="exclude-page-<?php echo $id; ?>" <?php echo isset($setting['exclude']['front-page'])?'checked':''; ?> id="exclude-<?php echo $id; ?>-front-page" disable-toggle data-dependency="exclude-all-pages-<?php echo $id; ?>" data-dependency-value="false" type="checkbox" value="true" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[exclude][front-page]"><label for="exclude-<?php echo $id; ?>-front-page">Front Page</label>
													</li>
													<li>
														<label>Category Pages</label>
														<ul>
															<?php foreach ($categories as $category) { ?>
																<li>
																	<input class="exclude-page-<?php echo $id; ?>" <?php echo isset($setting['exclude']['category-' . $category->cat_ID])?'checked':''; ?> id="exclude-<?php echo $id; ?>-category-<?php echo $category->cat_ID; ?>" disable-toggle data-dependency="exclude-all-pages-<?php echo $id; ?>" data-dependency-value="false" type="checkbox" value="true" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[exclude][category-<?php echo $category->cat_ID; ?>]"><label for="exclude-<?php echo $id; ?>-category-<?php echo $category->cat_ID; ?>"><?php echo esc_attr($category->name); ?></label>
																</li>
															<?php } ?>
														</ul>
													</li>
												</ul>
											</li>
										</ul>
										<ul>
										<?php $depth = array();
										foreach ($pages as $page) {
											if (0 === $page->post_parent) {
												if (count($depth) > 0) {
													while(count($depth) > 0) {
														array_pop($depth);
														?></ul></li><?php
													}
												} else {
													?></li><?php
												}
											} elseif (end($depth) === $page->post_parent) {
											} elseif (in_array($page->post_parent, $depth)) {
												while(end($depth) !== $page->post_parent) {
													array_pop($depth);
													?></ul></li><?php
												}
											} else {
												$depth []= $page->post_parent;
												?><ul><?php
											}
										?>
											<li>
												<input class="exclude-page-<?php echo $id; ?>" <?php echo isset($setting['exclude'][$page->ID])?'checked':''; ?> id="exclude-<?php echo $id; ?>-<?php echo $page->ID; ?>" disable-toggle data-dependency="exclude-all-pages-<?php echo $id; ?>" data-dependency-value="false" type="checkbox" value="true" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[exclude][<?php echo $page->ID; ?>]"><label for="exclude-<?php echo $id; ?>-<?php echo $page->ID; ?>"><?php echo $page->post_title . ' (' . $page->ID . ')'; ?></label>
										<?php }

										if (count($depth) > 0) {
											while(count($depth) > 0) {
												array_pop($depth);
												?></ul></li><?php
											}
										} else {
											?></li><?php
										}
										?>
										</ul>
									</div>
								</div>
								<div class="page-selection-wrapper">
									<input readonly type="text" class="selected-num-status" update-all-trigger="#exclude-all-posts-<?php echo $id; ?>" update-num-trigger=".exclude-post-<?php echo $id; ?>"><label> posts selected</label>
									<div class="exclude-selection page-selection-scroll">
										<input type="checkbox" <?php echo isset($setting['exclude']['all-posts'])?'checked':''; ?> id="exclude-all-posts-<?php echo $id; ?>" value="true" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[exclude][all-posts]"><label for="exclude-all-posts-<?php echo $id; ?>">All posts</label>
										<ul>
										<?php foreach ($posts as $post) { ?>
											<li>
												<input class="exclude-post-<?php echo $id; ?>" <?php echo isset($setting['exclude'][$post->ID])?'checked':''; ?> id="exclude-<?php echo $id; ?>-<?php echo $post->ID; ?>" disable-toggle data-dependency="exclude-all-posts-<?php echo $id; ?>" data-dependency-value="false" type="checkbox" value="true" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[exclude][<?php echo $post->ID; ?>]"><label for="exclude-<?php echo $id; ?>-<?php echo $post->ID; ?>"><?php echo $post->post_title . ' (' . $post->ID . ')'; ?></label>
											</li>
										<?php } ?>
										</ul>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</fieldset>
			<fieldset class="popupally-fieldset popupally-conditional-display-<?php echo $id; ?>">
				<legend>How to stop showing this popup</legend>
				<table id="page-settings-<?php echo $id; ?>" class="form-table form-table-popupally-style-integration">
					<tbody>
						<tr valign="top">
							<th scope="row">Show popup every </th>
							<td>
								<input name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[cookie-duration]" type="text" size="4" value="<?php echo $setting['cookie-duration']; ?>"> days. (Recommend '14' days)
								<br/>
								<small>
									<ul>
										<li>-1: re-appear on every refresh/new page load. <strong>For testing ONLY!</strong></li>
										<li>0: re-appear after closing and re-opening the browser</li>
										<li>1+: re-appear after the defined number of days.</li>
									</ul>
								</small>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Show Thank You Page Setup</th>
							<td>
								<input <?php if (!empty($setting['thank-you'])) {echo 'checked';} ?> type="checkbox" value="true" id="show-thank-you-setup-<?php echo $id; ?>" /> (Advanced functionality. Make sure to read the <a href="http://ambitionally.com/popupally/tutorial/thank-you-page-setup">Thank You Page Setup Tutorial</a> before enabling.)
							</td>
						</tr>
						<tr valign="top" hide-toggle data-dependency="show-thank-you-setup-<?php echo $id; ?>" data-dependency-value="true">
							<th scope="row">Thank you page after signing-up</th>
							<td>
								<input readonly type="text" class="selected-num-status" update-num-trigger=".thank-you-page-<?php echo $id; ?>"><label> pages selected</label>
								<div class="include-selection page-selection-scroll">
									<ul>
									<?php $depth = array();
									foreach ($pages as $page) {
										if (0 === $page->post_parent) {
											if (count($depth) > 0) {
												while(count($depth) > 0) {
													array_pop($depth);
													?></ul></li><?php
												}
											} else {
												?></li><?php
											}
										} elseif (end($depth) === $page->post_parent) {
										} elseif (in_array($page->post_parent, $depth)) {
											while(end($depth) !== $page->post_parent) {
												array_pop($depth);
												?></ul></li><?php
											}
										} else {
											$depth []= $page->post_parent;
											?><ul><?php
										}
									?>
										<li>
											<input class="thank-you-page-<?php echo $id; ?>" <?php echo isset($setting['thank-you'][$page->ID])?'checked':''; ?> id="thank-you-<?php echo $id; ?>-<?php echo $page->ID; ?>" type="checkbox" value="true" name="<?php echo PopupAlly::SETTING_KEY_DISPLAY . '[' . $id . ']'; ?>[thank-you][<?php echo $page->ID; ?>]"><label for="thank-you-<?php echo $id; ?>-<?php echo $page->ID; ?>"><?php echo $page->post_title . ' (' . $page->ID . ')'; ?></label>
									<?php }

									if (count($depth) > 0) {
										while(count($depth) > 0) {
											array_pop($depth);
											?></ul></li><?php
										}
									} else {
										?></li><?php
									}
									?>
									</ul>
								</div>
							</td>
						</tr>
						<tr valign="top" hide-toggle data-dependency="show-thank-you-setup-<?php echo $id; ?>" data-dependency-value="true">
							<th scope="row">Or you can put the following script on the thank you page (need to be hosted on <?php $url_info = parse_url(get_bloginfo('wpurl')); echo esc_attr($url_info['host']); ?>)</th>
							<td>
								<textarea class="full-width" rows="4" readonly><?php echo esc_attr(str_replace('##cookie_name##', $style[$id]['cookie-name'], $disable)); ?></textarea>
							</td>
						</tr>
					</tbody>
				</table>
			</fieldset>
		</div>
		<?php } ?>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
</div>
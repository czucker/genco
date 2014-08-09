<div class="wrap">
	<h2><?php echo $set->get_title(); ?></h2>
	<div id="vp-wrap" class="vp-wrap">
		<div id="vp-option-panel"class="vp-option-panel <?php echo ($set->get_layout() === 'fixed') ? 'fixed-layout' : 'fluid-layout' ; ?>">
			<div class="vp-left-panel">
				<div id="vp-logo" class="vp-logo">
					<img src="<?php echo VP_Util_Res::img($set->get_logo()); ?>" alt="<?php echo $set->get_title(); ?>" />
				</div>
				<div id="vp-menus" class="vp-menus">
					<ul class="vp-menu-level-1">
						<?php foreach ($set->get_menus() as $menu): ?>
						<?php $menus          = $set->get_menus(); ?>
						<?php $is_first_lvl_1 = $menu === reset($menus); ?>
						<?php if ($is_first_lvl_1): ?>
						<li class="vp-current">
						<?php else: ?>
						<li>
						<?php endif; ?>
							<?php if ($menu->get_menus()): ?>
							<a href="#<?php echo $menu->get_name(); ?>" class="vp-js-menu-dropdown vp-menu-dropdown">
							<?php else: ?>
							<a href="#<?php echo $menu->get_name(); ?>" class="vp-js-menu-goto vp-menu-goto">
							<?php endif; ?>
								<?php
								$icon = $menu->get_icon();
								$font_awesome = VP_Util_Res::is_font_awesome($icon);
								if ($font_awesome !== false):
									VP_Util_Text::print_if_exists($font_awesome, '<i class="fa %s"></i>');
								else:
									VP_Util_Text::print_if_exists(VP_Util_Res::img($icon), '<i class="custom-menu-icon" style="background-image: url(\'%s\');"></i>');
								endif;
								?>
								<span><?php echo $menu->get_title(); ?></span>
							</a>
							<?php if ($menu->get_menus()): ?>
							<ul class="vp-menu-level-2">
								<?php foreach ($menu->get_menus() as $submenu): ?>
								<?php $submenus = $menu->get_menus(); ?>
								<?php if ($is_first_lvl_1 and $submenu === reset($submenus)): ?>
								<li class="vp-current">
								<?php else: ?>
								<li>
								<?php endif; ?>
									<a href="#<?php echo $submenu->get_name(); ?>" class="vp-js-menu-goto vp-menu-goto">
										<?php
										$sub_icon = $submenu->get_icon();
										$font_awesome = VP_Util_Res::is_font_awesome($sub_icon);
										if ($font_awesome !== false):
											VP_Util_Text::print_if_exists($font_awesome, '<i class="fa %s"></i>');
										else:
											VP_Util_Text::print_if_exists(VP_Util_Res::img($sub_icon), '<i class="custom-menu-icon" style="background-image: url(\'%s\');"></i>');
										endif;
										?>
										<span><?php echo $submenu->get_title(); ?></span>
									</a>
								</li>
								<?php endforeach; ?>
							</ul>
							<?php endif; ?>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<div class="vp-right-panel">
				<form id="vp-option-form" class="vp-option-form vp-js-option-form" method="POST">
					<div id="vp-submit-top" class="vp-submit top">
						<div class="inner">
							<input class="vp-save vp-button button button-primary" type="submit" value="<?php _e('Save Changes', 'vp_textdomain'); ?>" />
							<p class="vp-js-save-loader save-loader" style="display: none;"><img src="<?php VP_Util_Res::img_out('ajax-loader.gif', ''); ?>" /><?php _e('Saving Now', 'vp_textdomain'); ?></p>
							<p class="vp-js-save-status save-status" style="display: none;"></p>
						</div>
					</div>
					<?php foreach ($set->get_menus() as $menu): ?>
					<?php $menus = $set->get_menus(); ?>
					<?php if ($menu === reset($menus)): ?>
						<?php echo $menu->render(array('current' => 1)); ?>
					<?php else: ?>
						<?php echo $menu->render(array('current' => 0)); ?>
					<?php endif; ?>
					<?php endforeach; ?>
					<div id="vp-submit-bottom" class="vp-submit bottom">
						<div class="inner">
							<input class="vp-save vp-button button button-primary" type="submit" value="<?php _e('Save Changes', 'vp_textdomain'); ?>" />
							<p class="vp-js-save-loader save-loader" style="display: none;"><img src="<?php VP_Util_Res::img_out('ajax-loader.gif', ''); ?>" /><?php _e('Saving Now', 'vp_textdomain'); ?></p>
							<p class="vp-js-save-status save-status" style="display: none;"></p>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div id="vp-copyright" class="vp-copyright">
			<p><?php printf(__('This option panel is built using <a href="http://vafpress.com/vafpress-framework">Vafpress Framework %s</a> powered by <a href="http://vafpress.com">Vafpress</a>', 'vp_textdomain'), VP_VERSION); ?></p>
		</div>

		<?php
			if ( current_user_can( 'manage_options' ) ) {	
				// Import Theme Options
				$data = file_get_contents( get_template_directory() . '/includes/plugins/importer/data/theme_options.txt' );

				?>
				<script type="text/javascript">
				jQuery(document).ready(function() {

					if ( jQuery('.hb-import-success').length ){
						setTimeout(function(){
							jQuery('.hb-import-success').css('display', 'none');
						}, 15000);
					}

					jQuery( ".hb-import-button" ).on( "click", function(e) {
						e.preventDefault();

						if ( jQuery(this).hasClass('light-demo-import') ){
							if (!jQuery(this).hasClass('activated_button')){
								jQuery(".hb-import-button").css("opacity", "0.3").addClass("activated_button");
								jQuery('.hb-import-loader').css("display","block");
								var json_options_obj = <?php echo $data; ?>;
								var json_options = JSON.stringify(json_options_obj);
					   			var data = {action: 'vp_ajax_' + vp_opt.name + '_import_option', option: json_options, nonce : vp_opt.nonce};
					   			jQuery.post(ajaxurl, data, function(response) {
					   				if ( response.status )
					   				{
					   					location.href = "<?php echo admin_url('themes.php?page=highend_options&import_content_data=true&light_import=yes'); ?>";
					   				}
					   				else 
					   				{
					   					alert ("Failed to import the content.");
					   				}

					   			}, 'JSON');
					   		}
						} else {
							if (!jQuery(this).hasClass('activated_button')){
								jQuery(".hb-import-button").css("opacity", "0.3").addClass("activated_button");
								jQuery('.hb-import-loader').css("display","block");
								var json_options_obj = <?php echo $data; ?>;
								var json_options = JSON.stringify(json_options_obj);
					   			var data = {action: 'vp_ajax_' + vp_opt.name + '_import_option', option: json_options, nonce : vp_opt.nonce};
					   			jQuery.post(ajaxurl, data, function(response) {
					   				if ( response.status )
					   				{
					   					location.href = "<?php echo admin_url('themes.php?page=highend_options&import_content_data=true'); ?>";
					   				}
					   				else 
					   				{
					   					alert ("Failed to import the content.");
					   				}

					   			}, 'JSON');
					   		}
				   		}
					});
					
				});
				</script>
				<div class="hb-import-loader" style="display:none;position:fixed; top:50px; right:0px; background-color: #323436; color: #FFF; padding: 10px 15px;border-left: 4px solid #7ad03a;z-index:9999;width:350px;">The Demo Content is currently being imported. This may take a while. Do not interrupt the process. The page will be reloaded when the import is finished.</div>
				<?php 
			} 

			
			if ( isset ( $_GET['imported']) && $_GET['imported'] == 'success') {
			?>
				<div class="hb-import-success" style="display:blockb0;position:fixed; top:50px; right:0px; background-color: #323436; color: #FFF; padding: 10px 15px;border-left: 4px solid #7ad03a;z-index:9999;width:350px;">The Demo content has been successfully imported.</div>
			<?php } ?>

	</div>
</div>
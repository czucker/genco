<?php class EModal_View_Admin_Addons extends EModal_View {
	public function output()
	{
		extract($this->values);?>
		<div class="wrap">
			<h2><?php esc_html_e(__($title, EMCORE_SLUG) );?></h2>
			<div id="poststuff">
				<div id="post-body" class="metabox-holder">
					<div id="post-body-content"><?php
					    $addons = EModal_License::available_addons();?>
					    <ul class="addons-available">
					        <?php
							$plugins = get_plugins();
							$installed_plugins = array();
							foreach($plugins as $key => $plugin){
								$is_active = is_plugin_active($key);
								$installed_plugin = array(
									'is_active' => $is_active
								);
								$installerUrl = add_query_arg(
									array(
										'action' => 'activate',
										'plugin' => $key,
										'em' => 1
									),
									network_admin_url('plugins.php')
									//admin_url('update.php')
								);
								$installed_plugin["activation_url"] = $is_active ? "" : wp_nonce_url($installerUrl, 'activate-plugin_' . $key);


								$installerUrl = add_query_arg(
									array(
										'action' => 'deactivate',
										'plugin' => $key,
										'em' => 1
									),
									network_admin_url('plugins.php')
									//admin_url('update.php')
								);
								$installed_plugin["deactivation_url"] = !$is_active ? "" : wp_nonce_url($installerUrl, 'deactivate-plugin_' . $key);
								$installed_plugins[$key] = $installed_plugin;
							}
							$existing_addon_images = apply_filters('emodal_existing_addon_images', array());
							if(!empty($addons))
							{
						        foreach($addons as $addon) :?>
						        <li class="available-addon-inner">
						            <h3><?php esc_html_e($addon->name)?></h3>
						            <?php $image = in_array($addon->slug, $existing_addon_images) ? EMCORE_URL .'/assets/images/addons/' . $addon->slug .'.jpg' : $addon->image;?>
						            <img class="addon-thumbnail" src="<?php esc_attr_e($image)?>">
						            <p><?php esc_html_e($addon->excerpt)?></p>
						            <hr/><?php
						            if(!empty($addon->download_link) && !isset($installed_plugins[$addon->slug.'/'.$addon->slug.'.php']))
						            {
										$installerUrl = add_query_arg(
											array(
												'action' => 'install-plugin',
												'plugin' => $addon->slug,
												'edd_sample_plugin' => 1
											),
											network_admin_url('update.php')
											//admin_url('update.php')
										);
										$installerUrl = wp_nonce_url($installerUrl, 'install-plugin_' . $addon->slug)?>
						                <span class="action-links"><?php
										printf(
											'<a class="button install" href="%s">%s</a>',
											esc_attr($installerUrl),
											__('Install')
										);?>
										</span><?php
						            }
						            elseif(isset($installed_plugins[$addon->slug.'/'.$addon->slug.'.php']['is_active']))
					            	{?>
						                <span class="action-links"><?php
						            		if(!$installed_plugins[$addon->slug.'/'.$addon->slug.'.php']['is_active'])
						            		{
												printf(
													'<a class="button install" href="%s">%s</a>',
													esc_attr($installed_plugins[$addon->slug.'/'.$addon->slug.'.php']["activation_url"]),
													__('Activate')
												);

						            		}
						            		else
						            		{
												printf(
													'<a class="button install" href="%s">%s</a>',
													esc_attr($installed_plugins[$addon->slug.'/'.$addon->slug.'.php']["deactivation_url"]),
													__('Deactivate')
												);
						            		}?>
										</span><?php
					            	}
					            	else
					            	{
						                ?><span class="action-links"><a class="button" target="_blank" href="<?php esc_attr_e($addon->homepage);?>"><?php _e('Get It Now');?></a></span><?php
						            }?>
						            <a href="<?php echo esc_url($addon->homepage);?>" target="_blank"><?php _e('View the entire Add On Specs');?></a>
						        </li>
						        <?php endforeach;				
							}?>
				    </ul>
					</div>
				</div>
				<br class="clear"/>
			</div>
		</div><?php
	}
}
<?php
add_filter('emodal_admin_settings_form_tabs', 'emodal_admin_settings_licenses_tab', 10);
function emodal_admin_settings_licenses_tab($tabs)
{
	$tabs[] = array( 'id' => 'licenses', 'label' => __('Licenses', EMCORE_SLUG) );
	return $tabs;
}

add_action('emodal_admin_settings_form_tab_licenses', 'emodal_admin_settings_form_licenses_tab', 20);
function emodal_admin_settings_form_licenses_tab()
{
	?><table class="form-table">
		<tbody>
			<?php do_action('emodal_admin_settings_form_tab_licenses_settings');?>
		</tbody>
	</table><?php
}


add_action('emodal_admin_settings_form_tab_licenses_settings', 'emodal_admin_settings_form_glicenses_tab_no_licensed_products', 10);
function emodal_admin_settings_form_glicenses_tab_no_licensed_products()
{?>
	<tr class="form-field">
		<th colspan="2" scope="row">
			<p><?php _e( 'No licensed addons detected.',EMCORE_SLUG)?></p>
		</td>
	</tr><?php
}

//add_action('emodal_admin_settings_form_tab_licenses_settings', 'emodal_admin_settings_form_glicenses_tab_access_key', 10);
function emodal_admin_settings_form_glicenses_tab_access_key()
{?>
	<tr class="form-field">
		<th scope="row">
			<label for="access_key"><?php _e('Access Key', EMCORE_SLUG);?></label>
		</th>
		<td>
			<input type="<?php echo emodal_get_option('access_key') ? 'password' : 'text'?>" id="access_key" name="access_key" value="<?php esc_attr_e(emodal_get_option('access_key'))?>" class="regular-text"/>
			<p class="description"><?php _e( 'Enter your access key to unlock addons.',EMCORE_SLUG)?></p>
		</td>
	</tr><?php
}
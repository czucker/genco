<?php
/**
 * TPC! Memory Usage Overview
 * 
 * @package TPC_Memory_Usage
 */

if (!defined('ABSPATH'))
	die('-1');

function tpcmem_config_page() {
	global $tpcmem;

	$updated = false;

	// If a POST has occurred, update the options
	if (isset($_POST['tpc_memory_usage_update'])) {
		// Where to show the comments containing memory usage information
		$_POST['tpc_memory_usage_location'] = esc_html($_POST['tpc_memory_usage_location']);
		
		// What kind of dashboard graph to show (if at all)
		$_POST['tpc_memory_usage_graph'] = esc_html($_POST['tpc_memory_usage_graph']);
		
		// Whether or not to show memory usage in admin footer
		$_POST['tpc_memory_usage_admin_footer'] = (int) $_POST['tpc_memory_usage_admin_footer'];
		
		// Whether or not to record the highest memory usage
		$_POST['tpc_memory_usage_log'] = esc_html($_POST['tpc_memory_usage_log']);
		
		// Who is allowed to view memory usage data
		$_POST['tpc_memory_usage_allowed_users'] = esc_html($_POST['tpc_memory_usage_allowed_users']);
		
		// Threshold for e-mailing administrator about high memory usage
		$_POST['tpc_memory_usage_email_high_usage'] = (int) $_POST['tpc_memory_usage_email_high_usage'];
		
		// Whether or not to log memory usage
		$_POST['tpc_memory_usage_logging'] = in_array($_POST['tpc_memory_usage_logging'], array_keys(tpcmem_get_logging_options()))
			? $_POST['tpc_memory_usage_logging'] : 0;
		
		// How to log memory usage (defaults to 'file' if invalid option is passed)
		$_POST['tpc_memory_usage_logging_type'] = in_array($_POST['tpc_memory_usage_logging_type'], array_keys(tpcmem_get_logging_types())) ? $_POST['tpc_memory_usage_logging_type'] : 'file';
		
		// Who to send the high memory usage e-mail to
		$recipients = &$_POST['tpc_memory_usage_email_recipients'];
		if (isset($recipients) && trim($recipients) != '') {
			if (false !== strpos($recipients, ',')) {
				$addresses = explode(',', $recipients);
				$new_recipients = false;
				foreach ((array) $addresses as $address) {
					if ($address === sanitize_email($address))
						$new_recipients[] = $address;
				}
				$recipients = is_array($new_recipients) ? implode(',', $new_recipients) : '';
			}
		}
		$_POST['tpc_memory_usage_email_recipients'] = $_POST['tpc_memory_usage_email_recipients'];
		
		// Update options in database
		update_option('tpc_memory_usage_location', $_POST['tpc_memory_usage_location']);
		update_option('tpc_memory_usage_graph', $_POST['tpc_memory_usage_graph']);
		update_option('tpc_memory_usage_admin_footer', $_POST['tpc_memory_usage_admin_footer']);
		update_option('tpc_memory_usage_log', $_POST['tpc_memory_usage_log']);
		// Reset current highest memory usage to zero if checked...
		if (isset($_POST['tpc_memory_usage_log_reset']) && $_POST['tpc_memory_usage_log_reset'])
			update_option('tpc_memory_usage_log_highest', get_default_tpcmem_log_to_edit());
		update_option('tpc_memory_usage_allowed_users', $_POST['tpc_memory_usage_allowed_users']);
		update_option('tpc_memory_usage_email_high_usage', $_POST['tpc_memory_usage_email_high_usage']);
		update_option('tpc_memory_usage_email_recipients', $_POST['tpc_memory_usage_email_recipients']);
		update_option('tpc_memory_usage_logging', $_POST['tpc_memory_usage_logging']);
		update_option('tpc_memory_usage_logging_type', $_POST['tpc_memory_usage_logging_type']);

		$updated = true;
	}
	?>
<div class="wrap">
<?php screen_icon('options-general'); ?>
<h2><?php echo esc_html_e('TPC! Memory Usage Settings'); ?></h2>

<?php if ( $updated ): ?>
<div id="message" class="updated fade">
<p><?php esc_html_e('TPC! Memory Usage settings successfully updated!'); ?></p>
</div>
<?php else: ?>
<?php if (!is_writable(TPCMEM_LOG)): ?>
<div id="message" class="error fade">
<p><?php echo esc_html__('The ') . '<em>' . esc_html(TPCMEM_LOG) . '</em> ' . esc_html__('directory is not writable.  This is required for file logging to function.'); ?></p>
</div>
<?php endif; ?>
<?php endif; ?>

<div class="alignright">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post"><input
	type="hidden" name="cmd" value="_s-xclick"> <input type="hidden"
	name="hosted_button_id" value="7666470"> <input type="image"
	src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0"
	name="submit" alt="PayPal - The safer, easier way to pay online!"> <img
	alt="If you have found this plugin to be helpful, please show us your support by donating a few dollars."
	border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1"
	height="1"></form>
</div>

<form method="post" action="">

<h3><?php _e('Basic Settings'); ?></h3>
<table class="form-table" cellspacing="2" cellpadding="5" width="99%">
	<tr>
		<th scope="col" width="30%" valign="top"><label
			for="tpc_memory_usage_location"><?php esc_html_e('Show memory usage comment in'); ?>:</label></th>
		<td><select name="tpc_memory_usage_location"
			id="tpc_memory_usage_location">
			<?php tpcmem_dropdown_display_locations( get_option('tpc_memory_usage_location') ); ?>
		</select></td>
	</tr>
	<tr>
		<th valign="top"><label for="tpc_memory_usage_graph"><?php esc_html_e('Value to use for dashboard graph'); ?>:</label></th>
		<td><select name="tpc_memory_usage_graph" id="tpc_memory_usage_graph">
		<?php tpcmem_dropdown_graph_options( get_option('tpc_memory_usage_graph') ); ?>
		</select></td>
	</tr>
	<tr>
		<th valign="top"><label for="tpc_memory_usage_admin_footer"><?php esc_html_e('Show memory usage in admin footer'); ?>:</label></th>
		<td><select name="tpc_memory_usage_admin_footer"
			id="tpc_memory_usage_admin_footer">
			<?php tpcmem_dropdown_admin_footer( get_option('tpc_memory_usage_admin_footer') ); ?>
		</select></td>
	</tr>
	<tr>
		<th valign="top"><label for="tpc_memory_usage_allowed_users"><?php esc_html_e('Allowed users'); ?>:</label></th>
		<td><select name="tpc_memory_usage_allowed_users"
			id="tpc_memory_usage_allowed_users">
			<?php tpcmem_dropdown_allowed_users( get_option('tpc_memory_usage_allowed_users') ); ?>
		</select></td>
	</tr>
</table>

<h3><?php _e('Logging'); ?></h3>
<table class="form-table" cellspacing="2" cellpadding="5" width="99%">
<tbody>
	<tr>
		<th valign="top"><label for="tpc_memory_usage_log"><?php esc_html_e('Record high usage'); ?>:</label></th>
		<td><select name="tpc_memory_usage_log" id="tpc_memory_usage_log">
		<?php tpcmem_dropdown_log_options( get_option('tpc_memory_usage_log') ); ?>
		</select><br />
		<input type="checkbox" name="tpc_memory_usage_log_reset" id="tpc_memory_usage_log_reset" value="1" />
		<label for="tpc_memory_usage_log_reset">Reset all-time usage record?</label>
		</td>
	</tr>
	<tr>
		<th valign="top"><label for="tpc_memory_usage_logging"><?php esc_html_e('Write to log when'); ?>:</label></th>
		<td>
			<select name="tpc_memory_usage_logging" id="tpc_memory_usage_logging">
			<?php tpcmem_dropdown_logging( get_option('tpc_memory_usage_logging') != '' ? get_option('tpc_memory_usage_logging') : '0' ); ?>
			</select>
		</td>
	</tr>
	<tr>
		<th valign="top"><label for="tpc_memory_usage_logging_type"><?php esc_html_e('Type of log'); ?>:</label></th>
		<td>
			<select name="tpc_memory_usage_logging_type" id="tpc_memory_usage_logging_type">
			<?php tpcmem_dropdown_logging_types( get_option('tpc_memory_usage_logging_type') ); ?>
			</select>
		</td>
	</tr>
</tbody>
</table>

<h3><?php _e('Notifications'); ?></h3>
<table class="form-table" cellspacing="2" cellpadding="5" width="99%">
	<tr>
		<th scope="col" width="30%" valign="top"><label
			for="tpc_memory_usage_email_high_usage"><?php esc_html_e('Notify if memory usage exceeds'); ?>:</label></th>
		<td><select name="tpc_memory_usage_email_high_usage"
			id="tpc_memory_usage_email_high_usage">
			<?php tpcmem_dropdown_email_high_usage( get_option('tpc_memory_usage_email_high_usage') ); ?>
		</select></td>
	</tr>
	<tr>
		<th valign="top"><label for="tpc_memory_usage_email_recipients"><?php esc_html_e('Recipients'); ?>:</label></th>
		<td valign="top">
			<textarea name="tpc_memory_usage_email_recipients" id="tpc_memory_usage_email_recipients" rows="3" cols="35"><?php echo esc_html(get_option('tpc_memory_usage_email_recipients')); ?></textarea>
		</td>
	</tr>
</table>

<p class="submit"><?php if ( function_exists('settings_fields') ) settings_fields('tpc_memory_usage'); ?>
<input type="submit" name="tpc_memory_usage_update"
	value="<?php echo esc_attr('Save Changes'); ?>" /></p>

</form>

</div>
<?php
}

function tpcmem_get_display_locations() {
	return array(
		'header' => 'Header',
		'footer' => 'Footer',
		'none' => 'Do not display'
	);
}

function tpcmem_get_graph_options() {
	return array(
		'current' => 'Current memory usage',
		'peak' => 'Peak memory usage',
		'hide' => 'Do not display'
	);
}

function tpcmem_get_admin_footer_options() {
	return array(
		0 => 'No',
		1 => 'Yes'
	);
}

function tpcmem_get_log_options() {
	return array(
		'high' => 'On',
		'off' => 'Off'
	);
}

function tpcmem_get_allowed_users() {
	return array(
		'admin' => 'Administrators only',
		'all' => 'Everyone',
		'off' => 'Disabled'
	);
}

function tpcmem_get_high_usage_options() {
	// in MB
	return array( 0, 2, 4, 8, 16, 32, 64, 128 );
}

function tpcmem_get_logging_options() {
	global $tpcmem;
	return $tpcmem->getLogModes();
}

function tpcmem_get_logging_types() {
	return array('file' => 'File', 'db' => 'Database');
}

function tpcmem_dropdown_display_locations($selected = false) {
	$d = ''; // default
	$l = ''; // other location(s)

	$locations = tpcmem_get_display_locations();

	foreach ( (array)$locations as $key => $loc ) {
		$key = esc_attr($key);
		$loc = esc_html($loc);

		if ( $key == $selected )
			$d = "<option value='$key' selected='selected'>$loc</option>";
		else
			$l .= "<option value='$key'>$loc</option>";
	}

	echo $d . $l;
}

function tpcmem_dropdown_graph_options($selected = false) {
	$d = ''; // default
	$o = ''; // other options

	$options = tpcmem_get_graph_options();

	foreach ( (array)$options as $key => $opt ) {
		$key = esc_attr($key);
		$opt = esc_html($opt);

		if ( $key == $selected )
			$d = "<option value='$key' selected='selected'>$opt</option>";
		else
			$o .= "<option value='$key'>$opt</option>";
	}

	echo $d . $o;
}

function tpcmem_dropdown_admin_footer($selected = false) {
	$d = ''; // default
	$o = ''; // other options

	$options = tpcmem_get_admin_footer_options();

	foreach ( (array)$options as $key => $opt ) {
		$key = esc_attr($key);
		$opt = esc_html($opt);

		if ( $key == $selected )
			$d = "<option value='$key' selected='selected'>$opt</option>";
		else
			$o .= "<option value='$key'>$opt</option>";
	}

	echo $d . $o;
}

function tpcmem_dropdown_log_options($selected = false) {
	$d = ''; // default
	$o = ''; // other options

	$options = tpcmem_get_log_options();

	foreach ( (array)$options as $key => $opt ) {
		$key = esc_attr($key);
		$opt = esc_html($opt);

		if ( $key == $selected )
			$d = "<option value='$key' selected='selected'>$opt</option>";
		else
			$o .= "<option value='$key'>$opt</option>";
	}

	echo $d . $o;
}

function tpcmem_dropdown_allowed_users($selected = false) {
	$d = ''; // default
	$o = ''; // other options

	$options = tpcmem_get_allowed_users();

	foreach ( (array)$options as $key => $opt ) {
		$key = esc_attr($key);
		$opt = esc_html($opt);

		if ( $key == $selected )
			$d = "<option value='$key' selected='selected'>$opt</option>";
		else
			$o .= "<option value='$key'>$opt</option>";
	}

	echo $d . $o;
}

function tpcmem_dropdown_email_high_usage($selected = false) {
	$d = ''; // default
	$o = ''; // other options

	$options = tpcmem_get_high_usage_options();

	foreach ( (array)$options as $opt ) {
		$key = esc_attr($opt);
		$opt = esc_html($opt . ' MB');

		if ( $key == $selected )
			$d = "<option value='$key' selected='selected'>$opt</option>";
		else
			$o .= "<option value='$key'>$opt</option>";
	}

	echo $d . $o;
}

function tpcmem_dropdown_logging($selected = false) {
	$d = ''; // default
	$o = ''; // other options

	$options = tpcmem_get_logging_options();

	foreach ((array) $options as $optionKey => $optionName) {
		$optionKey = esc_attr($optionKey);
		$optionName = esc_html($optionName);

		if ( $optionKey == $selected )
			$d = "<option value='$optionKey' selected='selected'>$optionName</option>";
		else
			$o .= "<option value='$optionKey'>$optionName</option>";
	}

	echo $d . $o;
}

function tpcmem_dropdown_logging_types($selected = false) {
	$d = ''; // default
	$o = ''; // other options

	$options = tpcmem_get_logging_types();

	foreach ((array) $options as $optionKey => $optionName) {
		$optionKey = esc_attr($optionKey);
		$optionName = esc_html($optionName);

		if ( $optionKey == $selected )
			$d = "<option value='$optionKey' selected='selected'>$optionName</option>";
		else
			$o .= "<option value='$optionKey'>$optionName</option>";
	}

	echo $d . $o;
}

tpcmem_config_page();
<?php
/*
Addon Name: Membership Verify and Repair
Description: Checks and repairs the membership plugins tables
Author: Barry (Incsub)
Author URI: http://caffeinatedb.com
*/

class M_Runcommunications {

	function __construct() {
		// Add advanced content
		add_action('membership_option_menu_advanced', array(&$this, 'handle_communications_panel'));
	}

	function M_Runcommunications() {
		$this->__construct();
	}

	function handle_communications_panel() {
		global $action, $page, $M_options;

		wp_reset_vars( array('action', 'page') );

		?>
		<div class='wrap nosubsub'>
			<div class="icon32" id="icon-tools"><br></div>
			<h2><?php _e('Run Communications','membership'); ?></h2>

			<?php
			if ( isset($_GET['msg']) ) {
				echo '<div id="message" class="updated fade"><p>' . $messages[(int) $_GET['msg']] . '</p></div>';
				$_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
			}
			?>

			<p><?php _e('You can run the communications process manually to test your messages.','membership'); ?></p>
			<p>
			<?php echo "<a href='" . wp_nonce_url("?page=" . $page. "&amp;tab=advanced&amp;comms=yes", 'run-comms') . "' class='button'>" . __('Run Communications','membership') . "</a>&nbsp;&nbsp;"; ?>
			</p>

			<?php
				if(isset($_GET['comms'])) {
					check_admin_referer('run-comms');
					M_Communication_process();
					?>
					<p><strong><?php _e('Communication process executed successfully.','membership'); ?></strong></p>
					<?php

				}
			?>
		</div> <!-- wrap -->
		<?php
	}

}

$membership_runcommunications = new M_Runcommunications();

?>
<?php

// +----------------------------------------------------------------------+
// | Copyright Incsub (http://incsub.com/)                                |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License, version 2, as  |
// | published by the Free Software Foundation.                           |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to the Free Software          |
// | Foundation, Inc., 51 Franklin St, Fifth Floor, Boston,               |
// | MA 02110-1301 USA                                                    |
// +----------------------------------------------------------------------+

/**
 * Rule class responsible for menu protection.
 *
 * @category Membership
 * @package Model
 * @subpackage Rule
 */
class Membership_Model_Rule_Menu extends Membership_Model_Rule {

	var $name = 'menu';
	var $label = 'Menu';
	var $description = 'Allows specific menu items to be protected.';

	var $rulearea = 'public';

	function admin_main($data) {
		if(!$data) $data = array();
		?>
		<div class='level-operation' id='main-menu'>
			<h2 class='sidebar-name'><?php _e('Menu', 'membership');?><span><a href='#remove' id='remove-menu' class='removelink' title='<?php _e("Remove Menu from this rules area.",'membership'); ?>'><?php _e('Remove','membership'); ?></a></span></h2>
			<div class='inner-operation'>
				<p><?php _e('Select the Menu items to be covered by this rule by checking the box next to the relevant menu labels.','membership'); ?></p>
				<?php

				$navs = wp_get_nav_menus( array('orderby' => 'name') );

					if(!empty($navs)) {
						?>
						<table cellspacing="0" class="widefat fixed">
							<thead>
							<tr>
								<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
								<th style="" class="manage-column column-name" id="name" scope="col"><?php _e('Menu / Item title', 'membership'); ?></th>
								<th style="" class="manage-column column-name" id="drip" scope="col"><?php _e('Available/blocked after ', 'membership'); ?><small><?php _e('(0 days for immediate)', 'membership'); ?></small></th>
								</tr>
							</thead>

							<tfoot>
							<tr>
								<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
								<th style="" class="manage-column column-name" id="name" scope="col"><?php _e('Menu / Item title', 'membership'); ?></th>
								<th style="" class="manage-column column-name" id="drip" scope="col"><?php _e('Available/blocked after ', 'membership'); ?><small><?php _e('(0 days for immediate)', 'membership'); ?></small></th>
								</tr>
							</tfoot>

							<tbody>

								<?php
									$menu_ids = $this->get_menu_ids( $data );
									$drip_days = $this->get_menu_days( $data );
									$drip_units = $this->get_menu_days_units( $data );
								?>
								<?php
								foreach($navs as $key => $nav) {
									?>
									<tr valign="middle" class="alternate" id="menu-<?php echo $nav->term_id; ?>-0">
										<td class="column-name" colspan='3'>
											<strong><?php echo __('MENU','membership') . " - " . esc_html($nav->name); ?></strong>
										</td>
								    </tr>
									<?php
									$items = wp_get_nav_menu_items($nav->term_id);
									if(!empty($items)) {
										foreach($items as $ikey => $item) {
											?>
											<tr valign="middle" class="alternate" id="menu-<?php //echo $nav->term_id . '-'; ?><?php echo $item->ID; ?>">
												<th class="check-column" scope="row">
													<input type="checkbox" value="<?php echo $item->ID; ?>" name="menu[<?php echo $ikey; ?>][id]" <?php if(in_array($item->ID, $menu_ids)) echo 'checked="checked"'; ?>>
												</th>
												<td class="column-name">
													<strong>&nbsp;&#8211;&nbsp;<?php if($item->menu_item_parent != 0) echo "&#8211;&nbsp;"; ?><?php echo esc_html($item->title); ?></strong>
												</td>
												<td class="column-drip">
													<?php
													    $value = 0;
														$use_default = true;
														if( $ikey < count( $drip_days ) && in_array( $item->ID, $menu_ids ) ) {
															$value = ! empty( $drip_days ) && (! empty( $drip_days[$ikey] ) || 0 == $drip_days[$ikey]) ? $drip_days[$ikey] : 0;
															$use_default = false;
														}
													?>
													<input type="text" value="<?php echo esc_attr( $value ); ?>" name="menu[<?php echo $ikey; ?>][drip]" size="4">
													<select name="menu[<?php echo $ikey; ?>][drip_unit]">
														<?php $default = isset( $drip_units[$ikey] ) && ! empty( $drip_units ) && (selected( $drip_units[$ikey], 'd' ) || selected( $drip_units[$ikey], 'm' ) || selected( $drip_units[$ikey], 'y' )) ? '' : $use_default ? 'selected' : '';  ?>
													    <option value="d" <?php ! $use_default && ! empty( $drip_units ) ? selected( $drip_units[$ikey], 'd' ) : false; ?><?php echo $default; ?>><?php _e( 'Day(s)', 'membership' ) ?></option>
													    <option value="w" <?php ! $use_default && ! empty( $drip_units ) ? selected( $drip_units[$ikey], 'w' ) : false; ?>><?php _e( 'Week(s)', 'membership' ) ?></option>
													    <option value="m" <?php ! $use_default && ! empty( $drip_units ) ? selected( $drip_units[$ikey], 'm' ) : false; ?>><?php _e( 'Month(s)', 'membership' ) ?></option>
													</select>
												</td>

										    </tr>
											<?php
										}
									}
								}
								?>
							</tbody>
						</table>
						<?php
					}
				?>
			</div>
		</div>
		<?php
	}

	function on_positive($data) {

		$this->data = $data;

		add_filter( 'wp_get_nav_menu_items', array(&$this, 'filter_viewable_menus'), 10, 3 );

	}

	function on_negative($data) {

		$this->data = $data;

		add_filter( 'wp_get_nav_menu_items', array(&$this, 'filter_unviewable_menus'), 10, 3 );
	}

	/**
	 * Returns valid post ID's.
	 *
	 * @access public
	 */
	public function get_menu_ids( $data ) {
		// this is a legacy rule
		if( $this->is_legacy_rule( $data ) ) {
			return $data;
		}

		$menu_ids = array();
		foreach( $data as $key => $item ) {
			if( !empty( $item['id'] ) ) {
				$menu_ids[$key] = $item['id'];
			}
		}

		return $menu_ids;
	}

	public function get_dripped_menu_ids( $data ) {
		// Legacy rule, dripped doesn't apply
		if( $this->is_legacy_rule( $data ) ) {
			return $data;
		}

		// Get the key variables
		$menu_ids = $this->get_menu_ids( $data );
		$menu_drip = $this->get_menu_days( $data );
		$menu_unit = $this->get_menu_days_units( $data );

		// New array of ids
		$drip_menu_ids = array();

		$dates = Membership_Model_Level::get_dates( $this->level_data );

		if( !empty( $dates ) ) {
			// If the user has multiple start dates because of different subscriptions, pick the first start date
			$start = strtotime( $dates[0]->startdate );
			foreach( $dates as $date ) {
				$new_start = strtotime( $date->startdate );
				$start = $start > $new_start ? $new_start : $start;
			}

			$now = time();
			$datediff = $now - $start;
			$days = floor($datediff/(60*60*24));  // could be negative, but that doesn't matter

			// Check each page against dripped requirements
			foreach( $menu_ids as $key => $menu ) {
				$days_required = $menu_drip[$key];
				switch( $menu_unit[$key] ) {
					case 'd':
						$days_required = $days_required;
						break;
					case 'w':
						$days_required = $days_required * 7;
						break;
					case 'm':
						$days_required = $days_required * 30;
						break;
				}

				if( $days >= $days_required ) {
					$drip_menu_ids[$key] = $menu;
				}
			}
		} else {
			$drip_menu_ids = $menu_ids;
		}
		return $drip_menu_ids;
	}

	/**
	 * Get availability.
	 *
	 * @access public
	 */
	public function get_menu_days( $data ) {
		// this is a legacy rule
		if( $this->is_legacy_rule( $data ) ) {
			return false;
		}

		$days = array();
		foreach( $data as $key => $item ) {
			if( !empty( $item['drip'] ) || 0 == $item['drip'] ) {
				$val = (int) $item['drip'];
				$days[$key] = ! empty( $val ) || 0 == $val ? $val : 0;
			}
		}

		return $days;
	}

	/**
	 * Get availability units.
	 *
	 * @access public
	 */
	public function get_menu_days_units( $data ) {
		// this is a legacy rule
		if( $this->is_legacy_rule( $data ) ) {
			return false;
		}

		$units = array();
		foreach( $data as $key => $item ) {
			$units[$key] = ! empty( $item['drip_unit'] ) ? $item['drip_unit'] : 'd';
		}
		return $units;
	}

	/**
	 * Check for legacy rule.
	 *
	 * @access public
	 */
	public function is_legacy_rule( $data ) {
		if( is_array( array_pop( $data ) ) ) {
			return false;
		} else {
			return true;
		}
	}



	function filter_viewable_menus($items, $menu, $args) {
		$menu_ids = $this->get_dripped_menu_ids( $this->data );
		if(!empty($items)) {
			foreach($items as $key => $item) {
				if(!in_array($item->ID, $menu_ids) || ($item->menu_item_parent != 0 && !in_array($item->menu_item_parent, $menu_ids))) {
					unset($items[$key]);
				}

			}
		}

		return $items;

	}

	function filter_unviewable_menus($items, $menu, $args) {
		$menu_ids = $this->get_dripped_menu_ids( $this->data );
		if(!empty($items)) {
			foreach($items as $key => $item) {
				if(in_array($item->ID, $menu_ids) || ($item->menu_item_parent != 0 && in_array($item->menu_item_parent, $menu_ids))) {
					unset($items[$key]);
				}

			}
		}

		return $items;

	}

}
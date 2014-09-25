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
 * The rule class responsible for access to general pages.
 *
 * @category Membership
 * @package Model
 * @subpackage Rule
 */
class Membership_Model_Rule_Pages extends Membership_Model_Rule {

	var $allow_page_cascade = false;

	/**
	 * Renders rule settings at access level edit form.
	 *
	 * @access public
	 * @param mixed $data The data associated with this rule.
	 */
	public function admin_main( $data ) {
		global $M_options;

		if ( !$data ) {
			$data = array();
		}

		$exclude = array();
		foreach ( array( 'registration_page', 'account_page', 'subscriptions_page', 'nocontent_page', 'registrationcompleted_page' ) as $page ) {
			if ( isset( $M_options[$page] ) && is_numeric( $M_options[$page] ) ) {
				$exclude[] = $M_options[$page];
			}
		}

		$posts_to_show = !empty( $M_options['membership_page_count'] ) ? $M_options['membership_page_count'] : MEMBERSHIP_PAGE_COUNT;
		$posts = apply_filters( 'staypress_hide_protectable_pages', get_posts( array(
			'numberposts' => $posts_to_show,
			'offset'      => 0,
			'orderby'     => 'post_date',
			'order'       => 'DESC',
			'post_type'   => 'page',
			'post_status' => array('publish', 'virtual'), //Classifieds plugin uses a "virtual" status for some of it's pages
			'exclude'     => $exclude,
		) ) );

		?>
		<div id="main-pages" class="level-operation">
			<h2 class="sidebar-name">
				<?php _e( 'Pages', 'membership' ) ?>
				<span>
					<a id="remove-pages" href="#remove" class="removelink" title="<?php _e( "Remove Pages from this rules area.", 'membership' ) ?>"><?php
						_e( 'Remove', 'membership' )
					?></a>
				</span>
			</h2>

			<div class="inner-operation">
				<p><?php _e( 'Select the Pages to be covered by this rule by checking the box next to the relevant pages title. Pay attention that pages selected as Membership page (in the options) are not listed below.', 'membership' ) ?></p>

				<?php if ( $posts ) : ?>
				<table cellspacing="0" class="widefat fixed">
					<thead>
					<tr>
						<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
						<th style="" class="manage-column column-name" id="name" scope="col"><?php _e('Page title', 'membership'); ?></th>
						<th style="" class="manage-column column-name" id="drip" scope="col"><?php _e('Available/blocked after ', 'membership'); ?><small><?php _e('(0 days for immediate)', 'membership'); ?></small></th>
					</tr>
					</thead>

					<tfoot>
					<tr>
						<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
						<th style="" class="manage-column column-name" id="name" scope="col"><?php _e('Page title', 'membership'); ?></th>
						<th style="" class="manage-column column-name" id="drip" scope="col"><?php _e('Available/blocked after ', 'membership'); ?><small><?php _e('(0 days for immediate)', 'membership'); ?></small></th>
					</tr>
					</tfoot>

					<tbody>
						<?php $key = 0; ?>
						<?php
							$page_ids = $this->get_page_ids( $data );
							$drip_days = $this->get_page_days( $data );
							$drip_units = $this->get_page_days_units( $data );
						?>
						<?php foreach ( $posts as $post ) : ?>
							<?php if ( membership_is_special_page( $post->ID, false ) ) continue; ?>
							<tr valign="middle" class="alternate" id="post-<?php echo $post->ID ?>">
								<th class="check-column" scope="row">
									<input type="checkbox" value="<?php echo $post->ID ?>" name="pages[<?php echo $key; ?>][id]"<?php checked( in_array( $post->ID, $page_ids ) ) ?>>
								</th>
								<td class="column-name">
									<strong><?php echo esc_html( $post->post_title ) ?></strong>
								</td>
								<td class="column-drip">
									<?php
									    $value = 0;
										$use_default = true;
										if( $key < count( $drip_days ) && in_array( $post->ID, $page_ids ) ) {
											$value = ! empty( $drip_days ) && (! empty( $drip_days[$key] ) || 0 == $drip_days[$key]) ? $drip_days[$key] : 0;
											$use_default = false;
										}
									?>
									<input type="text" value="<?php echo esc_attr( $value ); ?>" name="pages[<?php echo $key; ?>][drip]" size="4">
									<select name="pages[<?php echo $key; ?>][drip_unit]">
										<?php $default = isset( $drip_units[$key] ) && ! empty( $drip_units ) && (selected( $drip_units[$key], 'd' ) || selected( $drip_units[$key], 'm' ) || selected( $drip_units[$key], 'y' )) ? '' : $use_default ? 'selected' : '';  ?>
									    <option value="d" <?php ! $use_default && ! empty( $drip_units ) ? selected( $drip_units[$key], 'd' ) : false; ?><?php echo $default; ?>><?php _e( 'Day(s)', 'membership' ) ?></option>
									    <option value="w" <?php ! $use_default && ! empty( $drip_units ) ? selected( $drip_units[$key], 'w' ) : false; ?>><?php _e( 'Week(s)', 'membership' ) ?></option>
									    <option value="m" <?php ! $use_default && ! empty( $drip_units ) ? selected( $drip_units[$key], 'm' ) : false; ?>><?php _e( 'Month(s)', 'membership' ) ?></option>
									</select>
								</td>
							</tr>
							<?php if ( ! membership_is_special_page( $post->ID, false ) ) $key += 1; ?>
						<?php endforeach; ?>

					</tbody>
				</table>
				<?php endif; ?>

				<p class="description"><?php printf( __( "Only the most recent %d pages are shown above.", 'membership' ), $posts_to_show ) ?></p>
			</div>
		</div><?php
	}

	/**
	 * Returns valid page ID's.
	 *
	 * @access public
	 */
	public function get_page_ids( $data ) {
		// this is a legacy rule
		if( $this->is_legacy_rule( $data ) ) {
			return $data;
		}

		$page_ids = array();
		foreach( $data as $key => $item ) {
			if( !empty( $item['id'] ) ) {
				$page_ids[$key] = $item['id'];
			}
		}

		return $page_ids;
	}

	public function get_dripped_page_ids( $data ) {
		// Legacy rule, dripped doesn't apply
		if( $this->is_legacy_rule( $data ) ) {
			return $data;
		}

		// Get the key variables
		$page_ids = $this->get_page_ids( $data );
		$page_drip = $this->get_page_days( $data );
		$page_unit = $this->get_page_days_units( $data );

		// New array of ids
		$drip_page_ids = array();

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

			// Get the key variables
			$page_ids = $this->get_page_ids( $data );
			$page_drip = $this->get_page_days( $data );
			$page_unit = $this->get_page_days_units( $data );



			// Check each page against dripped requirements
			foreach( $page_ids as $key => $page ) {
				$days_required = $page_drip[$key];
				switch( $page_unit[$key] ) {
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
					$drip_page_ids[$key] = $page;
				}
			}
		} else {
			$drip_page_ids = $page_ids;
		}
		return $drip_page_ids;
	}

	/**
	 * Get availability.
	 *
	 * @access public
	 */
	public function get_page_days( $data ) {
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
	public function get_page_days_units( $data ) {
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

	/**
	 * Handles rule's stuff initialization.
	 *
	 * @access public
	 */
	public function on_creation() {
		$this->name = 'pages';
		$this->rulearea = 'public';

		$this->label = esc_html__( 'Pages', 'membership' );
		$this->description = esc_html__( 'Allows specific pages to be protected.', 'membership' );
	}

	/**
	 * Associates positive data with this rule.
	 *
	 * @access public
	 * @param mixed $data The positive data to associate with the rule.
	 */
	public function on_positive( $data ) {
		$this->data = (array) $data;
		add_filter( 'get_pages', array( $this, 'add_viewable_pages_menu' ), 1 );
	}

	/**
	 * Associates negative data with this rule.
	 *
	 * @access public
	 * @param mixed $data The negative data to associate with the rule.
	 */
	public function on_negative( $data ) {
		$this->data = (array) $data;
		add_filter( 'get_pages', array( $this, 'add_unviewable_pages_menu' ), 1 );
	}

	/**
	 * Filets protected pages from array.
	 *
	 * @action get_pages 1
	 *
	 * @param array $pages The array of pages.
	 * @return array Filtered array which doesn't include prohibited pages.
	 */
	public function add_viewable_pages_menu( $pages ) {
		$override_pages = apply_filters( 'membership_override_viewable_pages_menu', array() );
		$page_ids = $this->get_dripped_page_ids( $this->data );

		foreach ( (array)$pages as $key => $page ) {
			if ( $this->allow_page_cascade ) {
				if ( (!in_array( $page->ID, $page_ids) && !in_array( $page->post_parent, $page_ids ) ) && !in_array( $page->ID, (array) $override_pages ) ) {
					unset( $pages[$key] );
				}
			} else {
				if ( (!in_array( $page->ID, $page_ids ) ) && !in_array( $page->ID, (array) $override_pages ) ) {
					unset( $pages[$key] );
				}
			}
		}

		return $pages;
	}

	/**
	 * Filters protected pages from array.
	 *
	 * @action get_pages 1
	 *
	 * @param array $pages The array of pages.
	 * @return array Filtered array which doesn't include prohibited pages.
	 */
	public function add_unviewable_pages_menu( $pages ) {
		$page_ids = $this->get_dripped_page_ids( $this->data );
		foreach ( (array) $pages as $key => $page ) {
			if ( (in_array( $page->ID, $page_ids ) || in_array( $page->post_parent, $page_ids ) ) ) {
				unset( $pages[$key] );
			}
		}

		return $pages;
	}


	/**
	 * Validates the rule on negative assertion.
	 *
	 * @access public
	 * @return boolean TRUE if assertion is successfull, otherwise FALSE.
	 */
	public function validate_negative( $args = null ) {
		$page = get_queried_object();
		$page_ids = $this->get_dripped_page_ids( $this->data );

		if( is_array( $args ) && $args[0]['cascade'] && isset( $page->ID) ) {
			if( $this->validate_parent( $page->ID, $page_ids ) ){
				return true;
			}
		}

		return is_a( $page, 'WP_Post' ) && $page->post_type == 'page'
			? !in_array( $page->ID, $page_ids )
			: parent::validate_negative();
	}

	/**
	 * Validates the rule on positive assertion.
	 *
	 * @access public
	 * @return boolean TRUE if assertion is successfull, otherwise FALSE.
	 */
	public function validate_positive( $args = null ) {
		$page = get_queried_object();
		$page_ids = $this->get_dripped_page_ids( $this->data );
		if( is_array( $args ) && $args[0]['cascade'] && isset( $page->ID) ) {
			if( $this->validate_parent( $page->ID, $page_ids ) ){
				return true;
			}
		}

		return is_a( $page, 'WP_Post' ) && $page->post_type == 'page'
			? in_array( $page->ID, $page_ids )
			: parent::validate_positive();
	}

	/**
	 * Validates the rule on page parents.
	 *
	 * @access public
	 * @return boolean TRUE if assertion is successfull, otherwise FALSE.
	 */
	public function validate_parent( $page_id, $page_ids ) {
		$valid = false;
		$parents = get_post_ancestors( $page_id );
		$parents = array_reverse( $parents );

		foreach( $parents as $key => $parent ) {
			$valid |= in_array( $parent, $page_ids );
		}

		return $valid;
	}



}
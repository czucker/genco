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
 * Rule class responsible for posts protection.
 *
 * @category Membership
 * @package Model
 * @subpackage Rule
 */
class Membership_Model_Rule_Posts extends Membership_Model_Rule {

	var $name = 'posts';
	var $label = 'Posts';
	var $description = 'Allows specific posts to be protected.';

	var $rulearea = 'public';

	function admin_main($data) {
		global $M_options;

		if ( !$data ) {
			$data = array();
		}

		$posts_to_show = !empty( $M_options['membership_post_count'] ) ? $M_options['membership_post_count'] : MEMBERSHIP_POST_COUNT;
		$posts = get_posts( array(
			'numberposts' => $posts_to_show,
			'offset'      => 0,
			'orderby'     => 'post_date',
			'order'       => 'DESC',
			'post_type'   => 'post',
			'post_status' => 'publish'
		) );

		?><div class='level-operation' id='main-posts'>
			<h2 class='sidebar-name'><?php _e('Posts', 'membership');?><span><a href='#remove' id='remove-posts' class='removelink' title='<?php _e("Remove Posts from this rules area.",'membership'); ?>'><?php _e('Remove','membership'); ?></a></span></h2>
			<div class='inner-operation'>
				<p><?php _e('Select the posts to be covered by this rule by checking the box next to the relevant posts title.','membership'); ?></p>
				<?php if ( $posts ) : ?>
					<table cellspacing="0" class="widefat fixed">
						<thead>
						<tr>
							<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
							<th style="" class="manage-column column-name" id="name" scope="col"><?php _e('Post title', 'membership'); ?></th>
							<th style="" class="manage-column column-name" id="drip" scope="col"><?php _e('Available/blocked after ', 'membership'); ?><small><?php _e('(0 days for immediate)', 'membership'); ?></small></th>
							<th style="" class="manage-column column-date" id="date" scope="col"><?php _e('Post date', 'membership'); ?></th>
						</tr>
						</thead>

						<tfoot>
						<tr>
							<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
							<th style="" class="manage-column column-name" id="name" scope="col"><?php _e('Post title', 'membership'); ?></th>
							<th style="" class="manage-column column-name" id="drip" scope="col"><?php _e('Available/blocked after ', 'membership'); ?><small><?php _e('(0 days for immediate)', 'membership'); ?></small></th>
							<th style="" class="manage-column column-date" id="date" scope="col"><?php _e('Post date', 'membership'); ?></th>
						</tr>
						</tfoot>

						<tbody>
						<?php $key = 0; ?>
						<?php
							$post_ids = $this->get_post_ids( $data );
							$drip_days = $this->get_post_days( $data );
							$drip_units = $this->get_post_days_units( $data );
						?>

						<?php foreach( $posts as $post ) : ?>
							<tr valign="middle" class="alternate" id="post-<?php echo $post->ID; ?>">
								<th class="check-column" scope="row">
									<input type="checkbox" value="<?php echo $post->ID; ?>" name="posts[<?php echo $key; ?>][id]"<?php checked( in_array( $post->ID, $post_ids ) ) ?>>
								</th>
								<td class="column-name">
									<strong><?php echo esc_html($post->post_title); ?></strong>
								</td>
								<td class="column-drip">
									<?php
									    $value = 0;
										$use_default = true;
										if( $key < count( $drip_days ) && in_array( $post->ID, $post_ids ) ) {
											$value = ! empty( $drip_days ) && (! empty( $drip_days[$key] ) || 0 == $drip_days[$key]) ? $drip_days[$key] : 0;
											$use_default = false;
										}
									?>
									<input type="text" value="<?php echo esc_attr( $value ); ?>" name="posts[<?php echo $key; ?>][drip]" size="4">
									<select name="posts[<?php echo $key; ?>][drip_unit]">
										<?php $default = isset( $drip_units[$key] ) && ! empty( $drip_units ) && (selected( $drip_units[$key], 'd' ) || selected( $drip_units[$key], 'm' ) || selected( $drip_units[$key], 'y' )) ? '' : $use_default ? 'selected' : '';  ?>
									    <option value="d" <?php ! $use_default && ! empty( $drip_units ) ? selected( $drip_units[$key], 'd' ) : false; ?><?php echo $default; ?>><?php _e( 'Day(s)', 'membership' ) ?></option>
									    <option value="w" <?php ! $use_default && ! empty( $drip_units ) ? selected( $drip_units[$key], 'w' ) : false; ?>><?php _e( 'Week(s)', 'membership' ) ?></option>
									    <option value="m" <?php ! $use_default && ! empty( $drip_units ) ? selected( $drip_units[$key], 'm' ) : false; ?>><?php _e( 'Month(s)', 'membership' ) ?></option>
									</select>
								</td>

								<td class="column-date">
									<?php echo date( 'd M y', strtotime( $post->post_date ) ); ?>
								</td>
						    </tr>
						<?php $key += 1; ?>
						<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>
				<p class='description'><?php printf( __( "Only the most recent %d posts are shown above, if you have more than that then you should consider using categories instead.", 'membership' ), $posts_to_show ) ?></p>
			</div>
		</div>
		<?php
	}

	/**
	 * Returns valid post ID's.
	 *
	 * @access public
	 */
	public function get_post_ids( $data ) {
		// this is a legacy rule
		if( $this->is_legacy_rule( $data ) ) {
			return $data;
		}

		$post_ids = array();
		foreach( $data as $key => $item ) {
			if( !empty( $item['id'] ) ) {
				$post_ids[$key] = $item['id'];
			}
		}

		return $post_ids;
	}

	public function get_dripped_post_ids( $data ) {
		// Legacy rule, dripped doesn't apply
		if( $this->is_legacy_rule( $data ) ) {
			return $data;
		}

		// Get the key variables
		$post_ids = $this->get_post_ids( $data );
		$post_drip = $this->get_post_days( $data );
		$post_unit = $this->get_post_days_units( $data );

		// New array of ids
		$drip_post_ids = array();

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
			foreach( $post_ids as $key => $post ) {
				$days_required = $post_drip[$key];
				switch( $post_unit[$key] ) {
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
					$drip_post_ids[$key] = $post;
				}
			}
		} else {
			$drip_post_ids = $post_ids;
		}
		return $drip_post_ids;
	}

	/**
	 * Get availability.
	 *
	 * @access public
	 */
	public function get_post_days( $data ) {
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
	public function get_post_days_units( $data ) {
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


	function on_positive( $data ) {
		$this->data = (array) $data;
		add_action( 'pre_get_posts', array( $this, 'add_viewable_posts' ), 99 );
	}

	function on_negative( $data ) {
		$this->data = (array) $data;
		add_action( 'pre_get_posts', array( $this, 'add_unviewable_posts' ), 99 );
	}

	function add_viewable_posts( $wp_query ) {

		if ( !$wp_query->is_singular && empty( $wp_query->query_vars['pagename'] ) && ( !isset( $wp_query->query_vars['post_type'] ) || in_array( $wp_query->query_vars['post_type'], array( 'post', '' ) )) ) {

			$post_ids = $this->get_dripped_post_ids( $this->data );

			$wp_query->query_vars['post__in'] = is_array( $wp_query->query_vars['post__in'] ) ? $wp_query->query_vars['post__in'] : array();

			// Also add post categories
			$categories = array();

			// We are in a list rather than on a single post
			foreach ( (array) $post_ids as $key => $value ) {
				$wp_query->query_vars['post__in'][] = $value;

				$post_cats = wp_get_post_categories( $value );
				if( ! empty( $post_cats ) ) {
					$categories = array_unique(array_merge( $categories, $post_cats ));
				}
			}

			$this->positive_categories = $categories;
			$wp_query->query_vars['post__in'] = array_unique( $wp_query->query_vars['post__in'] );
			$wp_query->query_vars['category__in'] = array_unique( array_merge( $categories, $wp_query->query_vars['category__in'] ) );
		}
	}

	function add_unviewable_posts( $wp_query ) {
		if ( !$wp_query->is_singular && empty( $wp_query->query_vars['pagename'] ) && ( !isset( $wp_query->query_vars['post_type'] ) || in_array( $wp_query->query_vars['post_type'], array( 'post', '' ) ) ) ) {

			$post_ids = $this->get_dripped_post_ids( $this->data );

			$wp_query->query_vars['post__not_in'] = is_array( $wp_query->query_vars['post__not_in'] ) ? $wp_query->query_vars['post__not_in'] : array();

			// Also add post categories
			$categories = array();

			// We are on a list rather than on a single post
			foreach ( (array) $post_ids as $key => $value ) {
				$wp_query->query_vars['post__not_in'][] = $value;

				$post_cats = wp_get_post_categories( $value );
				if( ! empty( $post_cats ) ) {
					$categories = array_unique(array_merge( $categories, $post_cats ));
				}
			}
			$this->negative_categories = $categories;
			$wp_query->query_vars['post__not_in'] = array_unique( $wp_query->query_vars['post__not_in'] );
			$wp_query->query_vars['category__not_in'] = array_unique( array_merge( $categories, $wp_query->query_vars['category__not_in'] ) );
		}
	}

	public function validate_negative( $args = null ) {
		if( $this->is_category_valid( $args ) ) {
			return true;
		}
		$page = get_queried_object();
		$post_ids = $this->get_dripped_post_ids( $this->data );
		return is_a( $page, 'WP_Post' ) && $page->post_type == 'post'
			? !in_array( $page->ID, $post_ids )
			: parent::validate_negative();
	}

	public function validate_positive( $args = null ) {
		if( $this->is_category_valid( $args ) ) {
			return true;
		}
		$page = get_queried_object();
		$post_ids = $this->get_dripped_post_ids( $this->data );
		return is_a( $page, 'WP_Post' ) && $page->post_type == 'post'
			? in_array( $page->ID, $post_ids )
			: parent::validate_positive();

	}

	private function is_category_valid( $arr ) {
		$valid = false;
		if( ! is_array( $arr ) ) {
			return false;
		}

		foreach( $arr as $key => $item ) {

			if( 'categories' == $item['name'] ) {
				$valid |= $item['result'];
			}

		}
		return $valid;
	}

}
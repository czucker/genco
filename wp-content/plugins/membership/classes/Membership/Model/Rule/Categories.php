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
 * Rule class responsible for categories protection.
 *
 * @category Membership
 * @package Model
 * @subpackage Rule
 */
class Membership_Model_Rule_Categories extends Membership_Model_Rule {

	/**
	 * Handles rule's stuff initialization.
	 *
	 * @access public
	 */
	public function on_creation() {
		parent::on_creation();

		$this->name = 'categories';
		$this->label = __( 'Categories', 'membership' );
		$this->description = __( 'Allows posts to be protected based on their assigned categories.', 'membership' );
		$this->rulearea = 'public';
	}

	/**
	 * Renders rule settings at access level edit form.
	 *
	 * @access public
	 * @param mixed $data The data associated with this rule.
	 */
	public function admin_main( $data ) {
		$categories = get_categories( 'get=all' );
		if ( !$data ) {
			$data = array();
		}

		?><div class="level-operation" id="main-categories">
			<h2 class="sidebar-name"><?php _e( 'Categories', 'membership' ) ?>
				<span>
					<a href='#remove' class="removelink" id="remove-categories" title="<?php _e( "Remove Categories from this rules area.", 'membership' ) ?>">
						<?php _e( 'Remove', 'membership' ) ?>
					</a>
				</span>
			</h2>

			<div class="inner-operation">
				<p><?php _e( 'Select the Categories to be covered by this rule by checking the box next to the relevant categories name.', 'membership' ) ?></p>

				<?php if ( $categories ) : ?>
				<table cellspacing="0" class="widefat fixed">
					<thead>
						<tr>
							<th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
							<th class="manage-column column-name" id="name" scope="col"><?php _e( 'Category name', 'membership' ) ?></th>
							<th style="" class="manage-column column-name" id="drip" scope="col"><?php _e('Available/blocked after ', 'membership'); ?><small><?php _e('(0 days for immediate)', 'membership'); ?></small></th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
							<th class="manage-column column-name" id="name" scope="col"><?php _e( 'Category name', 'membership' ) ?></th>
							<th style="" class="manage-column column-name" id="drip" scope="col"><?php _e('Available/blocked after ', 'membership'); ?><small><?php _e('(0 days for immediate)', 'membership'); ?></small></th>
						</tr>
					</tfoot>

					<tbody>
						<?php $key = 0; ?>
						<?php
							$cat_ids = $this->get_category_ids( $data );
							$drip_days = $this->get_category_days( $data );
							$drip_units = $this->get_category_days_units( $data );
						?>
						<?php foreach ( $categories as $category ) : ?>
						<tr valign="middle" class="alternate" id="post-<?php echo $category->term_id ?>">
							<th class="check-column" scope="row">
								<input type="checkbox" value="<?php echo $category->term_id ?>" name="categories[<?php echo $key; ?>][id]"<?php checked( in_array( $category->term_id, $cat_ids ) ) ?>>
							</th>
							<td class="column-name">
								<strong><?php echo esc_html( $category->name ) ?></strong>
							</td>
							<td class="column-drip">
								<?php
								    $value = 0;
									$use_default = true;
									if( $key < count( $drip_days ) && in_array( $category->term_id, $cat_ids ) ) {
										$value = ! empty( $drip_days ) && (! empty( $drip_days[$key] ) || 0 == $drip_days[$key]) ? $drip_days[$key] : 0;
										$use_default = false;
									}
								?>
								<input type="text" value="<?php echo esc_attr( $value ); ?>" name="categories[<?php echo $key; ?>][drip]" size="4">
								<select name="categories[<?php echo $key; ?>][drip_unit]">
									<?php $default = isset( $drip_units[$key] ) && ! empty( $drip_units ) && (selected( $drip_units[$key], 'd' ) || selected( $drip_units[$key], 'm' ) || selected( $drip_units[$key], 'y' )) ? '' : $use_default ? 'selected' : '';  ?>
								    <option value="d" <?php ! $use_default && ! empty( $drip_units ) && isset( $drip_units[$key] ) ? selected( $drip_units[$key], 'd' ) : false; ?><?php echo $default; ?>><?php _e( 'Day(s)', 'membership' ) ?></option>
								    <option value="w" <?php ! $use_default && ! empty( $drip_units ) && isset( $drip_units[$key] ) ? selected( $drip_units[$key], 'w' ) : false; ?>><?php _e( 'Week(s)', 'membership' ) ?></option>
								    <option value="m" <?php ! $use_default && ! empty( $drip_units ) && isset( $drip_units[$key] ) ? selected( $drip_units[$key], 'm' ) : false; ?>><?php _e( 'Month(s)', 'membership' ) ?></option>
								</select>
							</td>
						</tr>
						<?php $key += 1; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php endif; ?>
			</div>
		</div><?php
	}

	/**
	 * Returns valid category ID's.
	 *
	 * @access public
	 */
	public function get_category_ids( $data ) {
		// this is a legacy rule
		if( $this->is_legacy_rule( $data ) ) {
			return $data;
		}

		$cat_ids = array();
		foreach( $data as $key => $item ) {
			if( !empty( $item['id'] ) ) {
				$cat_ids[$key] = $item['id'];
			}
		}

		return $cat_ids;
	}

	public function get_dripped_category_ids( $data ) {
		// Legacy rule, dripped doesn't apply
		if( $this->is_legacy_rule( $data ) ) {
			return $data;
		}

		// Get the key variables
		$category_ids = $this->get_category_ids( $data );
		$category_drip = $this->get_category_days( $data );
		$category_unit = $this->get_category_days_units( $data );

		// New array of ids
		$drip_category_ids = array();

		$dates = Membership_Model_Level::get_dates( $this->level_data );

		if( ! empty( $dates ) ) {
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
			foreach( $category_ids as $key => $cat ) {
				$days_required = $category_drip[$key];
				switch( $category_unit[$key] ) {
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
					$drip_category_ids[$key] = $cat;
				}
			}
		} else {
			$drip_category_ids = $category_ids;
		}
		return $drip_category_ids;
	}

	/**
	 * Get availability.
	 *
	 * @access public
	 */
	public function get_category_days( $data ) {
		// this is a legacy rule
		if( $this->is_legacy_rule( $data ) ) {
			return false;
		}

		$days = array();
		foreach( $data as $key => $item ) {
			if( !empty( $item['drip'] ) || 0 == $item['drip'] ) {
				$val = (int) $item['drip'];
				$days[$key] = ! empty( $val ) || 0 == $val ? $val : 0;
			} else {
				$days[$key] = 0;
			}
		}

		return $days;
	}

	/**
	 * Get availability units.
	 *
	 * @access public
	 */
	public function get_category_days_units( $data ) {
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
	 * Associates positive data with this rule.
	 *
	 * @access public
	 * @param mixed $data The positive data to associate with the rule.
	 */
	public function on_positive( $data ) {
		$this->data = (array) $data;

		add_action( 'pre_get_posts', array( $this, 'filter_viewable_posts' ), 1 );
		add_filter( 'get_terms', array( $this, 'filter_viewable_categories' ), 1, 3 );
	}

	/**
	 * Associates negative data with this rule.
	 *
	 * @access public
	 * @param mixed $data The negative data to associate with the rule.
	 */
	public function on_negative( $data ) {
		$this->data = (array) $data;

		add_action( 'pre_get_posts', array( $this, 'filter_unviewable_posts' ), 1 );
		add_filter( 'get_terms', array( $this, 'filter_unviewable_categories' ), 1, 3 );
	}

	/**
	 * Adds category__in filter for posts query to remove all posts which not
	 * belong to allowed categories.
	 *
	 * @sicne 3.5
	 * @action pre_get_posts 1
	 *
	 * @access public
	 * @param WP_Query $query The WP_Query object to filter.
	 */
	public function filter_viewable_posts( $query ) {

		$cat_ids = $this->get_dripped_category_ids( $this->data );
		$post_ids = $this->get_category_posts( $cat_ids );

		//don't apply these rules to custom post types!
		if ( $query->get('post_type') == 'post' || (( is_home() || is_search() || is_archive() ) )) {
			if( 'nav_menu_item' != $query->get('post_type') ) {
				$query->set('post__in', array_unique(array_merge((array) $query->query_vars['post__in'], $post_ids)));
				$query->set('category__in', array_unique(array_merge((array) $query->query_vars['category__in'], $cat_ids)));
			}
		}
		// if( 'nav_menu_item' == $query->get('post_type') ) {
		// 	$query->set('post__in', array());
		// 	$query->set('category__in', array());
		//
		// 	$menu_items = $query->query_vars['include'];
		// 	$new_items = array();
		// 	foreach( $menu_items as $item_id ) {
		// 		$menu_item = $this->get_menu_item( $item_id );
		//
		// 		if( 'post_type' == $menu_item['type'] && 'post' == get_post_type( $menu_item['object_id'] ) ) {
		//
		// 			if( in_array( $menu_item['object_id'], $post_ids ) ) {
		// 				$new_items[] = $item_id;
		// 			}
		// 		} else {
		// 			$new_items[] = $item_id;
		// 		}
		// 	}
		//
		// 	$query->set('include', $new_items);
		// 	$query->query['include'] = $new_items;
		// 	$query->query['post__in'] = $new_items;
		//
		// }
	}

	private function get_menu_item( $id ) {
		$item = array();
		$item['type'] = get_post_meta( $id, '_menu_item_type', true);
		$item['object_id'] = get_post_meta( $id, '_menu_item_object_id', true);
		return $item;
	}

	private function get_category_posts( $categories ) {
		global $wpdb;
		$ids = join( "','", $categories );

		$sql = $wpdb->prepare("SELECT wp_posts.ID
								FROM wp_posts
								INNER JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
								WHERE 1=1
								AND ( wp_term_relationships.term_taxonomy_id IN (%s) )
								AND wp_posts.post_type = 'post'
								AND (wp_posts.post_status = 'publish')
								GROUP BY wp_posts.ID
								ORDER BY wp_posts.post_date DESC
								LIMIT 0, 10
						", $ids);
		$sql = str_replace('\\','', $sql);

		$results = $wpdb->get_results( $sql, ARRAY_A );

		$post_ids = array();
		foreach( $results as $result ) {
			$post_ids[] = $result['ID'];
		}
		return $post_ids;
	}

	/**
	 * Adds category__not_in filter for posts query to remove all posts which
	 * belong to prohibited categories.
	 *
	 * @sicne 3.5
	 * @action pre_get_posts 1
	 *
	 * @access public
	 * @param WP_Query $query The WP_Query object to filter.
	 */
	public function filter_unviewable_posts( $wp_query ) {
		$cat_ids = $this->get_dripped_category_ids( $this->data );
		$post_ids = $this->get_category_posts( $cat_ids );
		//don't apply these rules to custom post types!
		if ( $query->get('post_type') == 'post' || (( is_home() || is_search() || is_archive() ) && $query->get('post_type') )) {
			if( 'nav_menu_item' != $query->get('post_type') ) {
				$query->set('post__not_in', array_unique(array_merge((array) $query->query_vars['post__not_in'], $post_ids)));
				$wp_query->set('category__not_in', array_unique(array_merge((array) $wp_query->query_vars['category__not_in'], $cat_ids)));
			}
		}
	}

	/**
	 * Filters categories and removes all not accessible categories.
	 *
	 * @sicne 3.5
	 *
	 * @access public
	 * @param array $terms The terms array.
	 * @return array Fitlered terms array.
	 */
	public function filter_viewable_categories( $terms, $taxonomies, $args ) {
		$new_terms = array();

		if ( ! in_array('category', $taxonomies) ) {
			// bail - not fetching category taxonomy
			return $terms;
		}

		$cat_ids = $this->get_dripped_category_ids( $this->data );

		foreach ( (array)$terms as $key => $term ) {
			if ( $term->taxonomy == 'category' ) { //still do this check here - could be fetching multiple taxonomies
				if ( in_array( $term->term_id, $cat_ids ) ) {
					$new_terms[$key] = $term;
				}
			} else {
				// this taxonomy isn't category so add it so custom taxonomies don't break
				$new_terms[$key] = $term;
			}
		}

		return $new_terms;
	}

	/**
	 * Filters categories and removes all not accessible categories.
	 *
	 * @sicne 3.5
	 *
	 * @access public
	 * @param array $terms The terms array.
	 * @return array Fitlered terms array.
	 */
	public function filter_unviewable_categories( $terms, $taxonomies, $args ) {
		$new_terms = array();

		if ( ! in_array('category', $taxonomies) ) {
			// bail - not fetching category taxonomy
			return $terms;
		}

		$cat_ids = $this->get_dripped_category_ids( $this->data );

		foreach ( (array) $terms as $key => $term ) {
			if ( $term->taxonomy == 'category' ) { //still do this check here - could be fetching multiple taxonomies
				if ( !in_array( $term->term_id, $cat_ids ) ) {
					$new_terms[$key] = $term;
				}
			} else {
				// this taxonomy isn't category so add it so custom taxonomies don't break
				$new_terms[$key] = $term;
			}
		}

		return $new_terms;
	}

	/**
	 * Validates the rule on negative assertion.
	 *
	 * @access public
	 * @return boolean TRUE if assertion is successfull, otherwise FALSE.
	 */
	public function validate_negative( $args = null ) {
		if( $this->is_post_valid( $args ) ) {
			return true;
		};
		$cat_ids = $this->get_dripped_category_ids( $this->data );
		if ( is_single() && in_array( 'category', get_object_taxonomies( get_post_type() ) ) ) {
			$categories = wp_get_post_categories( get_the_ID() );
			$intersect = array_intersect( $categories, $cat_ids );
			return empty( $intersect );
		}

		if ( is_category() ) {
			return !in_array( get_queried_object_id(), $cat_ids );
		}

		return parent::validate_negative();
	}

	/**
	 * Validates the rule on positive assertion.
	 *
	 * @access public
	 * @return boolean TRUE if assertion is successfull, otherwise FALSE.
	 */
	public function validate_positive( $args = null ) {
		if( $this->is_post_valid( $args ) ) {
			return true;
		};
		$cat_ids = $this->get_dripped_category_ids( $this->data );
		if ( is_single() && in_array( 'category', get_object_taxonomies( get_post_type() ) ) ) {
			$categories = wp_get_post_categories( get_the_ID() );
			$intersect = array_intersect( $categories, $cat_ids );
			return !empty( $intersect );
		}

		if ( is_category() ) {
			return in_array( get_queried_object_id(), $cat_ids );
		}

		return parent::validate_positive();
	}

	private function is_post_valid( $arr ) {
		$valid = false;
		if( ! is_array( $arr ) ) {
			return false;
		}

		foreach( $arr as $key => $item ) {

			if( 'posts' == $item['name'] ) {
				$valid |= $item['result'];
			}

		}
		return $valid;
	}

}
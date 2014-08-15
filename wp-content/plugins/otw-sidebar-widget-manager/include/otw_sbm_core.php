<?php
if( !function_exists( 'otw_sbm_index' ) ){
	function otw_sbm_index( $index, $sidebars_widgets ){
		
		global $wp_registered_sidebars, $otw_replaced_sidebars;
		
		if( isset( $otw_replaced_sidebars[ $index ] ) ){//we have set replacemend.
		
			$requested_objects = otw_get_current_object();
			
			//check if the new sidebar is valid for the current requested resource
			foreach( $otw_replaced_sidebars[ $index ] as $repl_sidebar ){
				
				if( isset( $wp_registered_sidebars[ $repl_sidebar ] ) ){
					
					if( $wp_registered_sidebars[ $repl_sidebar ]['status'] == 'active'  ){
						
						if( otw_filter_strict_sidebar_index( $repl_sidebar ) ){
						
							foreach( $requested_objects as $objects ){
							
								list( $object, $object_id, $object_type ) = $objects;
								
								
								if( $object && $object_id && $object_type ){
									otw_sbm_log( $repl_sidebar, "\n\n\n", 2 );
									if( is_array( $object_id ) ){
										otw_sbm_log( $repl_sidebar, '|1|->: validate sitebar index  ['.$repl_sidebar.','.$object.','.implode( ',', $object_id ).','.$object_type.']...', 1, __FILE__, __LINE__ );
									}else{
										otw_sbm_log( $repl_sidebar, '|1|->: validate sitebar index  ['.$repl_sidebar.','.$object.','.$object_id.','.$object_type.']...', 1, __FILE__, __LINE__ );
									}
									$tmp_index = otw_validate_sidebar_index( $repl_sidebar, $object, $object_id );
									if( !$tmp_index ){
										otw_sbm_log( $repl_sidebar, ' <-|1| not_found' );
									}else{
										otw_sbm_log( $repl_sidebar, ' <-|1| '.$tmp_index, '' );
									}
									if( $tmp_index ){
										if ( !empty($sidebars_widgets[$tmp_index]) ){
											$sidebars_widgets[$tmp_index] = otw_filter_siderbar_widgets( $tmp_index, $sidebars_widgets );
											
											
											if( count( $sidebars_widgets[$tmp_index] ) ){
												$index = $tmp_index;
												break 2;
											}
										}
									}
								}//end hs object and object id
								
							}//end loop requested objects
						}
					}
				}
			}
		}
		
		return $index;
	}
}
/**
 * Resolve excluded items give list of ids or slugs
 */
if( !function_exists( 'otw_get_sidebar_from_excluded_items' ) ){
	function otw_get_sidebar_from_excluded_items( $object, $object_id, $items ){
		
		$valid_sidebar = true;
		
		$excluded_items = array();
		
		if( isset( $items ) && strlen( $items ) ){
			$excluded_items = explode( ",", $items );
			
			if( count( $excluded_items ) ){
				$excluded_items = array_map( 'trim', $excluded_items );
			}
		}
		
		if( in_array( $object_id, $excluded_items ) ){
			$valid_sidebar = false;
		}else{
			switch( $object ){
				case 'post':
						$post_info = get_post( $object_id );
						
						if( isset( $post_info->post_name ) ){
							
							if( in_array( $post_info->post_name, $excluded_items ) ){
								$valid_sidebar = false;
							}
						}
					break;
			}
		}
		return $valid_sidebar;
		
	}
}
/** overwrites sidebar index based otw sitebar settings
  * @param string
  * @return string
  */

/** check if given sidebar is valid for the given object and object_id without checing the widgets
  *  @param string
  *  @param string
  *  @param string
  *  @return string
  */
if( !function_exists( 'otw_validate_sidebar_index' ) ){
	function otw_validate_sidebar_index( $sidebar, $object, $object_id ){
	
		global $wp_registered_sidebars;
		
		$tmp_index = false;
		
		if( preg_match( "/^otw\-/", $sidebar ) ){
			
			if( isset( $wp_registered_sidebars[ $sidebar ]['validfor'][ $object ][ $object_id ] ) || isset( $wp_registered_sidebars[ $sidebar ]['validfor'][ $object ][ 'all' ] ) || empty( $wp_registered_sidebars[ $sidebar ]['replace'] ) ){
				
				if(  is_single() && isset( $wp_registered_sidebars[ $sidebar ]['validfor'][ $object ][ $object_id ] ) && isset( $wp_registered_sidebars[ $sidebar ]['exclude_posts_for'] ) && isset( $wp_registered_sidebars[ $sidebar ]['exclude_posts_for'][ $object ] ) ){
					
					global $wp_query;
					
					$query_object = $wp_query->get_queried_object();
					
					$post_id = $query_object->ID;
					
					if( otw_get_sidebar_from_excluded_items( 'post', $post_id, $wp_registered_sidebars[ $sidebar ]['exclude_posts_for'][ $object ] ) ){
						$tmp_index = $sidebar;
					}
				}else{
					$tmp_index = $sidebar;
				}
				
				
			}elseif( preg_match( "/^cpt\_(.*)/", $object, $matches ) ){
				$cpt_object = 'customposttype';
				$cpt_object_id = $matches[1];
			
				if( isset( $wp_registered_sidebars[ $sidebar ]['validfor'][ $cpt_object ][ $cpt_object_id ] ) || isset( $wp_registered_sidebars[ $sidebar ]['validfor'][ $cpt_object ][ 'all' ] ) ){
					$tmp_index = $sidebar;
				}
			}
			
		}else{
			$tmp_index = $sidebar;
		}
		return $tmp_index;
	}
}

/**
 * request sidebar with shortcode
 *
 * @param array attributes
 *
 * @return string
 */
if( !function_exists( 'otw_call_sidebar' ) ){
	function otw_call_sidebar( $attributes ){
		
		global $wp_registered_sidebars, $wp_registered_widgets;
		
		$sidebar_output = '';
		
		
		if( isset( $attributes['sidebar'] ) ){
			
			if( is_active_sidebar( $attributes['sidebar'] ) ){
				
				$sidebars_widgets = wp_get_sidebars_widgets();
				
				$index = otw_sbm_index( $attributes['sidebar'], $sidebars_widgets );
				
				//filter widgets for ths sidebar
				$sidebars_widgets[ $index ] = otw_filter_siderbar_widgets( $index, $sidebars_widgets );
				
				if( !count( $sidebars_widgets[ $index ] ) ){
					return;
				}
				
				$container = '<div class="otw-sidebar '.$attributes['sidebar'].'';
				$sidebar = $wp_registered_sidebars[ $index ];
				
				$widget_percentage = 0;
				
				$widget_alignement = 'vertical';
				
				if( isset( $sidebar['widget_alignment'] ) ){
					$widget_alignement = $sidebar['widget_alignment'];
				}
				
				switch( $widget_alignement ){
					
					case 'horizontal':
							$container .= ' otw-row';
							global $otw_sbm_grid_manager_object;
							$widget_percentage = 'otw-'.$otw_sbm_grid_manager_object->number_names[ $otw_sbm_grid_manager_object->grid_size / count( $sidebars_widgets[$index] ) ];
							
						break;
					default:
							$container .= ' otw-sidebar-vertical';
						break;
				}
				$container .= '">';
				
				ob_start();
				echo $container;
				
				$widget_number = 0;
				foreach( $sidebars_widgets[$index] as $id ) {
					
					if( !isset( $wp_registered_widgets[$id] ) ){
						continue;
					}
					$widget_number++;
					
					$params = array_merge(
						array( array_merge( $sidebar, array('widget_id' => $id, 'widget_name' => $wp_registered_widgets[$id]['name']) ) ),
						(array) $wp_registered_widgets[$id]['params']
					);
					$classname_ = 'widget otw-widget-'.$widget_number;
					
					if( $widget_number == 1 ){
						$classname_ .= ' widget-first';
					}elseif( $widget_number == count( $sidebars_widgets[$index] ) ){
						$classname_ .= ' widget-last';
					}
					
					foreach ( (array) $wp_registered_widgets[$id]['classname'] as $cn ) {
						if ( is_string($cn) ){
							$classname_ .= ' ' . $cn;
						}elseif ( is_object($cn) ){
							$classname_ .= ' ' . get_class($cn);
						}
					}
					$classname_ = ltrim($classname_, '_');
					
					$params[0]['before_widget'] = sprintf($params[0]['before_widget'], $id, $classname_);
					
					if( $widget_percentage ){
						
						$last_widget_class = '';
						if( $widget_number == count( $sidebars_widgets[$index] ) )
						{
							$last_widget_class = ' end';
						}
						
						$params[0]['before_widget'] = '<div class="'.$widget_percentage.' otw-columns'.$last_widget_class.'">'.$params[0]['before_widget'];
					}
					if( $widget_percentage ){
						$params[0]['after_widget'] .= '</div>';
					}
					
					$params = apply_filters( 'otw_shortcode_sidebar_params', $params );
					
					$callback = $wp_registered_widgets[$id]['callback'];
					
					do_action( 'dynamic_sidebar', $wp_registered_widgets[$id] );
					
					if( is_callable($callback) ) {
						call_user_func_array($callback, $params);
					}
				}
				
				echo '</div>';
				$sidebar_output = ob_get_contents();
				ob_end_clean();
			}
		}
		return $sidebar_output;
	}
}

/** get current requested object
  *
  *  @return array
  */
if( !function_exists( 'otw_get_current_object' ) ){
	function otw_get_current_object(){
		
		global $current_user;
		
		if( isset( $GLOBALS['wp_query'] ) ){
			$wp_query = $GLOBALS['wp_query'];
		}else{
			return array( array( '', 0, 'flow' ) );
		}
		
		$object_key = 0;
		
		$pre_objects = 0;
		
		$object = '';
		$object_id = 0;
		$object_type = 'flow';
	
		$current_object_key = $object_key;
		$objects[$current_object_key][0] = '';
		$objects[$current_object_key][1] = 0;
		$objects[$current_object_key][2] = 'flow';
		
		wp_reset_query();
		
		if( otw_installed_plugin( 'buddypress' ) ){
			global $bp;
		}
		
		if( is_page() ){
			$object = 'page';
			$query_object = $wp_query->get_queried_object();
			
			$object_id = $query_object->ID;
			
			if( otw_installed_plugin( 'buddypress' ) ){
				
				if( isset( $bp->pages->activity ) && ( $bp->pages->activity->id == $object_id ) ){
					$object = 'buddypress_page';
				}elseif( isset( $bp->pages->members ) && ( $bp->pages->members->id  == $object_id ) ){
					$object = 'buddypress_page';
				}
			}
			
			if( is_page_template() ){
				$template_string = get_page_template();
				$template_parts = explode( "/", $template_string );
				$o_id = $template_parts[ count( $template_parts ) - 1 ];
				if( $o_id != 'page.php' ){
					$objects[ $current_object_key + 1 ][0] = 'pagetemplate';
					$objects[ $current_object_key + 1 ][1] = $o_id;
					$objects[ $current_object_key + 1 ][2] = 'flow';
				}
			}
			
			
			$custom_taxonomies = get_taxonomies( array(  'public'   => true, '_builtin' => false ), 'object' );
			if( is_array( $custom_taxonomies ) && count( $custom_taxonomies ) ){
				
				foreach( $custom_taxonomies as $c_type => $c_type_info ){
					
					$post_taxonomies = wp_get_object_terms( $object_id, $c_type );
					
					if( is_array( $post_taxonomies ) && count( $post_taxonomies ) ){
						
						foreach( $post_taxonomies as $p_tax ){
							$object_key = count( $objects );
							$objects[ $object_key ][0] = 'page_in_ctx_'.$c_type;
							$objects[ $object_key ][1] = $p_tax->term_id;
							$objects[ $object_key ][2] = 'flow';
						}
					}
				}
			}
			
		}elseif( is_single() ){
			$post_type = get_post_type();
			
			$custom_post_types = get_post_types( array(  'public'   => true, '_builtin' => false ), 'object' );
			
			if( array_key_exists( $post_type, $custom_post_types )  ){
				
				$object = 'cpt_'.$post_type;
				$query_object = $wp_query->get_queried_object();
				
				if( $query_object->ID ){
					$object_id = $query_object->ID;
				}else{
					$object_name = get_query_var('pagename');
					if( $object_name ){
						$posts = get_posts( array( 'name' => $object_name, 'post_type' => $post_type, 'numberposts' => -1 ) );
					}elseif( $object_slug = get_query_var( $post_type ) ){
						$posts = get_posts( array( 'name' => $object_slug, 'post_type' => $post_type, 'numberposts' => -1 ) );
					}
					
					if( is_array( $posts ) && count( $posts ) ){
						$object_id = $posts[0]->ID;
					}
				}
				
				$custom_taxonomies = get_taxonomies( array(  'public'   => true, '_builtin' => false ), 'object' );
				if( is_array( $custom_taxonomies ) && count( $custom_taxonomies ) ){
					
					foreach( $custom_taxonomies as $c_type => $c_type_info ){
						
						$post_taxonomies = wp_get_object_terms( $object_id, $c_type );
						
						if( is_array( $post_taxonomies ) && count( $post_taxonomies ) ){
							
							foreach( $post_taxonomies as $p_tax ){
								$object_key = count( $objects );
								$objects[ $object_key ][0] = $post_type.'_in_ctx_'.$c_type;
								$objects[ $object_key ][1] = $p_tax->term_id;
								$objects[ $object_key ][2] = 'flow';
							}
						}
					}
				}
			}else{
				$object = 'post';
				$query_object = $wp_query->get_queried_object();
				
				$object_id = $query_object->ID;
				
				if( $object_id ){
					$post_categories = wp_get_post_categories( $object_id );
					
					if( is_array( $post_categories ) && count( $post_categories ) ){
						foreach( $post_categories as $p_cat ){
							
							$object_key = count( $objects );
							
							$objects[ $object_key ][0] = 'postsincategory';
							$objects[ $object_key ][1] = $p_cat;
							$objects[ $object_key ][2] = 'flow';
						}
					}
					$post_tags = wp_get_post_tags( $object_id );
					if( is_array( $post_tags ) && count( $post_tags ) ){
						foreach( $post_tags as $p_tag ){
							$object_key = count( $objects );
							
							$objects[ $object_key ][0] = 'postsintag';
							$objects[ $object_key ][1] = $p_tag->term_id;
							$objects[ $object_key ][2] = 'flow';
						}
					}
					$custom_taxonomies = get_taxonomies( array(  'public'   => true, '_builtin' => false ), 'object' );
					if( is_array( $custom_taxonomies ) && count( $custom_taxonomies ) ){
						
						foreach( $custom_taxonomies as $c_type => $c_type_info ){
							
							$post_taxonomies = wp_get_object_terms( $object_id, $c_type );
							
							if( is_array( $post_taxonomies ) && count( $post_taxonomies ) ){
								
								foreach( $post_taxonomies as $p_tax ){
									$object_key = count( $objects );
									$objects[ $object_key ][0] = 'post_in_ctx_'.$c_type;
									$objects[ $object_key ][1] = $p_tax->term_id;
									$objects[ $object_key ][2] = 'flow';
								}
							}
						}
					}
				}
			}
			
		}elseif( is_category() ){
			$object = 'category';
			$query_object = $wp_query->get_queried_object();
			$object_id = $query_object->term_id;
			
		}elseif( is_tag() ){
			$object = 'posttag';
			$query_object = $wp_query->get_queried_object();
			$object_id = $query_object->term_id;
		}elseif( is_archive() ){
		
			
			$object = 'archive';
			$object_id = 0;
			
			
			if( is_author() ){
				$q_object = $wp_query->get_queried_object();
				
				$object = 'author_archive';
				$object_id = $q_object->data->ID;
			}elseif( is_tax() ){
				$q_object = $wp_query->get_queried_object();
				
				$object = 'ctx_'.$q_object->taxonomy;
				$object_id = $q_object->term_id;
			}
			elseif( isset( $wp_query->query['year'] ) && isset( $wp_query->query['monthnum'] ) && isset( $wp_query->query['daily'] ) ){
				$object_id = 'daily';
			}
			elseif( isset( $wp_query->query['year'] ) && isset( $wp_query->query['monthnum'] ) ){
				$object_id = 'monthly';
			}
			elseif( isset( $wp_query->query['year'] ) ){
				
				$object_id = 'yearly';
				
			}elseif( function_exists( 'is_shop' ) && function_exists( 'woocommerce_get_page_id' ) && is_shop() && woocommerce_get_page_id('shop') ){
				//woocommerce pages
				$object = 'page';
				$object_id = woocommerce_get_page_id('shop');
				
			}elseif( otw_installed_plugin( 'bbpress' ) && isset( $wp_query->post ) && $wp_query->post->ID == 0 && isset( $wp_query->queried_object_id ) && ( $wp_query->queried_object_id == 0 ) && isset( $wp_query->queried_object ) && ( $wp_query->queried_object->name == 'forum' ) ){
				//bbpress pages
				$object = 'bbp_page';
				$object_id = 'forums';
			}elseif( otw_installed_plugin( 'buddypress' ) && isset( $wp_query->post ) && isset( $wp_query->queried_object )&& isset( $wp_query->queried_object->ID ) && $wp_query->queried_object->ID && isset( $bp->pages->activity ) && ( $bp->pages->activity->id == $wp_query->queried_object->ID ) ){
				$object = 'buddypress_page';
				$object_id = $wp_query->queried_object->ID;
			}elseif( otw_installed_plugin( 'buddypress' ) && isset( $wp_query->post ) && isset( $wp_query->queried_object ) && isset( $wp_query->queried_object->ID ) && $wp_query->queried_object->ID && isset( $bp->pages->members ) && ( $bp->pages->members->id == $wp_query->queried_object->ID ) ){
				$object = 'buddypress_page';
				$object_id = $wp_query->queried_object->ID;
			}
			
		}else{
			if( !$object ){
				if( isset( $wp_query->queried_object ) && is_object(  $wp_query->queried_object ) && isset( $wp_query->queried_object->taxonomy ) && isset( $wp_query->queried_object->term_taxonomy_id ) && $wp_query->queried_object->term_taxonomy_id  ){
					$object = 'ctx_'.$wp_query->queried_object->taxonomy;
					$object_id = $wp_query->queried_object->term_taxonomy_id;
				}elseif( otw_installed_plugin( 'bbpress' ) && isset( $wp_query->bbp_is_search ) && $wp_query->bbp_is_search ){
					$object = 'bbp_page';
					$object_id = 'search';
				}elseif( otw_installed_plugin( 'bbpress' ) && isset( $wp_query->bbp_is_view ) && $wp_query->bbp_is_view && isset( $wp_query->query ) && isset( $wp_query->query['bbp_view'] ) && (  $wp_query->query['bbp_view'] == 'no-replies' )  ){
					$object = 'bbp_page';
					$object_id = 'noreplies';
				}elseif( otw_installed_plugin( 'bbpress' ) && isset( $wp_query->bbp_is_view ) && $wp_query->bbp_is_view && isset( $wp_query->query ) && isset( $wp_query->query['bbp_view'] ) && (  $wp_query->query['bbp_view'] == 'popular' ) ){
					$object = 'bbp_page';
					$object_id = 'mostpopular';
				}elseif( otw_installed_plugin( 'bbpress' ) && isset( $wp_query->bbp_is_single_user ) && $wp_query->bbp_is_single_user ){
					$object = 'bbp_page';
					$object_id = 'singleuser';
				}
			}
		}
		
		$objects[ $current_object_key ][0] = $object;
		$objects[ $current_object_key ][1] = $object_id;
		$objects[ $current_object_key ][2] = 'flow';
		
		//add Template Hierarchy as next object
		$object_key = count( $objects );
		
		if( ( $object_key == ( $pre_objects + 1 ) ) && !$objects[ $current_object_key ][0] ){
			$object_key = $current_object_key;
		}
		
		if( is_front_page() ){
			$objects[ $object_key ][0] = 'templatehierarchy';
			$objects[ $object_key ][1] = 'front';
			$objects[ $object_key ][2] = 'flow';
			$object_key++;
		}
		if( is_home() ){
			$objects[ $object_key ][0] = 'templatehierarchy';
			$objects[ $object_key ][1] = 'home';
			$objects[ $object_key ][2] = 'flow';
			$object_key++;
		}
		if( is_404() ){
			$objects[ $object_key ][0] = 'templatehierarchy';
			$objects[ $object_key ][1] = '404';
			$objects[ $object_key ][2] = 'flow';
			$object_key++;
		}
		if( is_search() ){
			$objects[ $object_key ][0] = 'templatehierarchy';
			$objects[ $object_key ][1] = 'search';
			$objects[ $object_key ][2] = 'flow';
			$object_key++;
		}
		if( is_date() ){
			$objects[ $object_key ][0] = 'templatehierarchy';
			$objects[ $object_key ][1] = 'date';
			$objects[ $object_key ][2] = 'flow';
			$object_key++;
		}
		if( is_author() ){
			$objects[ $object_key ][0] = 'templatehierarchy';
			$objects[ $object_key ][1] = 'author';
			$objects[ $object_key ][2] = 'flow';
			$object_key++;
		}
		if( is_category() ){
			$objects[ $object_key ][0] = 'templatehierarchy';
			$objects[ $object_key ][1] = 'category';
			$objects[ $object_key ][2] = 'flow';
			$object_key++;
		}
		if( is_tag() ){
			$objects[ $object_key ][0] = 'templatehierarchy';
			$objects[ $object_key ][1] = 'tag';
			$objects[ $object_key ][2] = 'flow';
			$object_key++;
		}
		if( is_tax() ){
			$objects[ $object_key ][0] = 'templatehierarchy';
			$objects[ $object_key ][1] = 'taxonomy';
			$objects[ $object_key ][2] = 'flow';
			$object_key++;
		}
		if( is_archive() ){
			$objects[ $object_key ][0] = 'templatehierarchy';
			$objects[ $object_key ][1] = 'archive';
			$objects[ $object_key ][2] = 'flow';
			$object_key++;
		}
		if( is_single() ){
			$objects[ $object_key ][0] = 'templatehierarchy';
			$objects[ $object_key ][1] = 'single';
			$objects[ $object_key ][2] = 'flow';
			$object_key++;
		}
		if( is_attachment() ){
			$objects[ $object_key ][0] = 'templatehierarchy';
			$objects[ $object_key ][1] = 'attachment';
			$objects[ $object_key ][2] = 'flow';
			$object_key++;
		}
		if( is_page() ){
			$objects[ $object_key ][0] = 'templatehierarchy';
			$objects[ $object_key ][1] = 'page';
			$objects[ $object_key ][2] = 'flow';
			$object_key++;
		}
		
		return $objects;
	}
}
/** filter widget for given sidebar
  *
  *  @param string
  *  @param array
  *  @return array
  */
if( !function_exists( 'otw_filter_siderbar_widgets' ) ){
	function otw_filter_siderbar_widgets( $index, $sidebars_widgets ){
		
		global $wp_registered_sidebars, $otw_plugin_options;
		
		$filtered_widgets = array();
		
		otw_sbm_log( $index, "\n", 2 );
		otw_sbm_log( $index, '|-> check tmp index '.$index, 1, __FILE__, __LINE__ );
		
		if( array_key_exists( $index, $sidebars_widgets ) ){
			
			otw_sbm_log( $index, "\tindex(".$index.") in sidebars_widgets array", 1, __FILE__, __LINE__ );
			
			if( isset( $otw_plugin_options['activate_appearence'] ) && $otw_plugin_options['activate_appearence'] ){
				
				otw_sbm_log( $index, "\tactivate_appearence enabled", 1, __FILE__, __LINE__ );
				
				$collected_widgets = array();
				
				$requested_objects = otw_get_current_object();
				
				if( count( $requested_objects ) ){
					
					foreach( $requested_objects as $objects ){
						
						otw_sbm_log( $index, "\t |".implode( '|',  $objects )."|", 1, __FILE__, __LINE__ );
						
						list( $object, $object_id, $object_type ) = $objects;
						
						$tmp_index = otw_validate_sidebar_index( $index, $object, $object_id );
				
						otw_sbm_log( $index, "\t validated tmp index  is '".$tmp_index."'", 1, __FILE__, __LINE__ );
						
						if( is_array( $object_id ) ){
							otw_sbm_log( $tmp_index, "\tcheck for object ".$object." ".implode( ',', $object_id )." ".$object_type, 1, __FILE__, __LINE__ );
						}else{
							otw_sbm_log( $tmp_index, "\tcheck for object ".$object." ".$object_id." ".$object_type, 1, __FILE__, __LINE__ );
						}
						
						
						if( $tmp_index ){
							
							$otw_wc_invisible = array();
							$otw_wc_visible = array();
							
							if( isset( $wp_registered_sidebars[ $tmp_index ]['widgets_settings'][ $object ]['_otw_wc'] ) ){
								otw_sbm_log( $tmp_index, "\t\t::yes[_otw_wc]".implode( ',', $wp_registered_sidebars[ $tmp_index ]['widgets_settings'][ $object ]['_otw_wc'] ), 1, __FILE__, __LINE__ );
								$filtered = true;
								foreach( $wp_registered_sidebars[ $tmp_index ]['widgets_settings'][ $object ]['_otw_wc'] as $tmp_widget => $tmp_widget_value ){
									if( $tmp_widget_value == 'vis' ){
										foreach( $sidebars_widgets[ $tmp_index ] as $s_index => $s_widget ){
											if( $s_widget == $tmp_widget ){
												if( !otw_is_widget_item_excluded( $tmp_index, $object, $s_widget, $wp_registered_sidebars ) ){
													$collected_widgets[ $tmp_widget ] = $s_index;
												}
												break;
											}
										}
										
										$otw_wc_visible[ $tmp_widget ] = $tmp_widget;
									}elseif( $tmp_widget_value == 'invis' ){
										$otw_wc_invisible[ $tmp_widget ] = $tmp_widget;
									}
								}
								otw_sbm_log( $tmp_index, "\t\t::vis[".implode( ',', $otw_wc_visible ).']', 1, __FILE__, __LINE__ );
								otw_sbm_log( $tmp_index, "\t\t::invis[".implode( ',', $otw_wc_invisible ).']', 1, __FILE__, __LINE__ );
							}else{
								otw_sbm_log( $tmp_index, "\t\t::no[_otw_wc]", 1, __FILE__, __LINE__ );
							}
							
							
							if( isset( $wp_registered_sidebars[ $tmp_index ]['widgets_settings'][ $object ][ $object_id ]['exclude_widgets'] ) ){
							
								otw_sbm_log( $tmp_index, "\t\t::excluded[".implode( ',', $wp_registered_sidebars[ $tmp_index ]['widgets_settings'][ $object ][ $object_id ]['exclude_widgets'] ).']', 1, __FILE__, __LINE__ );
								foreach( $sidebars_widgets[ $tmp_index ] as $s_index => $tmp_widget ){
									$filtered = true;
									if( !array_key_exists( $tmp_widget, $wp_registered_sidebars[ $tmp_index ]['widgets_settings'][ $object ][ $object_id ]['exclude_widgets'] ) ){
										
										if( !array_key_exists( $tmp_widget, $otw_wc_invisible ) && !array_key_exists( $tmp_widget, $otw_wc_visible )  ){
											if( !otw_is_widget_item_excluded( $tmp_index, $object, $tmp_widget, $wp_registered_sidebars ) ){
												$collected_widgets[ $tmp_widget ] = $s_index;
											}
										}
									}
								}
							}else{
							
								foreach( $sidebars_widgets[ $tmp_index ] as $s_index => $tmp_widget ){
									$filtered = true;
									
									if( !array_key_exists( $tmp_widget, $otw_wc_invisible ) && !array_key_exists( $tmp_widget, $otw_wc_visible )  ){
									
										if( !otw_is_widget_item_excluded( $tmp_index, $object, $tmp_widget, $wp_registered_sidebars ) ){
											$collected_widgets[ $tmp_widget ] = $s_index;
										}
									}
								}
								otw_sbm_log( $tmp_index, "\t\t::collected[".implode( ',', array_keys( $collected_widgets ) )."]", 1, __FILE__, __LINE__ );
							}
							
						}else{
							otw_sbm_log( $index, "\t\t::old collected[".implode( ',', array_keys( $collected_widgets ) )."]", 1, __FILE__, __LINE__ );
						}
					}
				}else{
					otw_sbm_log( $index, "\tnothing in requested objects", 1, __FILE__, __LINE__ );
				}
				
				$collected_widgets = otw_filter_strict_widgets( $index, $collected_widgets );
				
				//fix the order of widgets
				if( is_array( $collected_widgets ) && count( $collected_widgets ) )
				{
					$filtered_widgets = array();
					asort( $collected_widgets );
					foreach( $collected_widgets as $tmp_widget => $tmp_order ){
					
						$filtered_widgets[] = $tmp_widget;
					}
				}
				
			}else{
				$filtered_widgets = $sidebars_widgets[ $index ];
			}
		}
		
		otw_sbm_log( $index, '<-| ('.implode( ',', $filtered_widgets ).')', 1, __FILE__, __LINE__ );
		return $filtered_widgets;
	}
}

/** get wp items based on type
  * @param string
  * @return array
  */
if( !function_exists( 'otw_get_wp_items' ) ){
	function otw_get_wp_items( $item_type ){
		switch( $item_type ){
			case 'page':
					$pages = get_pages();
					$pages = otw_group_items( $pages, 'ID', 'post_parent', 0 );
					return $pages;
				break;
			case 'post':
					return get_posts( array( 'numberposts' => -1 )  );
				break;
			case 'postsincategory':
					$categories = get_categories(array('hide_empty' => 0));
					$categories = otw_group_items( $categories, 'cat_ID', 'parent', 0 );
					return $categories;
				break;
			case 'postsintag':
					return get_terms( 'post_tag', '&orderby=name&hide_empty=0' );
				break;
			case 'category':
					$categories = get_categories(array('hide_empty' => 0));
					$categories = otw_group_items( $categories, 'cat_ID', 'parent', 0 );
					
					return $categories;
				break;
			case 'posttag':
					return get_terms( 'post_tag', '&orderby=name&hide_empty=0' );
				break;
			case 'pagetemplate':
					$templates = array();
					$all_templates = get_page_templates();
					
					if( is_array( $all_templates ) && count( $all_templates ) )
					{
						foreach( $all_templates as $page_template_name => $page_template_script )
						{
							$tplObject = new stdClass();
							$tplObject->name = $page_template_name;
							$tplObject->script = $page_template_script;
							$templates[] = $tplObject;
						}
					}
					return $templates;
				break;
			case 'archive':
					$archive_types = array();
					$a_types = array( 'daily' => __('Daily', 'otw_sbm'), 'monthly' => __('Monthly', 'otw_sbm'), 'yearly' => __('Yearly', 'otw_sbm') );

					foreach( $a_types as $a_type => $a_name )
					{
						$aObject = new stdClass();
						$aObject->ID = $a_type;
						$aObject->name = $a_name;
						$archive_types[] = $aObject;
					}
					return $archive_types;
				break;
			case 'customposttype':
					return get_post_types( array(  'public'   => true, '_builtin' => false ), 'object' );
				break;
			case 'templatehierarchy':
					$h_types = array();
					$a_types = array(
							'home'        =>    __('Home', 'otw_sbm'),
							'front'       =>    __('Front Page', 'otw_sbm'),
							'404'         =>    __('Error 404 Page', 'otw_sbm'),
							'search'      =>    __('Search', 'otw_sbm'),
							'date'        =>    __('Date', 'otw_sbm'),
							'author'      =>    __('Author', 'otw_sbm'),
							'category'    =>    __('Category', 'otw_sbm'),
							'tag'         =>    __('Tag', 'otw_sbm'),
							'taxonomy'    =>    __('Taxonomy', 'otw_sbm'),
							'archive'     =>    __('Archive', 'otw_sbm'),
							'single'      =>    __('Singular', 'otw_sbm'),
							'attachment'  =>    __('Attachment', 'otw_sbm'),
							'page'        =>    __('Page', 'otw_sbm')
						);

					foreach( $a_types as $a_type => $a_name )
					{
						$aObject = new stdClass();
						$aObject->ID = $a_type;
						$aObject->name = $a_name;
						$h_types[] = $aObject;
					}
					return $h_types;
				break;
			default:
					if( preg_match( "/^cpt_(.*)$/", $item_type, $matches ) ){
						return get_posts( array( 'post_type' =>  $matches[1], 'numberposts' => -1 )  );
					}elseif( preg_match( "/^ctx_(.*)$/", $item_type, $matches ) ){
						return get_terms( $matches[1], '&orderby=name&hide_empty=0' );
					}
				break;
		}
	}
}
/** group wp items by level for better view
 * 
 * @param array
 * @param string
 * @param string
 * @param string
 * @param integer
 * @return array
 */
if( !function_exists( 'otw_group_items' ) ){
	function otw_group_items( $items, $id, $parent, $level, $sub_level = 0 ){
	
		$parent_grouped = array();
		if( is_array( $items ) && count( $items ) ){
			
			foreach( $items as $item ){
			
				if( !isset( $parent_grouped[ $item->$parent ] ) ){
					$parent_grouped[ $item->$parent ] = array();
				}
				$parent_grouped[ $item->$parent ][ $item->$id ] = $item;
			}
		}
		
		$result = otw_add_grouped_items( $parent_grouped, $id, $parent, $level, $sub_level );
		
		return $result;
	}
}
/** add grouped wp items int array
 * 
 * @param array
 * @param string
 * @param string
 * @param string
 * @param integer
 * @return array
 */
if( !function_exists( 'otw_add_grouped_items' ) ){
	function otw_add_grouped_items( $items, $id, $parent, $level, $sub_level = 0 ){
		
		$results = array();
		if( isset( $items[ $level ] ) ){
			
			foreach( $items[ $level ] as $item ){
			
				$item->_sub_level = $sub_level;
				$results[] = $item;
				
				if( isset( $items[ $item->$id ] ) ){
					$sub_results = otw_add_grouped_items( $items, $id, $parent, $item->$id, $sub_level + 1 );
					
					foreach( $sub_results as $s_result ){
						$results[] = $s_result;
					}
				}
				
			}
			
		}
		return $results;
	}
}

/** get the attribute of wp item
  *  @param string
  *  @param stdClass
  *  @return string
  */
if( !function_exists( 'otw_wp_item_attribute' ) ){
	function otw_wp_item_attribute( $item_type, $attribute, $object ){
		
		switch( $attribute ){
			
			case 'ID':
					switch( $item_type ){
						case 'postsincategory':
								return $object->cat_ID;
							break;
						case 'category':
								return $object->cat_ID;
							break;
						case 'postsintag':
								return $object->term_id;
							break;
						case 'posttag':
								return $object->term_id;
							break;
						case 'pagetemplate':
								return $object->script;
							break;
						case 'customposttype':
								return $object->name;
							break;
						case 'author_archive':
								return $object->ID;
							break;
						default:
								if( preg_match( "/^ctx_(.*)$/", $item_type, $matches ) ){
									return $object->term_id;
								}elseif( preg_match( "/^(.*)_in_ctx_(.*)$/", $item_type, $matches ) ){
									return $object->term_id;
								}
								return $object->ID;
							break;
					}
				break;
			case 'TITLE':
					switch( $item_type ){
						case 'page':
						case 'post':
								return $object->post_title;
							break;
						case 'author_archive':
								return $object->display_name;
							break;
						case 'customposttype':
								return $object->label;
							break;
						default:
								if( preg_match( "/^cpt_(.*)$/", $item_type, $matches ) ){
									return $object->post_title;
								}
								return $object->name;
							break;
					}
				break;
		}
	}
}

/** sidebar widgets hook
  *  @param array
  *  @return array
  */
if( !function_exists( 'otw_sidebars_widgets' ) ){
	function otw_sidebars_widgets( $sidebars_widgets ){
		
		global $otw_registered_sidebars, $otw_replaced_sidebars;
		
		if( !is_array( $otw_replaced_sidebars ) || !count( $otw_replaced_sidebars ) ){
		//	return $sidebars_widgets;
		}
		
		if( is_admin() ){
			return $sidebars_widgets;
		}
		
		if( is_array( $sidebars_widgets ) ){
			
			foreach( $sidebars_widgets as $index => $widgets ){
				
				
				$tmp_index = otw_sbm_index( $index, $sidebars_widgets );
				
				if ( !empty($sidebars_widgets[$tmp_index]) ){
					$sidebars_widgets[$index] = otw_filter_siderbar_widgets( $tmp_index, $sidebars_widgets );
				}else{
					$sidebars_widgets[$index] = $sidebars_widgets[$tmp_index];
				}
				
			}
		}
		return $sidebars_widgets;
	}
}

/** meta boxes
  *  @param array
  *  @return array
  */
if( !function_exists( 'otw_sbm_meta_boxes' ) ){
	function otw_sbm_meta_boxes(){
		global $pagenow, $otw_plugin_options;
		
		if( ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) && ( get_post_type() == 'page' ) ){
		
			if( !isset( $otw_plugin_options['activate_old_grid'] ) || ( $otw_plugin_options['activate_old_grid'] ) ){
				add_meta_box('otw_sbm_pcm', __('Sidebar & Widget Manager - Widgetize page', 'otw_sbm'), 'otw_sbm_pcm_content','', 'normal', 'high');
			}
		}
	}
}

/** Column Manager Content
  *  @param array
  *  @return array
  */
if( !function_exists( 'otw_sbm_pcm_content' ) ){
	function otw_sbm_pcm_content(){
		global $post_id;
		
		$current_code = get_post_meta($post_id, 'otw_sbm_pcm', TRUE);
		
		if( isset( $_POST['_otw_sbm_pcm']['code'] ) ){
			$current_code = $_POST['_otw_sbm_pcm']['code'];
		}
		
		echo "\n<div>";
		echo "\n<p>".__( 'Widgetize this page:', 'otw_sbm')."<br />";
		echo "\n&nbsp;".__( '1) Create your column layout in a few clicks', 'otw_sbm')."<br />";
		echo "\n&nbsp;".__( '2) Insert the sidebars you have created with the Sidebar & Widget Manager', 'otw_sbm')."<br />";
		echo "\n".__('Unlimited Rows, Columns and Sidebars. No coding.', 'otw_sbm')."</p>";
		echo "<p><input type=\"button\" value=\"".__('Insert Row', 'otw_sbm')."\" class=\"button-primary\" id=\"otw_sbm_pcm_insert_row\" name=\"otw_sbm_pcm_insert_row\" /></p>";
		echo "\n<div id=\"otw-sbm-pcm-preview\"></div>";
		echo "\n<input type=\"hidden\" id=\"otw-sbm-pcm-code\" name=\"_otw_sbm_pcm[code]\" value=\"".htmlentities( $current_code, ENT_QUOTES, "UTF-8")."\" />";
		echo "\n<input type=\"hidden\" name=\"otw_sbm_pcm_noncename\" value=\"" . wp_create_nonce(__FILE__) . "\" />";
		echo "\n<div id=\"otw-sbm-pcm-shortcode-dialog\"></div>";
		echo "\n<div style=\"display: none;\">
			<span id=\"otw_sbm_pcm_texts_confirm_delete_row\">".__('Are you sure you want to delete this entire row?', 'otw_sbm')."</span>
			<span id=\"otw_sbm_pcm_texts_confirm_delete_shortcode\">".__('Are you sure you want to delete this item?', 'otw_sbm')."</span>
			<span id=\"otw_sbm_pcm_texts_add_item\">".__('Add Sidebar', 'otw_sbm')."</span>
			</div>";
		echo "\n<script type=\"text/javascript\">";
			echo "\n jQuery(document).ready(function(){
				otw_sbm_pcm = new otw_sbm_pcm_object();";
			echo "\notw_sbm_pcm_init(); });";
		echo "\n</script>";
		echo "\n</div>";
	}
}
/** Save Column Manager Content
  *  @param array
  *  @return array
  */
if( !function_exists( 'otw_sbm_pcm_save' ) ){
	function otw_sbm_pcm_save( $post_id ){
		
		if( get_post_type() != 'page' ){
			return $post_id;
		}
		
		if ( !isset( $_POST['otw_sbm_pcm_noncename'] ) || !wp_verify_nonce($_POST['otw_sbm_pcm_noncename'],__FILE__) ){
			return $post_id;
		}
		// validate user can edit
		if($_POST['post_type'] == 'page'){
			if (!current_user_can('edit_page', $post_id)){
				return $post_id;
			}
		}
		else{
			if (!current_user_can('edit_post', $post_id)){
				return $post_id;
			}
		}
		
		$current_code = get_post_meta($post_id, 'otw_sbm_pcm', TRUE);
		$new_code = $_POST['_otw_sbm_pcm']['code'];
		
		if( !$current_code && strlen( trim( $new_code ) )  ){
			update_post_meta($post_id,'otw_sbm_pcm',$new_code );
		}else{
			if( !strlen( trim( $new_code ) ) ){
				delete_post_meta($post_id,'otw_sbm_pcm');
			}else{
				update_post_meta($post_id,'otw_sbm_pcm',$new_code);
			}
		}
		
		return $post_id;
	}
}
/** Show Column Manager Content
  *  @param array
  *  @return array
  */
if( !function_exists( 'otw_sbm_pcm_show' ) ){
	function otw_sbm_pcm_show( $post_content ){
		global $post;
		
		$pcm_code = '';
		
		$content = '';
		
		if( isset( $post->ID ) ){
			$content = get_post_meta( $post->ID, 'otw_sbm_pcm', TRUE );
		}
		
		
		if( strlen( $content ) ){
			
			$rows = json_decode( $content );
			
			foreach( $rows as $row ){
			
				if( count( $row->cells ) ){
				
					foreach( $row->cells as $cell ){
					
						//$pcm_code .= '['.$cell->tag.']';
						$pcm_code .= '[sbm_column type='.$cell->tag.']';
						
						if( is_array( $cell->shortcodes ) && count( $cell->shortcodes ) ){
						
							foreach( $cell->shortcodes as $shortcode ){
								$pcm_code .= ' '.$shortcode->code;
							}
						}else{
							$pcm_code .= $cell->content;
						}
						//$pcm_code .= '[/'.$cell->tag.'] ';
						$pcm_code .= '[/sbm_column] ';
					}
				}
			}
		}
		return $post_content." ".$pcm_code." ";
	}
}
/**
 * Shortcode functions
 */
// Replace WP autop formatting
if (!function_exists( "otw_sbm_remove_wpautop")){
	function otw_sbm_remove_wpautop($content){
		$content = do_shortcode( shortcode_unautop( $content ) );
		$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content);
		return $content;
	}
}

/**
 *  Process shortcode
 *  @param array attribute / type
 *  @return string
 **/
if (!function_exists( "otw_sbm_shortcode_column" )){
	function otw_sbm_shortcode_column( $atts, $content = null ){
		
		$parts = explode( "_", $atts['type'] );
		
		$class = 'sbm';
		if( count( $parts ) >  1 ){
			$class .= '-'.$parts[0].'-'.$parts[1];
		
			if( $parts[ count( $parts ) -1 ] == 'last' ){
				$class .= ' last';
			}
		}
		return '<div class="'.$class.'">'. otw_sbm_remove_wpautop($content) . '</div>';
	}
}

/**
 *  Load items by given params
 *  @param array attribute / type
 *  @return array
 **/
if (!function_exists( "otw_sbm_get_filtered_items" )){
	function otw_sbm_get_filtered_items( $type, $filter, $sidebar_id, $displayed_items = 20, $id_in_list = array(), $id_not_in_list = array(), $show = 'all', $order = 'a_z', $current_page = 0 ){
		
		global $string_filter, $id_list_filter;
		
		$string_filter = $filter;
		$id_list_filter = $id_in_list;
		$pager_data = array();
		
		switch( $type )
		{
			case 'page':
					$args = array();
					$args['post_type']      = $type;
					$args['posts_per_page'] = -1;
					if( count( $id_list_filter ) ){
						$args['post__in']       = $id_list_filter;
					}
					if( $string_filter ){
						add_filter( 'posts_where', 'otw_sbm_post_by_title' );
					}
					
					if( otw_installed_plugin( 'buddypress' ) ){
						
						global $bp;
						
						if( isset( $bp->pages->activity ) && $bp->pages->activity->id ){
							$id_not_in_list[] = $bp->pages->activity->id;
						}
						if( isset( $bp->pages->members ) && $bp->pages->members->id ){
							$id_not_in_list[] = $bp->pages->members->id;
						}
					}
					
					if( count( $id_not_in_list ) ){
						$args['post__not_in'] = $id_not_in_list;
					}
					
					$the_query = new WP_Query( $args );
					
					$all_items = count( $the_query->posts );
					
					$pager_data = otw_get_pager_data( $all_items, $displayed_items, $current_page );
					
					$args['offset'] = $pager_data['first'];
					$args['posts_per_page'] = ($displayed_items)?$displayed_items:-1;
					
					switch( $order )
					{
						case 'a_z':
								$args['orderby']        = 'title';
								$args['order']          = 'ASC';
							break;
						case 'z_a':
								$args['orderby']        = 'title';
								$args['order']          = 'DESC';
							break;
						case 'date_latest':
								$args['orderby']        = 'date';
								$args['order']          = 'DESC';
							break;
						case 'date_oldest':
								$args['orderby']        = 'date';
								$args['order']          = 'ASC';
							break;
						case 'modified_latest':
								$args['orderby']        = 'modified';
								$args['order']          = 'DESC';
							break;
						case 'modified_oldest':
								$args['orderby']        = 'modified';
								$args['order']          = 'ASC';
							break;
						default:
								$args['orderby']        = 'ID';
								$args['order']          = 'DESC';
							break;
					}
					
					$the_query = new WP_Query( $args );
					
					if( $string_filter ){
						remove_filter('posts_where', 'otw_sbm_post_by_title');
					}
					
					return array( $all_items, $the_query->posts, $pager_data );
				break;
			case 'post':
					$args = array();
					$args['post_type']      = $type;
					$args['posts_per_page'] = -1;
					if( count( $id_list_filter ) ){
						$args['post__in']       = $id_list_filter;
					}
					if( $string_filter ){
						add_filter( 'posts_where', 'otw_sbm_post_by_title' );
					}
					
					if( count( $id_not_in_list ) ){
						$args['post__not_in'] = $id_not_in_list;
					}
					
					$the_query = new WP_Query( $args );
					
					$all_items = count( $the_query->posts );
					
					$pager_data = otw_get_pager_data( $all_items, $displayed_items, $current_page );
					
					$args['posts_per_page'] = ($displayed_items)?$displayed_items:-1;
					
					switch( $order )
					{
						case 'a_z':
								$args['orderby']        = 'title';
								$args['order']          = 'ASC';
							break;
						case 'z_a':
								$args['orderby']        = 'title';
								$args['order']          = 'DESC';
							break;
						case 'date_latest':
								$args['orderby']        = 'date';
								$args['order']          = 'DESC';
							break;
						case 'date_oldest':
								$args['orderby']        = 'date';
								$args['order']          = 'ASC';
							break;
						case 'modified_latest':
								$args['orderby']        = 'modified';
								$args['order']          = 'DESC';
							break;
						case 'modified_oldest':
								$args['orderby']        = 'modified';
								$args['order']          = 'ASC';
							break;
						default:
								$args['orderby']        = 'ID';
								$args['order']          = 'DESC';
							break;
					}
					
					$the_query = new WP_Query( $args );
					
					if( $string_filter ){
						remove_filter('posts_where', 'otw_sbm_post_by_title');
					}
					
					return array( $all_items, $the_query->posts, $pager_data );
				break;
			case 'category':
			case 'postsincategory':
					//first get all
					$args = array();
					$args['type']            = 'post';
					$args['hide_empty']      = 0;
					$args['number']          = 0;
					
					if( count( $id_list_filter ) ){
						sort( $id_list_filter );
						$args['include']  = $id_list_filter;
					}
					
					if( $string_filter ){
						$args['search'] = $string_filter;
					}
					
					if( count( $id_not_in_list ) ){
						sort( $id_not_in_list );
						$args['exclude'] = $id_not_in_list;
					}
					
					$all_items = count( get_categories( $args ) );
					
					$pager_data = otw_get_pager_data( $all_items, $displayed_items, $current_page );
					
					$args['offset'] = $pager_data['first'];
					$args['number']          = ($displayed_items)?$displayed_items:0;
					
					switch( $order )
					{
						case 'a_z':
								$args['orderby']        = 'name';
								$args['order']          = 'ASC';
							break;
						case 'z_a':
								$args['orderby']        = 'name';
								$args['order']          = 'DESC';
							break;
						case 'date_latest':
								$args['orderby']        = 'ID';
								$args['order']          = 'DESC';
							break;
						case 'date_oldest':
								$args['orderby']        = 'ID';
								$args['order']          = 'ASC';
							break;
						default:
								$args['orderby']        = 'ID';
								$args['order']          = 'DESC';
							break;
					}
					return array( $all_items, get_categories( $args ), $pager_data );
				break;
			case 'posttag':
			case 'postsintag':
					$args = array();
					$args['hide_empty']      = 0;
					$args['number']          = 0;
					
					if( count( $id_list_filter ) ){
						sort( $id_list_filter );
						$args['include']  = $id_list_filter;
					}
					
					if( $string_filter ){
						$args['search'] = $string_filter;
					}
					
					if( count( $id_not_in_list ) ){
						sort( $id_not_in_list );
						$args['exclude'] = $id_not_in_list;
					}
					
					$all_items = count( get_terms( 'post_tag', $args ) );
					
					$pager_data = otw_get_pager_data( $all_items, $displayed_items, $current_page );
					
					$args['offset'] 	 = $pager_data['first'];
					$args['number']          = ($displayed_items)?$displayed_items:0;
					
					switch( $order )
					{
						case 'a_z':
								$args['orderby']        = 'name';
								$args['order']          = 'ASC';
							break;
						case 'z_a':
								$args['orderby']        = 'name';
								$args['order']          = 'DESC';
							break;
						case 'date_latest':
								$args['orderby']        = 'ID';
								$args['order']          = 'DESC';
							break;
						case 'date_oldest':
								$args['orderby']        = 'ID';
								$args['order']          = 'ASC';
							break;
						default:
								$args['orderby']        = 'ID';
								$args['order']          = 'DESC';
							break;
					}
					return array( $all_items, get_terms( 'post_tag', $args ), $pager_data );
				break;
			case 'author_archive':
					$args = array();
					$args['number']          = 0;
					
					if( count( $id_list_filter ) ){
						sort( $id_list_filter );
						$args['include']  = $id_list_filter;
					}
					
					if( $string_filter ){
						$args['search'] = '*'.$string_filter.'*';
					}
					
					if( count( $id_not_in_list ) ){
						sort( $id_not_in_list );
						$args['exclude'] = $id_not_in_list;
					}
					
					$all_items = count( get_users( $args ) );
					
					$pager_data = otw_get_pager_data( $all_items, $displayed_items, $current_page );
					
					$args['offset'] 	 = $pager_data['first'];
					$args['number']          = ($displayed_items)?$displayed_items:0;
					
					switch( $order )
					{
						case 'a_z':
								$args['orderby']        = 'login';
								$args['order']          = 'ASC';
							break;
						case 'z_a':
								$args['orderby']        = 'login';
								$args['order']          = 'DESC';
							break;
						case 'date_latest':
								$args['orderby']        = 'registered';
								$args['order']          = 'DESC';
							break;
						case 'date_oldest':
								$args['orderby']        = 'registered';
								$args['order']          = 'ASC';
							break;
						default:
								$args['orderby']        = 'ID';
								$args['order']          = 'DESC';
							break;
					}
					
					return array( $all_items, get_users( $args ), $pager_data );
				break;
			case 'customposttype':
			case 'templatehierarchy':
			case 'archive':
					$all_items = otw_get_wp_items( $type );
					$items = array();
					foreach( $all_items as $item_key => $item_object ){
					
						if( $string_filter ){
							if( ( stripos( $item_object->name, $string_filter ) === false ) ){
								continue;
							}
						}
						
						if( count( $id_list_filter ) && !in_array( $item_object->ID, $id_list_filter ) && !in_array( 'all', $id_list_filter ) ){
							continue;
						}
						if( count( $id_not_in_list ) && ( in_array( $item_object->ID, $id_not_in_list ) || in_array( 'all', $id_not_in_list ) ) ){
							continue;
						}
						$items[] = $item_object;
					}
					$all_items = count( $items );
					$pager_data = otw_get_pager_data( $all_items, $displayed_items, $current_page );
					
					$sort_args = array();
					switch( $order )
					{
						case 'a_z':
								$sort_args['name'] = 'ASC';
							break;
						case 'z_a':
								$sort_args['name'] = 'DESC';
							break;
						default:
								$sort_args['name'] = 'ASC';
							break;
					}
					
					if( count( $items ) ){
						
						$items = otw_asort( $items, $sort_args );
						if( $displayed_items ){
							$items = array_slice( $items, $pager_data['first'], $displayed_items );
						}
					}
					
					return array( $all_items, $items, $pager_data );
				break;
			case 'pagetemplate':
					$all_items = otw_get_wp_items( $type );
					$items = array();
					foreach( $all_items as $item_key => $item_object ){
					
						if( $string_filter ){
							if( ( stripos( $item_object->name, $string_filter ) === false ) ){
								continue;
							}
						}
						if( count( $id_list_filter ) && !in_array( $item_object->script, $id_list_filter ) && !in_array( 'all', $id_list_filter ) ){
							continue;
						}
						if( count( $id_not_in_list ) && ( in_array( $item_object->script, $id_not_in_list ) || in_array( 'all', $id_not_in_list ) ) ){
							continue;
						}
						$items[] = $item_object;
					}
					$all_items = count( $items );
					$pager_data = otw_get_pager_data( $all_items, $displayed_items, $current_page );
					
					$sort_args = array();
					switch( $order )
					{
						case 'a_z':
								$sort_args['name'] = 'ASC';
							break;
						case 'z_a':
								$sort_args['name'] = 'DESC';
							break;
						default:
								$sort_args['name'] = 'ASC';
							break;
					}
					
					if( count( $items ) ){
						
						$items = otw_asort( $items, $sort_args );
						if( $displayed_items ){
							$items = array_slice( $items, $pager_data['first'], $displayed_items );
						}
					}
					
					return array( $all_items, $items, $pager_data );
				break;
			case 'userroles':
					$items = array();
					$wp_roles = new WP_Roles;
					$all_items = $wp_roles->get_names();
					$all_items['notlogged'] = __( 'Not Logged in' );
					
					foreach( $all_items as $u_role_code => $u_role_name ){
						
						if( $string_filter ){
							
							if( ( stripos( $u_role_name, $string_filter ) === false ) ){
								continue;
							}
						}
						
						
						$item = new stdClass();
						$item->ID = $u_role_code;
						if( $u_role_code != 'notlogged' ){
							$item->name = __( 'Logged in as ', 'otw_sbm' ).$u_role_name;
						}else{
							$item->name = $u_role_name;
						}
						
						if( count( $id_list_filter ) && !in_array( $item->ID, $id_list_filter ) && !in_array( 'all', $id_list_filter ) ){
							continue;
						}
						if( count( $id_not_in_list ) && ( in_array( $item->ID, $id_not_in_list ) || in_array( 'all', $id_not_in_list ) ) ){
							continue;
						}
						
						$items[] = $item;
						
					}
					$all_items = count( $items );
					$pager_data = otw_get_pager_data( $all_items, $displayed_items, $current_page );
					
					switch( $order )
					{
						case 'a_z':
								$sort_args['name'] = 'ASC';
							break;
						case 'z_a':
								$sort_args['name'] = 'DESC';
							break;
						default:
								$sort_args['name'] = 'ASC';
							break;
					}
					
					if( count( $items ) ){
						
						$items = otw_asort( $items, $sort_args );
						if( $displayed_items ){
							$items = array_slice( $items, $pager_data['first'], $displayed_items );
						}
					}
					
					return array( count( $all_items ), $items, $pager_data );
				break;
			case 'wpmllanguages':
					if( otw_installed_plugin( 'wpml' ) ){
						
						$wpml_languages = icl_get_languages( 'skip_missing=0' );
						
						$all_items = count( $wpml_languages );
						
						$items = array();
						foreach( $wpml_languages as $wpml_lang ){
							
							if( $string_filter ){
								
								if( ( stripos( $wpml_lang['translated_name'], $string_filter ) === false ) && ( stripos( $wpml_lang['translated_name'], $string_filter ) === false ) ){
									continue;
								}
							}
							
							$item = new stdClass();
							$item->ID = $wpml_lang['language_code'];
							$item->name = '<img src="'.$wpml_lang['country_flag_url'].'" alt="'.$wpml_lang['language_code'].'" border="0"/>&nbsp;'.$wpml_lang['native_name'];
							
							if( count( $id_list_filter ) && !in_array( $item->ID, $id_list_filter ) && !in_array( 'all', $id_list_filter ) ){
								continue;
							}
							if( count( $id_not_in_list ) && ( in_array( $item->ID, $id_not_in_list ) || in_array( 'all', $id_not_in_list ) ) ){
								continue;
							}
							
							$items[] = $item;
						}
						
						$all_items = count( $items );
						$pager_data = otw_get_pager_data( $all_items, $displayed_items, $current_page );
						
						switch( $order )
						{
							case 'a_z':
									$sort_args['name'] = 'ASC';
								break;
							case 'z_a':
									$sort_args['name'] = 'DESC';
								break;
							default:
									$sort_args['name'] = 'ASC';
								break;
						}
						
						if( count( $items ) ){
							
							$items = otw_asort( $items, $sort_args );
							if( $displayed_items ){
								$items = array_slice( $items, $pager_data['first'], $displayed_items );
							}
						}
						return array( $all_items, $items, $pager_data );
					}
				break;
			case 'bbp_page':
					if( otw_installed_plugin( 'bbpress' ) ){
						
						$bbp_pages = array();
						
						$bbp_pages[] = array( 'id' => 'forums', 'name' => __( 'Forums', 'otw_sbm' ) );
						$bbp_pages[] = array( 'id' => 'noreplies', 'name' => __( 'Topics no reply', 'otw_sbm' ) );
						$bbp_pages[] = array( 'id' => 'mostpopular', 'name' => __( 'Topics popular', 'otw_sbm' ) );
						$bbp_pages[] = array( 'id' => 'search', 'name' => __( 'Search', 'otw_sbm' ) );
						$bbp_pages[] = array( 'id' => 'singleuser', 'name' => __( 'User pages', 'otw_sbm' ) );
						
						$all_items = count( $bbp_pages );
						
						$items = array();
						foreach( $bbp_pages as $bbp_page ){
							
							if( $string_filter ){
								
								if( stripos( $bbp_page['name'], $string_filter ) === false ){
									continue;
								}
							}
							
							$item = new stdClass();
							$item->ID = $bbp_page['id'];
							$item->name = $bbp_page['name'];
							
							if( count( $id_list_filter ) && !in_array( $item->ID, $id_list_filter ) && !in_array( 'all', $id_list_filter ) ){
								continue;
							}
							if( count( $id_not_in_list ) && ( in_array( $item->ID, $id_not_in_list ) || in_array( 'all', $id_not_in_list ) ) ){
								continue;
							}
							
							$items[] = $item;
						}
						
						$all_items = count( $items );
						$pager_data = otw_get_pager_data( $all_items, $displayed_items, $current_page );
						
						switch( $order )
						{
							case 'a_z':
									$sort_args['name'] = 'ASC';
								break;
							case 'z_a':
									$sort_args['name'] = 'DESC';
								break;
							default:
									$sort_args['name'] = 'ASC';
								break;
						}
						
						if( count( $items ) ){
							
							$items = otw_asort( $items, $sort_args );
							if( $displayed_items ){
								$items = array_slice( $items, $pager_data['first'], $displayed_items );
							}
						}
						
						return array( $all_items, $items, $pager_data );
					}
				break;
			case 'buddypress_page':
					if( otw_installed_plugin( 'buddypress' ) ){
						global $bp;
						$buddypress_pages = array();
						
						if( isset( $bp->pages->activity ) && $bp->pages->activity->id ){
							$buddypress_pages[] = array( 'id' => $bp->pages->activity->id, 'name' => $bp->pages->activity->title.' '.__( 'page', 'otw_sbm' ) );
						}
						if( isset( $bp->pages->members ) && $bp->pages->members->id ){
							$buddypress_pages[] = array( 'id' => $bp->pages->members->id, 'name' => $bp->pages->members->title.' '.__( 'pages', 'otw_sbm' ) );
						}
						
						$all_items = count( $buddypress_pages );
						
						$items = array();
						foreach( $buddypress_pages as $buddypress_page ){
							
							if( $string_filter ){
								
								if( stripos( $buddypress_page['name'], $string_filter ) === false ){
									continue;
								}
							}
							
							$item = new stdClass();
							$item->ID = $buddypress_page['id'];
							$item->name = $buddypress_page['name'];
							
							if( count( $id_list_filter ) && !in_array( $item->ID, $id_list_filter ) && !in_array( 'all', $id_list_filter ) ){
								continue;
							}
							if( count( $id_not_in_list ) && ( in_array( $item->ID, $id_not_in_list ) || in_array( 'all', $id_not_in_list ) ) ){
								continue;
							}
							
							$items[] = $item;
						}
						
						$all_items = count( $items );
						$pager_data = otw_get_pager_data( $all_items, $displayed_items, $current_page );
						
						switch( $order )
						{
							case 'a_z':
									$sort_args['name'] = 'ASC';
								break;
							case 'z_a':
									$sort_args['name'] = 'DESC';
								break;
							default:
									$sort_args['name'] = 'ASC';
								break;
						}
						
						if( count( $items ) ){
							
							$items = otw_asort( $items, $sort_args );
							if( $displayed_items ){
								$items = array_slice( $items, $pager_data['first'], $displayed_items );
							}
						}
						
						return array( $all_items, $items, $pager_data );
					}
					
				break;
			default:
					
					if( preg_match( "/^cpt_(.*)$/", $type, $matches ) ){
						
						$args = array();
						$args['post_type']      = $matches[1];
						$args['posts_per_page'] = -1;
						
						if( count( $id_list_filter ) ){
							$args['post__in']       = $id_list_filter;
						}
						
						if( $string_filter ){
							add_filter( 'posts_where', 'otw_sbm_post_by_title' );
						}
						
						if( count( $id_not_in_list ) ){
							$args['post__not_in'] = $id_not_in_list;
						}
						
						$the_query = new WP_Query( $args );
						
						$all_items = count( $the_query->posts );
						
						$pager_data = otw_get_pager_data( $all_items, $displayed_items, $current_page );
						
						$args['posts_per_page'] = ($displayed_items)?$displayed_items:-1;
						
						switch( $order )
						{
							case 'a_z':
									$args['orderby']        = 'title';
									$args['order']          = 'ASC';
								break;
							case 'z_a':
									$args['orderby']        = 'title';
									$args['order']          = 'DESC';
								break;
							case 'date_latest':
									$args['orderby']        = 'date';
									$args['order']          = 'DESC';
								break;
							case 'date_oldest':
									$args['orderby']        = 'date';
									$args['order']          = 'ASC';
								break;
							case 'modified_latest':
									$args['orderby']        = 'modified';
									$args['order']          = 'DESC';
								break;
							case 'modified_oldest':
									$args['orderby']        = 'modified';
									$args['order']          = 'ASC';
								break;
								
							default:
									$args['orderby']        = 'ID';
									$args['order']          = 'DESC';
								break;
						}
						
						$the_query = new WP_Query( $args );
						
						if( $string_filter ){
							remove_filter('posts_where', 'otw_sbm_post_by_title');
						}
						
						return array( $all_items, $the_query->posts, $pager_data );
					}elseif( preg_match( "/^ctx_(.*)$/", $type, $matches ) ){
						
						$args = array();
						$args['hide_empty']      = 0;
						$args['number']          = 0;
						
						if( count( $id_list_filter ) ){
							sort( $id_list_filter );
							$args['include']  = $id_list_filter;
						}
						
						if( $string_filter ){
							$args['search'] = $string_filter;
						}
						
						if( count( $id_not_in_list ) ){
							sort( $id_not_in_list );
							$args['exclude'] = $id_not_in_list;
						}
						
						$all_items = count( get_terms( $matches[1], $args ) );
						
						$pager_data = otw_get_pager_data( $all_items, $displayed_items, $current_page );
						
						$args['offset'] = $pager_data['first'];
						$args['number']          = ($displayed_items)?$displayed_items:0;
						
						switch( $order )
						{
							case 'a_z':
									$args['orderby']        = 'name';
									$args['order']          = 'ASC';
								break;
							case 'z_a':
									$args['orderby']        = 'name';
									$args['order']          = 'DESC';
								break;
							case 'date_latest':
									$args['orderby']        = 'ID';
									$args['order']          = 'DESC';
								break;
							case 'date_oldest':
									$args['orderby']        = 'ID';
									$args['order']          = 'ASC';
								break;
							default:
									$args['orderby']        = 'ID';
									$args['order']          = 'DESC';
								break;
						}
						
						return array( $all_items, get_terms( $matches[1], $args ), $pager_data );
					}elseif( preg_match( "/(.*)_in_ctx_(.*)$/", $type, $matches ) ){
						
						$args = array();
						$args['hide_empty']      = 0;
						$args['number']          = 0;
						
						if( count( $id_list_filter ) ){
							sort( $id_list_filter );
							$args['include']  = $id_list_filter;
						}
						
						if( $string_filter ){
							$args['search'] = $string_filter;
						}
						
						if( count( $id_not_in_list ) ){
							sort( $id_not_in_list );
							$args['exclude'] = $id_not_in_list;
						}
						
						$all_items = count( get_terms( $matches[2], $args ) );
						
						$pager_data = otw_get_pager_data( $all_items, $displayed_items, $current_page );
						
						$args['offset'] = $pager_data['first'];
						$args['number']          = ($displayed_items)?$displayed_items:0;
						
						switch( $order )
						{
							case 'a_z':
									$args['orderby']        = 'name';
									$args['order']          = 'ASC';
								break;
							case 'z_a':
									$args['orderby']        = 'name';
									$args['order']          = 'DESC';
								break;
							case 'date_latest':
									$args['orderby']        = 'ID';
									$args['order']          = 'DESC';
								break;
							case 'date_oldest':
									$args['orderby']        = 'ID';
									$args['order']          = 'ASC';
								break;
							default:
									$args['orderby']        = 'ID';
									$args['order']          = 'DESC';
								break;
						}
						return array( $all_items, get_terms( $matches[2], $args ), $pager_data );
					}
				break;
		}
		
		return array();
	}
}
if (!function_exists( "otw_sbm_post_by_title" )){
	function otw_sbm_post_by_title( $query ){
		
		global $string_filter, $id_list_filter;
		
		$query .= " AND post_title LIKE '%".$string_filter."%'";
		return $query;
	}
}

if( !function_exists( 'otw_sbm_log' ) ){
	function otw_sbm_log( $index, $string, $prefix = 1, $suffix = "\n", $file = '', $line = '' ){
		
		if( function_exists( 'otw_log' ) ){
			otw_log( $index, $string, $prefix, $suffix, $file, $line );
		}
	}
}
if( !function_exists( 'otw_get_strict_filters' ) ){
	function otw_get_strict_filters(){
		
		global $current_user;
		$filters = array();
		
		//apply user roles
		if ( function_exists('get_currentuserinfo') ){
			get_currentuserinfo();
		}
		
		if( isset( $current_user->ID ) && intval( $current_user->ID ) && isset( $current_user->roles ) && is_array( $current_user->roles ) && count( $current_user->roles ) ){
			
			$filter_key = count( $filters );
			$filters[ $filter_key ][0] = 'userroles';
			$filters[ $filter_key ][1] = array();
			foreach( $current_user->roles as $u_role ){
				$filters[ $filter_key ][1][] = $u_role;
			}
			$filters[ $filter_key ][2] = 'any';
		}
		else
		{
			$filter_key = count( $filters );
			$filters[ $filter_key ][0] = 'userroles';
			$filters[ $filter_key ][1] = array();
			$filters[ $filter_key ][1][] = 'notlogged';
			$filters[ $filter_key ][2] = 'any';
		}
		
		if( otw_installed_plugin( 'wpml' ) && defined( 'ICL_LANGUAGE_CODE' ) ){
			
			$filter_key = count( $filters );
			$filters[ $filter_key ][0] = 'wpmllanguages';
			$filters[ $filter_key ][1] = array();
			$filters[ $filter_key ][1][] = ICL_LANGUAGE_CODE;
			$filters[ $filter_key ][2] = 'all';
		}
		return $filters;
	}
}
/**
 * check all colected widgets for a sidebar if match all strict filters
 * @param string sidebar index
 * @param array collected widgets
 * @return array
 */
if( !function_exists( 'otw_filter_strict_widgets' ) ){
	function otw_filter_strict_widgets( $index, $collected_widgets ){
		
		global  $wp_registered_sidebars;
		
		$filters = otw_get_strict_filters();
		
		$strict_filtered_widgets = $collected_widgets;
		
		if( is_array( $filters ) && count( $filters ) ){
			
			if( isset( $wp_registered_sidebars[ $index ] ) ){
				
				if( is_array( $strict_filtered_widgets ) && count( $strict_filtered_widgets ) ){
				
					$filters = otw_get_strict_filters();
					
					foreach( $collected_widgets as $widget => $widget_order){
						
						foreach( $filters as $filter ){
							
							switch( $filter[2] ){
								case 'any':
										$match_any = false;
										
										if( isset( $wp_registered_sidebars[$index]['widgets_settings'] ) &&  isset( $wp_registered_sidebars[$index]['widgets_settings'][$filter[0]] ) ){
											
											if( isset( $wp_registered_sidebars[$index]['widgets_settings'][ $filter[0] ]['_otw_wc'] ) && isset( $wp_registered_sidebars[$index]['widgets_settings'][ $filter[0] ]['_otw_wc'][ $widget ] ) && in_array( $wp_registered_sidebars[$index]['widgets_settings'][ $filter[0] ]['_otw_wc'][ $widget ] , array( 'vis', 'invis' ) )  ){
												
												if( $wp_registered_sidebars[$index]['widgets_settings'][ $filter[0] ]['_otw_wc'][ $widget ] == 'vis' ){
													$match_any = true;
												}
											}else{
												foreach( $filter[1] as $v_filter ){
													
													if( !isset( $wp_registered_sidebars[$index]['widgets_settings'][ $filter[0] ][ $v_filter ] ) || !isset( $wp_registered_sidebars[$index]['widgets_settings'][ $filter[0] ][ $v_filter ]['exclude_widgets'] ) || !isset( $wp_registered_sidebars[$index]['widgets_settings'][ $filter[0] ][ $v_filter ]['exclude_widgets'][$widget] ) ){
														$match_any = true;
														break;
													}
												}
											}
										}elseif( isset( $wp_registered_sidebars[$index]['widgets_settings'] ) && !isset( $wp_registered_sidebars[$index]['widgets_settings'][$filter[0]] ) ){
											$match_any = true;
										}elseif( !isset( $wp_registered_sidebars[$index]['widgets_settings'] ) ){
											$match_any = true;
										}
										
										if( !$match_any && isset( $strict_filtered_widgets[ $widget ] ) ){
											unset( $strict_filtered_widgets[ $widget ] );
										}
									break;
								case 'all':
										$dont_match_one = false;
										
										if( isset( $wp_registered_sidebars[$index]['widgets_settings'] ) &&  isset( $wp_registered_sidebars[$index]['widgets_settings'][$filter[0]] ) ){
										
											if( isset( $wp_registered_sidebars[$index]['widgets_settings'][ $filter[0] ]['_otw_wc'] ) && isset( $wp_registered_sidebars[$index]['widgets_settings'][ $filter[0] ]['_otw_wc'][ $widget ] ) ){
												
												if( $wp_registered_sidebars[$index]['widgets_settings'][ $filter[0] ]['_otw_wc'][ $widget ] == 'invis' ){
													$dont_match_one = true;
												}
											}else{
												foreach( $filter[1] as $v_filter ){
													
													if( isset( $wp_registered_sidebars[$index]['widgets_settings'][ $filter[0] ][ $v_filter ] ) && isset( $wp_registered_sidebars[$index]['widgets_settings'][ $filter[0] ][ $v_filter ]['exclude_widgets'] ) && isset( $wp_registered_sidebars[$index]['widgets_settings'][ $filter[0] ][ $v_filter ]['exclude_widgets'][$widget] ) ){
														$dont_match_one = true;
													}
												}
											}
										}
										
										if( $dont_match_one && isset( $strict_filtered_widgets[ $widget ] ) ){
											unset( $strict_filtered_widgets[ $widget ] );
										}
									break;
							}
						}
					}
				}
			}
		}
		
		return $strict_filtered_widgets;
	}
}
/**
 * check if given sidebar match all strict filters
 * @param index sidebar index
 * @return boolean
 */
if( !function_exists( 'otw_filter_strict_sidebar_index' ) ){
	function otw_filter_strict_sidebar_index( $index ){
		
		global $wp_registered_sidebars;
		
		$result = true;
		
		$filters = otw_get_strict_filters();
		
		if( is_array( $filters ) && count( $filters ) ){
			
			if( $result ){
				
				foreach( $filters as $filter ){
					
					switch( $filter[2] ){
					
						case 'any':
								$match_any = false;
								if( isset( $wp_registered_sidebars[ $index ]['validfor'][ $filter[0] ] ) && is_array( $wp_registered_sidebars[ $index ]['validfor'][ $filter[0] ] ) && count( $wp_registered_sidebars[ $index ]['validfor'][ $filter[0] ] ) ){
									
									if( isset( $wp_registered_sidebars[ $index ]['validfor'][ $filter[0] ]['all'] ) ){
										$match_any = true;
									}else{
										foreach( $filter[1] as $s_filter ){
											
											if( array_key_exists( $s_filter, $wp_registered_sidebars[ $index ]['validfor'][ $filter[0] ] ) ){
											
												$match_any = true;
												break;
											}
										}
									}
								}
								if( !$match_any ){
									$result = false;
								}
							break;
						case 'all':
								$dont_match_one = false;
								
								foreach( $filter[1] as $s_filter ){
								
									if( isset( $wp_registered_sidebars[ $index ]['validfor'][ $filter[0] ] ) && is_array( $wp_registered_sidebars[ $index ]['validfor'][ $filter[0] ] ) && count( $wp_registered_sidebars[ $index ]['validfor'][ $filter[0] ] ) ){
										
										if( !isset( $wp_registered_sidebars[ $index ]['validfor'][ $filter[0] ]['all'] ) ){
											
											if( !array_key_exists( $s_filter, $wp_registered_sidebars[ $index ]['validfor'][ $filter[0] ] ) ){
												$dont_match_one = true;
												break;
											}
										}
									}else{
										$dont_match_one = true;
										break;
									}
								}
								if( $dont_match_one ){
									$result = false;
								}
							break;
					}
				}
			}
		}
		
		return $result;
		
	}
}
/**
 * Check if external plugin is installed
 *
 * @param string - plugin name
 * @return boolean
 */
if( !function_exists( 'otw_installed_plugin' ) ){
	function otw_installed_plugin( $plugin_name ){
		
		$installed = false;
		switch( $plugin_name ){
			case 'bbpress':
					if(function_exists( 'bbp_get_db_version_raw') && bbp_get_db_version_raw() ){
						$installed = true;
					}
				break;
			case 'wpml':
					if( function_exists( 'icl_get_languages' ) ){
						$installed = true;
					}
				break;
			case 'buddypress':
					if( class_exists( 'BuddyPress' ) ){
						
						global $bp;
						
						if( strtolower( get_class( $bp ) ) == 'buddypress' )
						{
							$installed = true;
						}
					}
				break;
		}
		
		return $installed;
	}
}
/**
 * Build pager data
 *
 * @param integer total items
 * @param integer total items returned for with limit
 * @param integer limit
 * @param integer current page
 * @return array
 */
if( !function_exists( 'otw_get_pager_data' ) ){
	function otw_get_pager_data( $total_items, $items_limit, $current_page  ){
		$pager_data = array();
		
		$pager_data['current'] = $current_page;
		$pager_data['links'] = array();
		$pager_data['links']['next'] = false;
		$pager_data['links']['prev'] = false;
		$pager_data['links']['first']= false;
		$pager_data['links']['last'] = false;
		$pager_data['links']['page'] = array();
		$pager_data['first'] = 0;
		
		if( $items_limit ){
			
			if( ( $total_items %  $items_limit ) == 0 ){
				$pager_data['pages'] = $total_items / $items_limit;
			}else{
				$pager_data['pages'] = $total_items / $items_limit;
				$pager_data['pages'] = (int)$pager_data['pages'] + 1;
			}
			
			if( $pager_data['current'] >= $pager_data['pages'] ){
				$pager_data['current'] = 0;
			}
			
			$pager_data['first'] = $pager_data['current'] * $items_limit;
			$pager_data['last']  = $pager_data['first'] + $items_limit - 1;
			
			if( $pager_data['pages'] > 1 ){
				
				if( $pager_data['current'] < ( $pager_data['pages'] - 1 ) ){
					$pager_data['links']['next'] = $pager_data['current'] + 1;
					$pager_data['links']['last'] = ( $pager_data['pages'] - 1 );
				}
			}
			if( $pager_data['current'] > 0 ){
				$pager_data['links']['first'] = 0;
				$pager_data['links']['prev'] = $pager_data['current'] - 1;
			}
			
			$l_size = 3;
			if( $pager_data['pages'] > 1 ){
				$pager_data['links']['page'][] = $pager_data['current'];
				//build page numbe links
				for( $cP = 1; $cP <= $l_size; $cP++ ){
					
					if( ( $pager_data['current'] - $cP ) >= 0 ){
						$pager_data['links']['page'][] = $pager_data['current'] - $cP;
					}elseif( ( $pager_data['current'] + $l_size + $cP ) < $pager_data['pages'] ){
						$pager_data['links']['page'][] = $pager_data['current'] + $l_size + $cP;
					}
					
					if( ( $pager_data['current'] + $cP ) < $pager_data['pages'] ){
						$pager_data['links']['page'][] = $pager_data['current'] + $cP;
					}elseif( ( $pager_data['current'] - $l_size - $cP ) >= 0 ){
						$pager_data['links']['page'][] = $pager_data['current'] - $l_size - $cP;
					}
				}
				sort( $pager_data['links']['page'] );
			}
		}
		return $pager_data;
	}
}

/**
 * Return possible sort options per type
 */
if( !function_exists( 'otw_get_item_sort_options' ) ){
	function otw_get_item_sort_options( $item_type ){
	
		$sort_options = array();
		
		switch( $item_type ){
		
			case 'page':
			case 'post':
					$sort_options['a_z'] = __( 'Alphabetically: A-Z', 'otw_sbm' );
					$sort_options['z_a'] = __( 'Alphabetically: Z-A', 'otw_sbm' );
					$sort_options['date_latest'] = __( 'Latest created', 'otw_sbm' );
					$sort_options['date_oldest'] = __( 'Oldest created', 'otw_sbm' );
					$sort_options['modified_latest'] = __( 'Latest Modified', 'otw_sbm' );
					$sort_options['modified_oldest'] = __( 'Oldest Modified', 'otw_sbm' );
				break;
			case 'templatehierarchy':
			case 'pagetemplate':
			case 'archive':
			case 'author_archive':
			case 'userroles':
			case 'wpmllanguages':
			case 'bbp_page':
			case 'buddypress_page':
					$sort_options['a_z'] = __( 'Alphabetically: A-Z', 'otw_sbm' );
					$sort_options['z_a'] = __( 'Alphabetically: Z-A', 'otw_sbm' );
				break;
			default:
					if( preg_match( "/^cpt_(.*)$/", $item_type, $matches ) ){
						$sort_options['a_z'] = __( 'Alphabetically: A-Z', 'otw_sbm' );
						$sort_options['z_a'] = __( 'Alphabetically: Z-A', 'otw_sbm' );
						$sort_options['date_latest'] = __( 'Latest created', 'otw_sbm' );
						$sort_options['date_oldest'] = __( 'Oldest created', 'otw_sbm' );
						$sort_options['modified_latest'] = __( 'Latest Modified', 'otw_sbm' );
						$sort_options['modified_oldest'] = __( 'Oldest Modified', 'otw_sbm' );
					}else{
						$sort_options['a_z'] = __( 'Alphabetically: A-Z', 'otw_sbm' );
						$sort_options['z_a'] = __( 'Alphabetically: Z-A', 'otw_sbm' );
						$sort_options['date_latest'] = __( 'Latest created', 'otw_sbm' );
						$sort_options['date_oldest'] = __( 'Oldest created', 'otw_sbm' );
					}
				break;
		}
		return $sort_options;
	}
}

/**
 * Array sort
 */
if( !function_exists( 'otw_asort' ) ){
	function otw_asort( $array, $settings ){
		
		global $otw_asort_fields;
		
		$otw_asort_fields = $settings;
		uasort( $array, 'otw_asort_compare' );
		
		return $array;
	}
}
if( !function_exists( 'otw_asort_compare' ) ){
	function otw_asort_compare( $item_1, $item_2 ){
		
		global $otw_asort_fields;
		
		foreach( $otw_asort_fields as $field => $order ){
		
			switch( strtolower( gettype( $item_1 ) ) ){
				
				case 'object':
						if( isset( $item_1->$field ) && isset( $item_2->$field ) ){
							
							$s_result = strnatcmp( $item_1->$field, $item_2->$field );
							
							if( $s_result > 0 ){
								return ( $order == "ASC" ) ? 1 : -1;
							}elseif( $s_result < 0 ){
								return ( $order == "ASC" ) ? -1 : 1;
							}
							
						}elseif( isset( $item_1->$field ) && !isset( $item_2->$field ) ){
							
							return ( $order == "ASC" ) ? 1 : -1;
							
						}elseif( !isset( $item_1->$field ) && isset( $item_2->$field ) ){
							
							return ( $order == "ASC" ) ? -1 : 1;
							
						}
					break;
			}
		}
		return 0;
	}
}
if( !function_exists( 'otw_sbm_get_total_not_excluded' ) ){
	function otw_sbm_get_total_not_excluded( $otw_sidebar_id, $widget, $wp_item_type ){
		
		global $wp_registered_sidebars;
		
		$total_selected = 0;
		$total_valid    = 0;
		
		$items = otw_sbm_get_filtered_items( $wp_item_type, '', $otw_sidebar_id, 0 );
		$valid_items = array();
		if( count( $items[1] ) ){
			foreach( $items[1] as $wpItem ){
				$valid_items[ otw_wp_item_attribute( $wp_item_type, 'ID', $wpItem ) ] = otw_wp_item_attribute( $wp_item_type, 'ID', $wpItem );
			}
		}
		
		if( isset( $wp_registered_sidebars[ $otw_sidebar_id ]['validfor'][ $wp_item_type ] ) && !isset( $wp_registered_sidebars[ $otw_sidebar_id ]['validfor'][ $wp_item_type ]['all'] ) ){
			$tmp_valid_items = $valid_items;
			foreach( $tmp_valid_items as $item_id ){
				if( !array_key_exists( $item_id, $wp_registered_sidebars[ $otw_sidebar_id ]['validfor'][ $wp_item_type ] ) ){
					unset( $valid_items[ $item_id ] );
				}
			}
		}
		$total_valid = count( $valid_items );
		if( $total_valid ){
			
			$otw_widget_settings = get_option( 'otw_widget_settings' );
			
			if( isset( $otw_widget_settings[ $otw_sidebar_id ][ $wp_item_type ]['_otw_wc'] ) && isset( $otw_widget_settings[ $otw_sidebar_id ][ $wp_item_type ]['_otw_wc'][$widget] ) ){
				
				if( $otw_widget_settings[ $otw_sidebar_id ][ $wp_item_type ]['_otw_wc'][$widget] == 'vis' ){
					$total_selected = count( $valid_items );
				}elseif( $otw_widget_settings[ $otw_sidebar_id ][ $wp_item_type ]['_otw_wc'][$widget] == 'invis' ){
					$total_selected = 0;
				}
			}else{
				if( isset(  $otw_widget_settings[ $otw_sidebar_id ][ $wp_item_type ] ) ){
					
					foreach( $otw_widget_settings[ $otw_sidebar_id ][ $wp_item_type ] as $item_type_id => $item_widget_data ){
						
						if( $item_type_id == '_otw_wc' ){
							continue;
						}
						if( !in_array( $item_type_id, $valid_items ) ){
							continue;
						}
						
						if( isset( $item_widget_data['exclude_widgets'] ) && isset( $item_widget_data['exclude_widgets'][ $widget ] ) ){
							unset(  $valid_items[ $item_type_id ] );
						}
					}
				}
				$total_selected = count( $valid_items );
			}
			
		}
		return array( $total_valid, $total_selected );
	}
}

if( !function_exists( 'otw_wp_item_exclude' ) ){
	function otw_wp_item_exclude( $exclude_object, $type, $sidebar_data ){
		
		if( isset( $sidebar_data['sbm_exclude_posts_for'] ) && isset( $sidebar_data['sbm_exclude_posts_for'][ $type ] )  && strlen( trim( $sidebar_data['sbm_exclude_posts_for'][ $type ] ) ) ){
			return $sidebar_data['sbm_exclude_posts_for'][ $type ];
		}
		return '';
	}
}

if( !function_exists( 'otw_wp_item_widget_exclude' ) ){
	function otw_wp_item_widget_exclude( $exclude_object, $sidebar, $widget, $type, $widget_settings ){
		
		$list = '';
		
		switch( $exclude_object ){
		
			case 'post':
					if( isset( $widget_settings[ $sidebar ] ) && isset( $widget_settings[ $sidebar ][ $type ] ) && isset( $widget_settings[ $sidebar ][ $type ]['_otw_ep'] ) && is_array( $widget_settings[ $sidebar ][ $type ]['_otw_ep'] ) && isset( $widget_settings[ $sidebar ][ $type ]['_otw_ep'][ $widget ] ) ){
					
						$list = $widget_settings[ $sidebar ][ $type ]['_otw_ep'][ $widget ];
					}
				break;
		}
		return $list;
	}
}
if( !function_exists( 'otw_is_widget_item_excluded' ) ){
	function otw_is_widget_item_excluded( $sidebar_index, $object, $widget, $wp_registered_sidebars ){
	
		$result = false;
		
		if( isset( $wp_registered_sidebars[ $sidebar_index ] ) && isset( $wp_registered_sidebars[ $sidebar_index ]['widgets_settings'] ) && isset( $wp_registered_sidebars[ $sidebar_index ]['widgets_settings'][ $object ] ) ){
			
			if( is_single() ){
			
				if( isset( $wp_registered_sidebars[ $sidebar_index ]['widgets_settings'][ $object ]['_otw_ep'] ) && is_array( $wp_registered_sidebars[ $sidebar_index ]['widgets_settings'][ $object ]['_otw_ep'] ) && isset( $wp_registered_sidebars[ $sidebar_index ]['widgets_settings'][ $object ]['_otw_ep'][ $widget ] ) && $wp_registered_sidebars[ $sidebar_index ]['widgets_settings'][ $object ]['_otw_ep'][ $widget ] ){
					
					global $wp_query;
					
					$query_object = $wp_query->get_queried_object();
					
					$post_id = $query_object->ID;
					
					if( !otw_get_sidebar_from_excluded_items( 'post', $post_id, $wp_registered_sidebars[ $sidebar_index ]['widgets_settings'][ $object ]['_otw_ep'][ $widget ] ) ){
						$result = true;
					}
				}
			}
		
		}
		return $result;
	}
}
?>
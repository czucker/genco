<?php
class OTW_Content_Sidebars extends OTW_Component{
	
	/**
	 * Name of the settings field
	 * 
	 * @var  string 
	 */
	public $settings_name = 'otw_content_sidebars_default_settings';
	
	/**
	 * Name of the meta field
	 * 
	 * @var  string 
	 */
	public $meta_name = 'otw_content_sidebars_settings';
	
	/**
	 *  Numbers
	 *
	 *  @var array
	 */
	private $number_names = array( 'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen', 'twenty', 'twentyone', 'twentytwo', 'twentythree', 'twentyfour');
	
	/** Grid size
	 *
	 *  @var integer
	 */
	private $grid_size = 24;
	
	/**
	 *
	 */
	public $item_types = array();
	
	/**
	 * Show metabox
	 */
	public $show_metabox_for = array();

	
	public function __construct()
	{
		if( is_admin() ){
			add_action( 'admin_menu', array( &$this, 'action_admin_menu' ) );
		}else{
		}
		add_shortcode( 'otw_cs_sidebar', array( &$this, 'show_sidebar' ) );
		add_filter('the_content','otw_pre_content_wrapper', 100000 );
		add_filter('the_content',array( &$this, 'filter_show_content_sidebars' ), 100002 );
		add_filter('the_content','otw_post_content_wrapper', 200001 );
		
		$this->item_types['page'] = array( $this->get_label( 'Pages' ) );
		$this->item_types['post'] = array( $this->get_label( 'Posts' ) );
	}
	
	/**
	 *  Init 
	 */
	public function init(){
		
		if( is_admin() ){
		
			$this->process_admin_actions();
			
			wp_enqueue_script('otw_content_sidebars_admin', $this->component_url.'js/otw-content-sidebars-admin.js?' , array( 'jquery' ), '1.1' );
			wp_enqueue_style( 'otw_content_sidebars_admin', $this->component_url.'css/otw-content-sidebars-admin.css', array(), '1.1' );
			
			global $pagenow, $post;
			
			$register_meta = false;
			
			if( $pagenow == 'post.php' || $pagenow == 'post-new.php'  ){
				$register_meta = true;
			}
			
			if( $register_meta ){
				add_action( 'add_meta_boxes', array( &$this, 'action_meta_boxes' ) );
				add_action( 'save_post', array( &$this, 'action_save_post' ) );
			}
		}else{
			wp_enqueue_style( 'otw_grid_manager', $this->component_url.'css/otw-grid.css', array( ), '1.1' );
		}
	}
	
	/**
	 *  Meta boxes action
	 */
	public function action_meta_boxes(){
		
		$show_meta = true;
		$show_meta_post_type = '';
		$object_post_type = get_post_type();
		
		switch( $object_post_type ){
			
			case 'post':
			case 'page':
					$show_meta_post_type = $object_post_type;
				break;
			default:
					$show_meta_post_type = 'cpt';
				break;
		}
		
		if( $show_meta_post_type ){
		
			if( count( $this->show_metabox_for ) && ( !isset( $this->show_metabox_for[ $show_meta_post_type ] ) || !$this->show_metabox_for[ $show_meta_post_type ] ) ){
				$show_meta = false;
			}
		}
		
		if( array_key_exists( get_post_type(), $this->item_types ) && $show_meta ){
			
			add_meta_box( $this->meta_name, $this->get_label('OTW Content Sidebars'), array( &$this, 'build_meta_box' ), '', 'normal', 'high');
		}
	}
	
	/** 
	 *  Admin menu
	 */
	public function action_admin_menu(){
		add_menu_page( $this->get_label( 'OTW Content Sidebars' ), $this->get_label( 'OTW Content Sidebars' ), 'manage_options', 'otw-content-sidebars', array( &$this, 'content_sidebars_default' ), $this->component_url . '/img/application_side_boxes.png' );
	}
	
	
	/**
	 * Process actions
	 * @access public
	 * @return void
	 */
	public function process_admin_actions(){
		
		
		if( isset( $_POST['otw_cs_action'] ) && ( $_POST['otw_cs_action'] == 'save_default_settings' ) ){
		
			$default_settings = array();
			foreach( $this->item_types as $item_type => $item_data ){
				
				if( isset( $_POST['otw_cs_layout_'.$item_type ] ) ){
					$default_settings[ $item_type ] = array();
					$default_settings[ $item_type ]['layout']   = $_POST['otw_cs_layout_'.$item_type ];
					$default_settings[ $item_type ]['sidebars'] = array();
					
					for( $cS = 1; $cS < 3; $cS++ ){
						if( isset( $_POST['otw_cs_sidebar'.$cS.'_'.$item_type] ) ){
							$default_settings[ $item_type ]['sidebars'][$cS] = array();
							$default_settings[ $item_type ]['sidebars'][$cS]['size'] = $_POST['otw_cs_sidebar'.$cS.'_size_'.$item_type];
							$default_settings[ $item_type ]['sidebars'][$cS]['wp_sidebars'] = array();
							if( isset( $_POST['otw_cs_sidebar'.$cS.'_'.$item_type] ) && trim( $_POST['otw_cs_sidebar'.$cS.'_'.$item_type] ) ){
								$default_settings[ $item_type ]['sidebars'][$cS]['wp_sidebars'][] = $_POST['otw_cs_sidebar'.$cS.'_'.$item_type];
							}
						}
					}
				}
			}
			
			update_option( $this->settings_name, $default_settings );
			wp_redirect( 'admin.php?page=otw-content-sidebars&message=1' );
		}
	}
	
	/**
	 * Display default settings page
	 * @access public
	 * @return void
	 */
	public function content_sidebars_default(){
		
		global $wp_registered_sidebars;
		
		//get saved settings
		$default_settings = get_option( $this->settings_name );
		
		$default_values = array();
		
		foreach( $this->item_types as $item_type => $item_data ){
		
			if( isset( $default_values[ $item_type ] ) ){
				$default_values[ $item_type ] = array();
			}
			
			//layout
			if( isset( $default_settings[ $item_type ] ) && isset( $default_settings[ $item_type ]['layout'] ) && $default_settings[ $item_type ]['layout'] ){
				$default_values[ $item_type ]['layout'] = $default_settings[ $item_type ]['layout'];
			}else{
				$default_values[ $item_type ]['layout'] = '1c';
			}
			
			for( $cS = 1; $cS < 3; $cS++ ){
				//wp sidebars
				if( isset( $default_settings[ $item_type ] ) && isset( $default_settings[ $item_type ]['sidebars'] ) && isset( $default_settings[ $item_type ]['sidebars'][$cS] ) && isset( $default_settings[ $item_type ]['sidebars'][$cS]['wp_sidebars'] ) && isset( $default_settings[ $item_type ]['sidebars'][$cS]['wp_sidebars'][0] ) ){
					$default_values[ $item_type ]['sidebar'.$cS.'_id'] = $default_settings[ $item_type ]['sidebars'][$cS]['wp_sidebars'][0];
				}else{
					$default_values[ $item_type ]['sidebar'.$cS.'_id'] = '';
				}
				
				if( isset( $default_settings[ $item_type ] ) && isset( $default_settings[ $item_type ]['sidebars'] ) && isset( $default_settings[ $item_type ]['sidebars'][$cS] ) && isset( $default_settings[ $item_type ]['sidebars'][$cS]['size'] ) && intval( $default_settings[ $item_type ]['sidebars'][$cS]['size'] ) ){
					$default_values[ $item_type ]['sidebar'.$cS.'_size'] = $default_settings[ $item_type ]['sidebars'][$cS]['size'];
				}else{
					$default_values[ $item_type ]['sidebar'.$cS.'_size'] = 6;
				}
			}
		}
		
		$message = '';
		$massages = array();
		$messages[1] = $this->get_label( 'Default settings saved!' );
		
		if( isset( $_GET['message'] ) && isset( $messages[ $_GET['message'] ] ) ){
			$message .= $messages[ $_GET['message'] ];
		}
		
		$available_sidebars = array( '' => $this->get_label( 'none' ) );
		
		if( is_array( $wp_registered_sidebars ) && count( $wp_registered_sidebars ) ){
			
			foreach( $wp_registered_sidebars as $sidebar_key => $sidebar_data ){
				$available_sidebars[ $sidebar_key ] = $sidebar_data['name'];
			}
		}
		
		$available_sidebar_sizes = array();
		for( $cS = 1; $cS <= $this->grid_size; $cS++ ){
		
			if( $cS == 6 ){
				$available_sidebar_sizes[ $cS ] = $cS.' ('.$this->get_label( 'default' ).')';
			}else{
				$available_sidebar_sizes[ $cS ] = $cS;
			}
		}
		
		include_once( $this->component_path.'views/content_sidebars_default.php' );
	}
	
	/**
	 *  Show meta content
	 */
	public function filter_show_content_sidebars( $post_content ){
		
		global $post;
		
		$item_type = '';
		
		$content_format = '';
		if( $this->is_active_for_object() ){
			
			if( isset( $post->ID ) && $post->ID ){
				$meta_settings = get_post_meta($post->ID, $this->meta_name, TRUE);
				
				if( isset( $meta_settings['configuration'] ) && ( $meta_settings['configuration'] == 'custom' ) ){
				
					$content_format = $meta_settings;
				}
			}
			
			if( !$content_format ){
				
				if( isset( $post->post_type ) ){
					$item_type = $post->post_type;
				}
				
				if( $item_type ){
					
					if( !$content_format ){
						//get saved settings
						$default_settings = get_option( $this->settings_name );
						
						if( isset( $default_settings[ $item_type ] ) ){
							$content_format = $default_settings[ $item_type ];
						}
					}
				}
			}
		}
		
		if( $content_format ){
			
			$formatted_content = '';
			
			switch( $content_format['layout'] ){
				
				case '1c':
						$formatted_content .= $post_content;
					break;
				case '2cl':
						$formatted_content .= '<div class="otw-row">';
						$formatted_content .= '<div class="'.$this->get_column_class( $this->grid_size - $content_format['sidebars'][1]['size'] ).' otw-columns">';
						$formatted_content .= $post_content;
						$formatted_content .= '</div>';
						$formatted_content .= '<div class="'.$this->get_column_class( $content_format['sidebars'][1]['size'] ).' otw-columns otw-primary-sidebar">';
						$formatted_content .= $this->get_sidebars_shortcodes( $content_format['sidebars'][1]['wp_sidebars'] );
						$formatted_content .= '</div>';
						$formatted_content .= '</div>';
					break;
				case '2cr':
						$formatted_content .= '<div class="otw-row">';
						$formatted_content .= '<div class="'.$this->get_column_class( $this->grid_size - $content_format['sidebars'][1]['size'] ).' otw-columns '.$this->get_column_class( $content_format['sidebars'][1]['size'], 'push' ).'">';
						$formatted_content .= $post_content;
						$formatted_content .= '</div>';
						$formatted_content .= '<div class="'.$this->get_column_class( $content_format['sidebars'][1]['size'] ).' otw-columns '.$this->get_column_class( $this->grid_size - $content_format['sidebars'][1]['size'], 'pull' ).' otw-primary-sidebar">';
						$formatted_content .= $this->get_sidebars_shortcodes( $content_format['sidebars'][1]['wp_sidebars'] );
						$formatted_content .= '</div>';
						$formatted_content .= '</div>';
					break;
				case '3cl':
						$formatted_content .= '<div class="otw-row">';
						$formatted_content .= '<div class="'.$this->get_column_class( $this->grid_size - ( $content_format['sidebars'][1]['size'] + $content_format['sidebars'][2]['size'] ) ).' otw-columns">';
						$formatted_content .= $post_content;
						$formatted_content .= '</div>';
						$formatted_content .= '<div class="'.$this->get_column_class( $content_format['sidebars'][1]['size'] ).' otw-columns otw-primary-sidebar">';
						$formatted_content .= $this->get_sidebars_shortcodes( $content_format['sidebars'][1]['wp_sidebars'] );
						$formatted_content .= '</div>';
						$formatted_content .= '<div class="'.$this->get_column_class( $content_format['sidebars'][2]['size'] ).' otw-columns otw-secondary-sidebar">';
						$formatted_content .= $this->get_sidebars_shortcodes( $content_format['sidebars'][2]['wp_sidebars'] );
						$formatted_content .= '</div>';
						$formatted_content .= '</div>';
					break;
				case '3cm':
						$formatted_content .= '<div class="otw-row">';
						$formatted_content .= '<div class="'.$this->get_column_class( $this->grid_size - ( $content_format['sidebars'][1]['size'] + $content_format['sidebars'][2]['size'] ) ).' otw-columns '.$this->get_column_class( $content_format['sidebars'][1]['size'], 'push' ).'">';
						$formatted_content .= $post_content;
						$formatted_content .= '</div>';
						$formatted_content .= '<div class="'.$this->get_column_class( $content_format['sidebars'][1]['size'] ).' otw-columns '.$this->get_column_class( $this->grid_size - ( $content_format['sidebars'][1]['size'] + $content_format['sidebars'][2]['size'] ), 'pull' ).' otw-primary-sidebar">';
						$formatted_content .= $this->get_sidebars_shortcodes( $content_format['sidebars'][1]['wp_sidebars'] );
						$formatted_content .= '</div>';
						$formatted_content .= '<div class="'.$this->get_column_class( $content_format['sidebars'][2]['size'] ).' otw-columns otw-secondary-sidebar">';
						$formatted_content .= $this->get_sidebars_shortcodes( $content_format['sidebars'][2]['wp_sidebars'] );
						$formatted_content .= '</div>';
						$formatted_content .= '</div>';
					break;
				case '3cr':
						$formatted_content .= '<div class="otw-row">';
						$formatted_content .= '<div class="'.$this->get_column_class( $this->grid_size - ( $content_format['sidebars'][1]['size'] + $content_format['sidebars'][2]['size'] ) ).' otw-columns '.$this->get_column_class( $content_format['sidebars'][1]['size'] + $content_format['sidebars'][2]['size'], 'push' ).'">';
						$formatted_content .= $post_content;
						$formatted_content .= '</div>';
						$formatted_content .= '<div class="'.$this->get_column_class( $content_format['sidebars'][1]['size'] ).' otw-columns '.$this->get_column_class( $this->grid_size - ( $content_format['sidebars'][1]['size'] + $content_format['sidebars'][2]['size'] ), 'pull' ).' otw-primary-sidebar">';
						$formatted_content .= $this->get_sidebars_shortcodes( $content_format['sidebars'][1]['wp_sidebars'] );
						$formatted_content .= '</div>';
						$formatted_content .= '<div class="'.$this->get_column_class( $content_format['sidebars'][2]['size'] ).' otw-columns '.$this->get_column_class( $this->grid_size - ( $content_format['sidebars'][1]['size'] + $content_format['sidebars'][2]['size'] ), 'pull' ).' otw-secondary-sidebar">';
						$formatted_content .= $this->get_sidebars_shortcodes( $content_format['sidebars'][2]['wp_sidebars'] );
						$formatted_content .= '</div>';
						$formatted_content .= '</div>';
					break;
			}
			
			return $this->otw_shortcode_remove_wpautop( $formatted_content );
			
		}else{
			return $post_content;
		}
	}
	
	/**
	 * Check if the content sidebars component will change the content of current requested object
	 * 
	 * @return boolean
	 */
	public function is_valid_for_object(){
	
		if( $this->is_active_for_object() ){
			
			global $post;
			
			
			if( isset( $post->ID ) && $post->ID ){
				
				$content_format = '';
				
				$meta_settings = get_post_meta($post->ID, $this->meta_name, TRUE);
				
				if( isset( $meta_settings['configuration'] ) && ( $meta_settings['configuration'] == 'custom' ) ){
					$content_format = $meta_settings;
				}
				
				if( !$content_format ){
					
					if( isset( $post->post_type ) ){
						$item_type = $post->post_type;
					}
					
					if( $item_type ){
						
						if( !$content_format ){
							//get saved settings
							$default_settings = get_option( $this->settings_name );
							
							if( isset( $default_settings[ $item_type ] ) ){
								$content_format = $default_settings[ $item_type ];
							}
						}
					}
				}
				
				if( $content_format && isset( $content_format['layout'] ) && $content_format['layout'] && ( $content_format['layout'] != '1c' ) ){
					return true;
				}
			}
		}
		return false;
	}
	/**
	 * Check if the content sidebars component is active requested object
	 * 
	 * @return boolean
	 */
	public function is_active_for_object(){
		
		$result = false;
		
		if( isset( $GLOBALS['wp_query'] ) ){
			
			if( is_page() && isset( $this->item_types['page'] ) ){
				$result = true;
			}elseif( is_single() && isset( $this->item_types['post'] ) ){
				$result = true;
			}
		}
		
		return $result;
	}
	
	/**
	 * Return otw grid class name
	 * @param interger
	 * @return string
	 */
	private function get_column_class( $size, $type = '' ){
	
		if( array_key_exists( $size, $this->number_names ) ){
			
			switch( $type ){
			
				case 'pull':
				case 'push':
						return 'otw-'.$type.'-'.$this->number_names[ $size ];
					break;
				default:
						return 'otw-'.$this->number_names[ $size ];
					break;
			}
		}
		return '';
	}
	
	/**
	 *  Buld sidebars shortcodes
	 *  @param array
	 *  @return string
	 */
	private function get_sidebars_shortcodes( $sidebars ){
	
		$content = '';
		if( is_array( $sidebars ) && count( $sidebars ) ){
			foreach( $sidebars as $sidebar_key ){
				$content .= '[otw_cs_sidebar sidebar='.$sidebar_key.'][/otw_cs_sidebar]';
			}
		}
		
		return $content;
	}
	
	/**
	 *  Show column sidebars
	 *  @param array
	 *  @return string
	 */
	public function show_sidebar( $sidebar ){
	
		$content = '';
		if( isset( $sidebar['sidebar'] ) && $sidebar['sidebar'] ){
			ob_start();
			echo '<div class="otw-sidebar" id="'.$sidebar['sidebar'].'">';
			dynamic_sidebar( $sidebar['sidebar'] );
			echo '</div>';
			$content = ob_get_contents();
			ob_end_clean();
		}
		return $content;
	}
	
	/**
	 *  Render meta box content
	 */
	public function build_meta_box(){
		
		global $post_id, $wp_registered_sidebars;
		
		$item_type = get_post_type();
		
		//default values
		$default_values[ $item_type ] = array();
		$default_values[ $item_type ]['configuration'] = 'default';
		$default_values[ $item_type ]['layout'] = '1c';
		$default_values[ $item_type ]['sidebar1_id']   = '';
		$default_values[ $item_type ]['sidebar1_size'] = 6;
		$default_values[ $item_type ]['sidebar2_id']   = '';
		$default_values[ $item_type ]['sidebar2_size'] = 6;
		
		//load values from meta data
		$meta_settings = get_post_meta($post_id, $this->meta_name, TRUE);
		
		if( $meta_settings && isset( $meta_settings['configuration'] ) ){
			$default_values[ $item_type ]['configuration'] = $meta_settings['configuration'];
			$default_values[ $item_type ]['layout'] = $meta_settings['layout'];
			
			for( $cS = 1; $cS < 3; $cS++ ){
			
				if( isset( $meta_settings['sidebars'] ) && isset( $meta_settings['sidebars'][$cS] ) && isset( $meta_settings['sidebars'][$cS]['wp_sidebars'] ) && isset( $meta_settings['sidebars'][$cS]['wp_sidebars'][0] ) ){
					$default_values[ $item_type ]['sidebar'.$cS.'_id'] = $meta_settings['sidebars'][$cS]['wp_sidebars'][0];
				}
				
				if( isset( $meta_settings['sidebars'] ) && isset( $meta_settings['sidebars'][$cS] ) && isset( $meta_settings['sidebars'][$cS]['size'] ) && intval( $meta_settings['sidebars'][$cS]['size'] ) ){
					$default_values[ $item_type ]['sidebar'.$cS.'_size'] = $meta_settings['sidebars'][$cS]['size'];
				}
			}
		}else{
			//load settings from default settings
			$default_settings = get_option( $this->settings_name );
			
			if( is_array( $default_settings ) && array_key_exists( $item_type, $default_settings ) ){
				
				//layout
				if( isset( $default_settings[ $item_type ] ) && isset( $default_settings[ $item_type ]['layout'] ) && $default_settings[ $item_type ]['layout'] ){
					$default_values[ $item_type ]['layout'] = $default_settings[ $item_type ]['layout'];
				}
				
				for( $cS = 1; $cS < 3; $cS++ ){
					//wp sidebars
					if( isset( $default_settings[ $item_type ] ) && isset( $default_settings[ $item_type ]['sidebars'] ) && isset( $default_settings[ $item_type ]['sidebars'][$cS] ) && isset( $default_settings[ $item_type ]['sidebars'][$cS]['wp_sidebars'] ) && isset( $default_settings[ $item_type ]['sidebars'][$cS]['wp_sidebars'][0] ) ){
						$default_values[ $item_type ]['sidebar'.$cS.'_id'] = $default_settings[ $item_type ]['sidebars'][$cS]['wp_sidebars'][0];
					}
					
					if( isset( $default_settings[ $item_type ] ) && isset( $default_settings[ $item_type ]['sidebars'] ) && isset( $default_settings[ $item_type ]['sidebars'][$cS] ) && isset( $default_settings[ $item_type ]['sidebars'][$cS]['size'] ) && intval( $default_settings[ $item_type ]['sidebars'][$cS]['size'] ) ){
						$default_values[ $item_type ]['sidebar'.$cS.'_size'] = $default_settings[ $item_type ]['sidebars'][$cS]['size'];
					}
				}
			}
		}
		
		$available_sidebars = array( '' => $this->get_label( 'none' ) );
		
		if( is_array( $wp_registered_sidebars ) && count( $wp_registered_sidebars ) ){
			
			foreach( $wp_registered_sidebars as $sidebar_key => $sidebar_data ){
				$available_sidebars[ $sidebar_key ] = $sidebar_data['name'];
			}
		}
		
		$available_sidebar_sizes = array();
		for( $cS = 1; $cS <= $this->grid_size; $cS++ ){
		
			if( $cS == 6 ){
				$available_sidebar_sizes[ $cS ] = $cS.' ('.$this->get_label( 'default' ).')';
			}else{
				$available_sidebar_sizes[ $cS ] = $cS;
			}
		}

		
		$meta_noncename = wp_create_nonce(__FILE__);
		
		$configuration_options = array( 'default' => $this->get_label( 'Default' ), 'custom' => $this->get_label( 'Custom' ) );
		
		include_once( $this->component_path.'views/content_sidebars_metabox.php' );
	}
	
	/**
	 *  Save post
	 */
	public function action_save_post( $post_id ){
		
		if ( !isset( $_POST[ $this->meta_name.'_noncename' ] ) || !wp_verify_nonce( $_POST[$this->meta_name.'_noncename' ],__FILE__) ){
			return $post_id;
		}
		
		// validate user can edit
		if($_POST['post_type'] == 'page'){
			if (!current_user_can('edit_page', $post_id)){
				return $post_id;
			}
		}else{
			if (!current_user_can('edit_post', $post_id)){
				return $post_id;
			}
		}
		
		if( isset( $_POST[ 'otw_cs_use_configuration' ] ) ){
			
			$item_type = get_post_type();
			
			$settings = array();
			$settings['configuration'] = $_POST[ 'otw_cs_use_configuration' ];
			$settings['layout']   = $_POST['otw_cs_layout_'.$item_type ];
			$settings['sidebars'] = array();
			for( $cS = 1; $cS < 3; $cS++ ){
				$settings['sidebars'][$cS] = array();
				$settings['sidebars'][$cS]['size'] = $_POST['otw_cs_sidebar'.$cS.'_size_'.$item_type];
				$settings['sidebars'][$cS]['wp_sidebars'] = array();
				if( isset( $_POST['otw_cs_sidebar'.$cS.'_'.$item_type] ) && trim( $_POST['otw_cs_sidebar'.$cS.'_'.$item_type] ) ){
					$settings['sidebars'][$cS]['wp_sidebars'][] = $_POST['otw_cs_sidebar'.$cS.'_'.$item_type];
				}
			}
			update_post_meta($post_id,$this->meta_name,$settings);
		}
		
		return $post_id;
	}
}
?>
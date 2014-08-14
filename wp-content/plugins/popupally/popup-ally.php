<?php
/*
 Plugin Name: PopupAlly
 Plugin URI: http://ambitionally.com/popupally/
 Description: Want to increase your subscriber base? Exit-intent popups allow you to capture lost visitors and have been shown to increase conversion by over 300%. PopupAlly allows you to create advanced popup signup forms in under 5 minutes, even if you don't know code. PopupAlly's visual editor allows you to customize the look-and-feel of your popups with an instant preview, saving you lots of time.
 Version: 1.3.5
 Author: Nathalie Lussier Media Inc.
 Author URI: http://nathalielussier.com/
 */


if (!class_exists('PopupAlly')) {
	class PopupAlly {
		/// CONSTANTS
		const VERSION = '1.3.5';

		const SETTING_KEY_DISPLAY = '_popupally_setting_general';
		const SETTING_KEY_STYLE = '_popupally_setting_style';
		const SETTING_KEY_ADVANCED = '_popupally_setting_advanced';
		const SETTING_KEY_NUM_STYLE_SAVED = '_popupally_setting_num_style_saved';

		const HELP_URL = 'http://ambitionally.com/popupally/tutorials/';
		const POPUPALLY_PRO_URL = 'http://ambitionally.com/popupally-pro?utm_source=freeplugin&utm_medium=banner&utm_content=sidebar&utm_campaign=popupallypro';

		const SCRIPT_FOLDER = 'popupally-scripts';

		// CACHE
		const CACHE_PERIOD = 86400;

		const TEMPLATE_DIRECTORY = 'template';

		public static $available_templates = array();
		
		private static $default_popup_display_settings = null;
		private static $default_popup_style_simple_settings = null;
		private static $default_display_settings = null;
		private static $default_style_settings = null;
		private static $default_advanced_settings = null;

		// used for parameter parsing
		private static $config_display_settings = array('cookie-duration');
		private static $config_style_settings = array('popup-selector', 'popup-class', 'cookie-name', 'close-trigger');

		public static function init() {
			self::add_actions();
			self::load_templates();
			self::initialize_defaults();

			register_activation_hook(__FILE__, array(__CLASS__, 'do_activation_actions'));
			register_deactivation_hook(__FILE__, array(__CLASS__, 'do_deactivation_actions'));
		}

		public static function do_activation_actions() {
			delete_transient(self::SETTING_KEY_DISPLAY);
			delete_transient(self::SETTING_KEY_STYLE);
			delete_transient(self::SETTING_KEY_ADVANCED);
			delete_transient(self::SETTING_KEY_NUM_STYLE_SAVED);
			if (add_option(self::SETTING_KEY_DISPLAY, self::$default_display_settings)) {
				set_transient(self::SETTING_KEY_DISPLAY, self::$default_display_settings, self::CACHE_PERIOD);
			}
			if (add_option(self::SETTING_KEY_STYLE, self::$default_style_settings)) {
				set_transient(self::SETTING_KEY_STYLE, self::$default_style_settings, self::CACHE_PERIOD);
			}
			if (add_option(self::SETTING_KEY_ADVANCED, self::$default_advanced_settings)) {
				set_transient(self::SETTING_KEY_ADVANCED, self::$default_advanced_settings, self::CACHE_PERIOD);
			}
			if (add_option(self::SETTING_KEY_NUM_STYLE_SAVED, 0)) {
				set_transient(self::SETTING_KEY_NUM_STYLE_SAVED, 0, self::CACHE_PERIOD);
			}
		}

		public static function do_deactivation_actions() {
			delete_transient(self::SETTING_KEY_DISPLAY);
			delete_transient(self::SETTING_KEY_STYLE);
			delete_transient(self::SETTING_KEY_ADVANCED);
			delete_transient(self::SETTING_KEY_NUM_STYLE_SAVED);
		}

		private static function add_actions() {
			if (is_admin()) {
				add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_administrative_resources'));

				// add thank you page setting
				add_action( 'add_meta_boxes', array(__CLASS__, 'add_meta_box'));

				// add setting menu
				add_action('admin_menu', array(__CLASS__, 'add_menu_pages'));
				add_action('admin_init', array(__CLASS__, 'register_settings'));
			}

			add_action('init', array(__CLASS__, 'add_filters'));
			add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue_resources'));
			add_action('wp_head', array(__CLASS__, 'add_popup_scripts'));
			add_action('wp_footer', array(__CLASS__, 'add_popup_html'));
		}

		public static function add_filters() {
			add_filter('the_content', array(__CLASS__, 'add_form_to_content'));
		}

		private static function initialize_defaults() {
			self::$default_popup_display_settings = array('timed' => 'false',
				'timed-popup-delay' => -1,
				'enable-exit-intent-popup' => 'false',
				'enable-embedded' => 'false',
				'embedded-location' => 'none',
				'show-all' => 'false',
				'include' => array(),
				'exclude' => array(),
				'cookie-duration' => 14,
				'thank-you' => array());
			self::$default_popup_style_simple_settings = array('name' => 'Popup {{num}}',
				'signup-form' => '',
				'sign-up-form-action' => '',
				'sign-up-form-name-field' => '',
				'sign-up-form-email-field' => '',
				'selected-template' => 'bxsjbi',
				'popup-selector' => '#popup-box-sxzw-{{num}}',
				'popup-class' => 'popupally-opened-sxzw-{{num}}',
				'cookie-name' => 'popupally-cookie-{{num}}',
				'close-trigger' => '.popup-click-close-trigger-{{num}}');
				foreach (self::$available_templates as $template) {
					self::$default_popup_style_simple_settings = array_merge(self::$default_popup_style_simple_settings, $template->default_values);
				}
			self::$default_display_settings = array(1 => self::$default_popup_display_settings, 2 => self::$default_popup_display_settings);
			self::$default_style_settings = array(1 => self::customize_parameter_array(self::$default_popup_style_simple_settings, 1),
				2 => self::customize_parameter_array(self::$default_popup_style_simple_settings, 2));
			self::$default_advanced_settings = array('no-inline' => 'false', 'max-page' => '500', 'max-post' => '500');
		}
		
		public static function register_settings() {
			register_setting('popupally_display_settings', self::SETTING_KEY_DISPLAY, array(__CLASS__, 'sanitize_display_settings'));
			register_setting('popupally_style_settings', self::SETTING_KEY_STYLE, array(__CLASS__, 'sanitize_style_settings'));
			register_setting('popupally_advanced_settings', self::SETTING_KEY_ADVANCED, array(__CLASS__, 'sanitize_advanced_settings'));
		}

		public static function enqueue_resources() {
			wp_enqueue_script('jquery');

			$advanced = self::get_advanced_settings();
			if ('true' === $advanced['no-inline']) {
				$num_saved = self::get_num_style_saved_settings();
				$to_show = self::get_popup_to_show();
				if (!empty($to_show)) {
					wp_enqueue_script('popupally-action-script', plugin_dir_url(__FILE__) . 'resource/frontend/popup.min.js', false, self::VERSION);
					wp_enqueue_style('popupally-style', content_url(self::SCRIPT_FOLDER) . '/popupally-style.css', false, self::VERSION . '.' . $num_saved);
				}
				$ids = self::get_popup_thank_you();
				if (!empty($ids)){
					foreach($ids as $id) {
						wp_enqueue_script('popupally-thank-you-script-' . $id, content_url(self::SCRIPT_FOLDER) . '/popupally-thank-you-' . $id . '.js', false, self::VERSION . '.' . $num_saved);
					}
				}
			}
		}

		public static function enqueue_administrative_resources($hook) {
			if (strpos($hook, '_popupally_setting_') !== false) {
				wp_enqueue_style('wp-color-picker');
				wp_enqueue_style('popupally-backend', plugin_dir_url(__FILE__) . 'resource/backend/popupally.css', false, self::VERSION);
				foreach(self::$available_templates as $template_uid => $template_obj) {
					wp_enqueue_style('popupally-backend-preview-' . $template_uid, $template_obj->backend_css, false, self::VERSION);
				}

				wp_enqueue_script( 'wp-color-picker' );
				wp_enqueue_script('popupally-backend', plugin_dir_url(__FILE__) . 'resource/backend/popupally.js', array('jquery', 'wp-color-picker'), self::VERSION);
				wp_enqueue_script('popupally-backend-preview', plugin_dir_url(__FILE__) . 'resource/backend/popup-simple-preview.js', array('jquery'), self::VERSION);
				wp_localize_script( 'popupally-backend', 'data_object',
					array( 'setting_variable' => self::SETTING_KEY_STYLE));
			}
		}

		// <editor-fold defaultstate="collapsed" desc="Templates">
		public static function add_template($template) {
			self::$available_templates[$template->uid] = $template;
		}

		public static function compare_template_order($a, $b)
		{
			if ($a->template_order == $b->template_order) {
				return 0;
			}
			return ($a->template_order < $b->template_order) ? -1 : 1;
		}

		private static function load_templates() {
			$folders = scandir(dirname(__FILE__) . '/resource/' .self::TEMPLATE_DIRECTORY);
			foreach ($folders as $folder) {
				if ('.' !== $folder && '..' !== $folder ) {
					include_once(dirname(__FILE__) . '/resource/' . self::TEMPLATE_DIRECTORY . '/' . $folder . '/definition.php');
				}
			}
			uasort(self::$available_templates, array(__CLASS__, 'compare_template_order'));
		}
		// </editor-fold>

		// <editor-fold defaultstate="collapsed" desc="Embedded sign up forms">
		public static function add_form_to_content($content) {
			if (!is_singular()) {
				return $content;
			}
			$to_show = self::get_popup_to_show();
			if (!empty($to_show)) {
				$display = self::get_display_settings();
				$style = self::get_style_settings();
				foreach($to_show as $id => $popup_types) {
					if (in_array('embedded', $popup_types)) {
						if ('post-start' === $display[$id]['embedded-location']) {
							$content = self::generate_popup_html($id, $style[$id], true) . $content;
						} elseif ('post-end' === $display[$id]['embedded-location']) {
							$content = $content . self::generate_popup_html($id, $style[$id], true);
						}
					}
				}
			}
			return $content;
		}
		// </editor-fold>

		// <editor-fold defaultstate="collapsed" desc="Page meta box">
		public static function add_meta_box($post_type) {
			$post_types = array('post', 'page');     //limit meta box to certain post types
			if ( in_array( $post_type, $post_types )) {
				add_meta_box(
					'popupally-display-settings',
					 'PopupAlly Display Settings',
					array( __CLASS__, 'show_post_display_meta_box_content' ),
					$post_type,
					'side',
					'high'
				);
			}
		}

		public static function show_post_display_meta_box_content($post) {
			$to_show = self::get_popup_to_show($post->ID);
			$style = self::get_style_settings();

			include (dirname(__FILE__) . '/resource/backend/post-display.php');
		}
		// </editor-fold>

		// <editor-fold defaultstate="collapsed" desc="Settings">
		public static function add_menu_pages() {
			// Add the top-level admin menu
			$capability = 'manage_options';
			$results = add_menu_page('PopupAlly Settings', 'PopupAlly', $capability, self::SETTING_KEY_DISPLAY, array(__CLASS__, 'show_display_settings'));

			$results = add_submenu_page(self::SETTING_KEY_DISPLAY, 'Display Settings', 'Display Settings', $capability, self::SETTING_KEY_DISPLAY, array(__CLASS__,  'show_display_settings'));
			$results = add_submenu_page(self::SETTING_KEY_DISPLAY, 'Style Settings', 'Style Settings', $capability, self::SETTING_KEY_STYLE, array(__CLASS__, 'show_style_settings'));
			$results = add_submenu_page(self::SETTING_KEY_DISPLAY, 'Advanced Settings', 'Advanced Settings', $capability, self::SETTING_KEY_ADVANCED, array(__CLASS__, 'show_advanced_settings'));
		}
		
		public static function show_display_settings() {
			if (!current_user_can('manage_options')) {
				wp_die('You do not have sufficient permissions to access this page.');
			}
			self::check_php_version('popupally_display');
			$display = self::get_display_settings();
			$style = self::get_style_settings();
			$plugin_dir = plugin_dir_url(__FILE__);
			$disable = file_get_contents(dirname(__FILE__) . '/resource/frontend/disable.php');

			$advanced = self::get_advanced_settings();
			if ($advanced['max-page'] < 0) {
				$pages = get_pages();
			} else {
				$pages = get_pages(array('number' => $advanced['max-page']));
			}
			$posts = get_posts(array('posts_per_page' => $advanced['max-post']));
			$categories = get_categories(array('hide_empty' => false));
			include (dirname(__FILE__) . '/resource/backend/setting-display.php');
		}
		
		public static function show_style_settings() {
			if (!current_user_can('manage_options')) {
				wp_die('You do not have sufficient permissions to access this page.');
			}
			self::check_php_version('popupally_style');
			$style = self::get_style_settings();
			$setting_variable = PopupAlly::SETTING_KEY_STYLE;
			include (dirname(__FILE__) . '/resource/backend/setting-style-simple.php');
		}
		
		public static function show_advanced_settings() {
			if (!current_user_can('manage_options')) {
				wp_die('You do not have sufficient permissions to access this page.');
			}
			self::check_php_version('popupally_advanced');
			$plugin_dir = plugin_dir_url(__FILE__);
			$advanced = self::get_advanced_settings();
			include (dirname(__FILE__) . '/resource/backend/setting-advanced.php');
		}

		public static function sanitize_display_settings($input) {
			add_settings_error('popupally_display', 'settings_updated', 'Settings saved!', 'updated');
			foreach ($input as $id => &$setting) {
				if (is_int($id)) {
					$setting = wp_parse_args($setting, self::$default_popup_display_settings);
					$setting['timed-popup-delay'] = intval($setting['timed-popup-delay']);
					$setting['cookie-duration'] = intval($setting['cookie-duration']);
				}
			}
			set_transient(self::SETTING_KEY_DISPLAY, $input, self::CACHE_PERIOD);
			return $input;
		}

		public static function sanitize_style_settings($input) {
			add_settings_error('popupally_style', 'settings_updated', 'Settings saved!', 'updated');

			foreach ($input as $id => &$setting) {
				if (is_int($id)) {
					foreach(self::$available_templates as $template_ob) {
						$setting = $template_ob->sanitize_style($setting, $id);
					}
					$setting = wp_parse_args($setting, self::customize_parameter_array(self::$default_popup_style_simple_settings, $id));
				}
			}
			self::increment_num_style_saved($input);
			set_transient(self::SETTING_KEY_STYLE, $input, self::CACHE_PERIOD);
			return $input;
		}

		public static function sanitize_advanced_settings($input) {
			add_settings_error('popupally_advanced', 'settings_updated', 'Settings saved!', 'updated');

			$input = wp_parse_args($input, self::$default_advanced_settings);
			if ('true' === $input['no-inline']) {
				self::generate_script_files();
			}
			set_transient(self::SETTING_KEY_ADVANCED, $input, self::CACHE_PERIOD);
			return $input;
		}

		private static function increment_num_style_saved($style) {			
			$num_saved = self::get_num_style_saved_settings();
			$num_saved += 1;
			update_option(self::SETTING_KEY_NUM_STYLE_SAVED, $num_saved);
			set_transient(self::SETTING_KEY_NUM_STYLE_SAVED, $num_saved, self::CACHE_PERIOD);
			
			$advanced = self::get_advanced_settings();
			if ('true' === $advanced['no-inline']) {
				self::generate_script_files($style);
			}
		}

		private static function generate_script_files($style = false) {
			if (false === ($creds = request_filesystem_credentials('admin.php', '', false, false, null))) {
				return true;
			}
			if (!WP_Filesystem($creds)) {
				echo 'Cannot initiate WP_Filesystem. Please make sure you have the proper permission on the WordPress Install';
				return true;
			}
			global $wp_filesystem;
			$target_dir = trailingslashit($wp_filesystem->wp_content_dir());
			$target_dir = trailingslashit($target_dir . self::SCRIPT_FOLDER);

			$wp_filesystem->mkdir($target_dir);

			if (false === $style) {
				$style = self::get_style_settings();
			}
			foreach($style as $id => $setting){
				$css .= self::generate_popup_css($id, $setting);

				$style = self::get_style_settings();
				$thank_you = 'var exdate = new Date();exdate.setFullYear(exdate.getFullYear() + 1);';
				$thank_you .= 'document.cookie = "' . $setting['cookie-name'] . '=1; path=/; expires="+ exdate.toGMTString();';
				$wp_filesystem->put_contents($target_dir . 'popupally-thank-you-' . $id . '.js', $thank_you, FS_CHMOD_FILE);
			}
			$wp_filesystem->put_contents($target_dir . 'popupally-style.css', $css, FS_CHMOD_FILE);
		}
		// </editor-fold>

		// <editor-fold defaultstate="collapsed" desc="Front end">
		public static function add_popup_scripts() {
			$advanced = self::get_advanced_settings();
			if ('true' === $advanced['no-inline']) {
				return;
			}
			$to_show = self::get_popup_to_show();
			if (!empty($to_show)) {
				echo '<script type="text/javascript">';
				readfile(dirname(__FILE__) . '/resource/frontend/popup.min.js');
				echo '</script>';
				$style = self::get_style_settings();
				foreach($to_show as $id => $value){
					echo '<style type="text/css">';
					echo self::generate_popup_css($id, $style[$id]);
					echo '</style>';
				}
			}
			$ids = self::get_popup_thank_you();
			if (!empty($ids)){
				$style = self::get_style_settings();
				echo '<script type="text/javascript">var exdate = new Date();exdate.setFullYear(exdate.getFullYear() + 1);';
				foreach($ids as $id) {
					echo 'document.cookie = "' . $style[$id]['cookie-name'] . '=1; path=/; expires="+ exdate.toGMTString();';
				}
				echo '</script>';
			}
		}

		public static function add_popup_html() {
			$to_show = self::get_popup_to_show();
			if (!empty($to_show)) {
				$display = self::get_display_settings();
				$style = self::get_style_settings();
				foreach($to_show as $id => $popup_types) {
					$param = array();
					foreach($popup_types as $type) {
						switch($type) {
							case 'timed':
								$param['timed-popup-delay'] = $display[$id]['timed-popup-delay'];
								break;
							case 'exit-intent':
								$param['enable-exit-intent-popup'] = $display[$id]['enable-exit-intent-popup'];
								break;
						}
					}
					self::construct_html_parameter_string($display[$id], self::$config_display_settings, $param);
					self::construct_html_parameter_string($style[$id], self::$config_style_settings, $param);
					echo '<div class="popupally-configuration" style="display:none;">' . json_encode(self::replace_json_safe_string($param)) . '</div>';
					echo self::generate_popup_html($id, $style[$id]);
					if (in_array('embedded', $popup_types) && 'page-end' === $display[$id]['embedded-location']) {
						echo self::generate_popup_html($id, $style[$id], true);
					}
				}
			}
		}

		private static function generate_popup_html($id, $setting, $embedded = false) {
			if (isset(self::$available_templates[$setting['selected-template']])) {
				$template_obj = &self::$available_templates[$setting['selected-template']];
			} else {
				$template_obj = &self::$available_templates['bxsjbi'];
			}
			$setting = $template_obj->prepare_for_code_generation($setting);
			$template = self::get_simple_popup_html_template($template_obj, $embedded);
			$template = str_replace('{{num}}', $id, $template);
			foreach ($template_obj->html_mapping as $replace) {
				$template = str_replace('{{' . $replace . '}}', esc_attr($setting[$replace]), $template);
			}
			foreach ($template_obj->no_escape_html_mapping as $replace) {
				$template = str_replace('{{' . $replace . '}}', $setting[$replace], $template);
			}
			// generate hidden fields
			$hidden_fields = '';
			if (isset($setting['hidden-form-fields-name'])) {
				foreach ($setting['hidden-form-fields-name'] as $field_id => $name) {
					$hidden_fields .= '<input type="hidden" name="' . $name . '" value="' . esc_attr($setting['hidden-form-fields-value'][$field_id]) . '"/>';
				}
			}
			if (isset($setting['other-form-fields-name'])) {
				foreach ($setting['other-form-fields-name'] as $field_id => $name) {
					if ($name === $setting['sign-up-form-name-field'] || $name === $setting['sign-up-form-email-field']) {
						continue;
					}
					$hidden_fields .= '<input type="hidden" name="' . $name . '" value="' . esc_attr($setting['other-form-fields-value'][$field_id]) . '"/>';
				}
			}
			$template = str_replace('{{hidden-fields}}', $hidden_fields, $template);
			return $template;
		}

		private static function generate_popup_css($id, $setting) {
			if (isset(self::$available_templates[$setting['selected-template']])) {
				$template_obj = &self::$available_templates[$setting['selected-template']];
			} else {
				$template_obj = &self::$available_templates['bxsjbi'];
			}
			$setting = $template_obj->prepare_for_code_generation($setting);
			$template = self::get_simple_popup_css_template($template_obj);
			$template = str_replace('{{num}}', $id, $template);
			foreach ($template_obj->css_mapping as $replace) {
				$template = str_replace('{{' . $replace . '}}', $setting[$replace], $template);
			}
			$plugin_uri = plugins_url( '' , __FILE__);
			$template = str_replace('{{plugin_uri}}', $plugin_uri, $template);
			return $template;
		}

		public static function get_popup_thank_you($post_id = false) {
			if ($post_id === false) {
				global $wp_query;
				if (isset($wp_query) && isset($wp_query->post)) {
					$post_id = $wp_query->post->ID;
				} else {
					return array();
				}
			}
			$cookies = array();
			$display = self::get_display_settings();
			foreach ($display as $id => $settings) {
				if ((isset($settings['timed']) && 'true' === $settings['timed']) || (isset($settings['enable-exit-intent-popup']) && 'true' === $settings['enable-exit-intent-popup'])) {
					if (isset($settings['thank-you'][$post_id])) {
						$cookies []= $id;
					}
				}
			}
			return $cookies;
		}

		public static function get_popup_to_show($post_id = false) {
			$is_front_page = false;
			$category_id = -1;
			if ($post_id === false) {
				global $wp_query;
				if (!isset($wp_query)) {
					return array();
				}
				if ($wp_query->is_home) {
					$is_front_page = true;
					$post_type = 'page';
				} elseif ($wp_query->is_category) {
					$category_id = $wp_query->queried_object_id;
					$post_type = 'page';
				} elseif (isset($wp_query->post)) {
					$post_id = $wp_query->post->ID;
					$post_type = $wp_query->post->post_type;
				} else {
					return array();
				}
			} else {
				$post = get_post($post_id);
				if (null === $post) {
					return array();
				}
				$post_type = $post->post_type;
			}
			$timed = 0;
			$exit_intent = 0;
			$result = array();
			$display = self::get_display_settings();
			foreach ($display as $id => $settings) {
				if (false !== $post_id && isset($settings['thank-you'][$post_id])) {
					continue;
				}
				$to_show = false;
				if (isset($settings['show-all']) && 'true' === $settings['show-all']) {	// exclude path
					if (isset($settings['exclude']['all-pages']) && 'page' === $post_type) {
						continue;
					}
					if (isset($settings['exclude']['all-posts']) && 'post' === $post_type) {
						continue;
					}
					if (false !== $post_id && !isset($settings['exclude'][$post_id])) {
						$to_show = true;
					} elseif ($is_front_page && !isset($settings['exclude']['front-page'])) {
						$to_show = true;
					} elseif ($category_id >= 0 && !isset($settings['exclude']['category-' . $category_id])) {
						$to_show = true;
					}
				} else {	// include path
					if (isset($settings['include']['all-pages']) && 'page' === $post_type) {
						$to_show = true;
					} elseif (isset($settings['include']['all-posts']) && 'post' === $post_type) {
						$to_show = true;
					} elseif (false !== $post_id && isset($settings['include'][$post_id])) {
						$to_show = true;
					} elseif ($is_front_page && isset($settings['include']['front-page'])) {
						$to_show = true;
					} elseif ($category_id >= 0 && isset($settings['include']['category-' . $category_id])) {
						$to_show = true;
					}
				}
				if (!$to_show) {
					continue;
				}
				$row = array();
				if ($timed <= 0 && 'true' === $settings['timed']) {
					$timed = $id;
					$row []= 'timed';
				}
				if ($exit_intent <= 0 && 'true' === $settings['enable-exit-intent-popup']) {
					$exit_intent = $id;
					$row []= 'exit-intent';
				}
				if ('true' === $settings['enable-embedded']) {
					$row []= 'embedded';
				}
				if (!empty($row)) {
					$result[$id] = $row;
				}
			}
			return $result;
		}
		// </editor-fold>

		// <editor-fold defaultstate="collapsed" desc="Utlities">
		private static function replace_json_safe_string($param) {
			foreach ($param as $key => $value) {
				if (is_string($value)) {
					$value = str_replace('&quot;', '"', $value);
					$value = str_replace('&#039;', "'", $value);
					$value = str_replace('&lt;', '<', $value);
					$value = str_replace('&gt;', '>', $value);
					$value = str_replace('&amp;', '&', $value);
					$param[$key] = $value;
				}
			}
			return $param;
		}

		public static function get_display_settings() {
			$display = get_transient(self::SETTING_KEY_DISPLAY);

			if (!is_array($display)) {
				$display = get_option(self::SETTING_KEY_DISPLAY, self::$default_display_settings);

				set_transient(self::SETTING_KEY_DISPLAY, $display, self::CACHE_PERIOD);
			}
			foreach($display as $id => $setting) {
				$display[$id] = wp_parse_args($display[$id], self::$default_popup_display_settings);

				// ensure backwards compatibility by converting all arrays to new ones
				$display[$id]['include'] = self::convert_array_list($display[$id]['include']);
				$display[$id]['exclude'] = self::convert_array_list($display[$id]['exclude']);
				$display[$id]['thank-you'] = self::convert_array_list($display[$id]['thank-you']);
			}

			return $display;
		}

		private static function convert_array_list($list) {
			if (!is_array($list)) {
				return array();
			}
			if (empty($list) || reset($list) === 'true') {
				return $list;
			}
			$result = array();
			foreach($list as $id) {
				$result[$id] = 'true';
			}
			return $result;
		}

		public static function get_style_settings() {
			$style = get_transient(self::SETTING_KEY_STYLE);

			if (!is_array($style)) {
				$style = get_option(self::SETTING_KEY_STYLE, self::$default_style_settings);

				set_transient(self::SETTING_KEY_STYLE, $style, self::CACHE_PERIOD);
			}
			// update old setting to new ones
			foreach($style as $id => $setting) {
				if (isset($style[$id]['popup-selector'])) {
					unset($style[$id]['popup-selector']);
					unset($style[$id]['popup-class']);
					unset($style[$id]['close-trigger']);
					unset($style[$id]['cookie-name']);
				}
				$style[$id] = wp_parse_args($style[$id], self::customize_parameter_array(self::$default_popup_style_simple_settings, $id));
			}
			return $style;
		}

		public static function get_advanced_settings() {
			$advanced = get_transient(self::SETTING_KEY_ADVANCED);

			if (!is_array($advanced)) {
				$advanced = get_option(self::SETTING_KEY_ADVANCED, self::$default_advanced_settings);

				set_transient(self::SETTING_KEY_ADVANCED, $advanced, self::CACHE_PERIOD);
			}
			$advanced = wp_parse_args($advanced, self::$default_advanced_settings);
			return $advanced;
		}

		public static function get_num_style_saved_settings() {
			$num = get_transient(self::SETTING_KEY_NUM_STYLE_SAVED);

			if (false === $num) {
				$num = get_option(self::SETTING_KEY_NUM_STYLE_SAVED, 0);

				set_transient(self::SETTING_KEY_NUM_STYLE_SAVED, $num, self::CACHE_PERIOD);
			}
			return $num;
		}

		private static function get_simple_popup_html_template($template_obj, $embedded = false) {
			if ($embedded) {
				if (null === $template_obj->popup_embedded_template) {
					$template_obj->popup_embedded_template = file_get_contents($template_obj->frontend_embedded_php);
				}
				return $template_obj->popup_embedded_template;
			}
			if (null === $template_obj->popup_html_template) {
				$template_obj->popup_html_template = file_get_contents($template_obj->frontend_php);
			}
			return $template_obj->popup_html_template;
		}

		private static function get_simple_popup_css_template($template_obj) {
			if (null === $template_obj->popup_css_template) {
				$template_obj->popup_css_template = file_get_contents($template_obj->frontend_css);
			}
			return $template_obj->popup_css_template;
		}

		private static function construct_html_parameter_string($source, $tags, &$target) {
			foreach ($tags as $tag) {
				if (isset($source[$tag])) {
					$target[$tag] = $source[$tag];
				} else {
					$target[$tag] = '';
				}
			}
		}

		private static function customize_parameter_array($source, $num) {
			$result = array();
			foreach ($source as $tag => $value) {
				$result[$tag] = str_replace('{{num}}', $num, $value);
			}
			return $result;
		}

		private static function check_php_version($setting = false) {
			if (!defined('PHP_VERSION_ID')) {
				$version = explode('.', PHP_VERSION);
				define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
			}
			if (PHP_VERSION_ID < 50300) {
				$message = 'The server is currently running PHP Version ' . PHP_VERSION . '. PopupAlly needs at least PHP 5.3 to function properly. Please ask your host to upgrade.';
				if (false !== $setting) {
					add_settings_error($setting, 'php_version_error', $message, 'error');
				} else {
					return $message;
				}
			}
			return false;
		}
		// </editor-fold>
	}
	require_once(plugin_dir_path(__FILE__) . '/resource/popup-ally-template.php');
	PopupAlly::init();
}

<?php
if (!class_exists('PopupAllyDefaultTemplate')) {
	class PopupAllyDefaultTemplate extends PopupAllyTemplate {
		public function __construct() {
			$this->uid = 'bxsjbi';
			$this->template_name = 'Tried-and-true';
			$this->template_order = 0;

			$this->backend_css = plugin_dir_url(__FILE__) . '/backend/preview.css';
			$this->backend_php = dirname(__FILE__) . '/backend/preview.php';
			$this->frontend_css = dirname(__FILE__) . '/frontend/popup.css';
			$this->frontend_php = dirname(__FILE__) . '/frontend/popup.php';
			$this->frontend_embedded_php = dirname(__FILE__) . '/frontend/embedded.php';

			$this->css_mapping = array('background-color', 'text-color',
				'subscribe-button-color', 'subscribe-button-text-color',
				'display-headline', 'display-logo-row', 'display-logo-img', 'display-privacy');
			$this->html_mapping = array('image-url',
				'subscribe-button-text', 'sign-up-form-action', 'sign-up-form-name-field',
				'sign-up-form-email-field', 'name-placeholder', 'email-placeholder');
			$this->no_escape_html_mapping = array('headline', 'sales-text', 'privacy-text');
			$this->default_values = array(
				'headline' => "Enter your name and email and get the weekly newsletter... it's FREE!",
				'sales-text' => 'Introduce yourself and your program',
				'subscribe-button-text' => 'Subscribe',
				'name-placeholder' => 'Enter your first name here',
				'email-placeholder' => 'Enter a valid email here',
				'privacy-text' => 'Your information will *never* be shared or sold to a 3rd party.',
				'background-color' => '#fefefe',
				'text-color' => '#444444',
				'subscribe-button-color' => '#00c98d',
				'subscribe-button-text-color' => '#ffffff',
				'display-headline' => 'block',
				'display-logo-row' => 'block',
				'display-logo-img' => 'block',
				'display-privacy' => 'block',
				'image-url' => '/wp-admin/images/w-logo-blue.png');
		}

		public function sanitize_style($setting, $id) {
			if('upload' === $setting['logo-img-action'] && !empty($_FILES['img-file-' . $id]['size'])) {
				$setting['image-url'] = '';

				$file_upload_result = wp_handle_upload($_FILES['img-file-' . $id], array('test_form' => false));
				if(!empty($file_upload_result['url'])) {
					$image_size_result = @getimagesize($file_upload_result['file']);
					if(false === $image_size_result) {
						add_settings_error('popupally_style', 'img-upload-error-' . $id, 'Please upload a valid image filetype for Popup #' . $id, 'error');
					} else {
						$setting['image-url'] = $file_upload_result['url'];
					}
				} else if(!empty($file_upload_result['error'])) {
					add_settings_error('popupally_style', 'img-upload-error-' . $id, 'File upload error for Popup #' . $id . ': ' . $file_upload_result['error'], 'error');
				}
			}
			unset($setting['logo-img-action']);
			return $setting;
		}
	}
	PopupAlly::add_template(new PopupAllyDefaultTemplate());
}
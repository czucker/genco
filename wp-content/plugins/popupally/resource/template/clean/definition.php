<?php
if (!class_exists('PopupAllyCleanTemplate')) {
	class PopupAllyCleanTemplate extends PopupAllyTemplate {
		public function __construct() {
			$this->uid = 'plsbvs';
			$this->template_name = 'Express yourself';
			$this->template_order = 1;

			$this->backend_css = plugin_dir_url(__FILE__) . '/backend/clean-preview.css';
			$this->backend_php = dirname(__FILE__) . '/backend/clean-preview.php';
			$this->frontend_css = dirname(__FILE__) . '/frontend/clean-popup.css';
			$this->frontend_php = dirname(__FILE__) . '/frontend/clean-popup.php';
			$this->frontend_embedded_php = dirname(__FILE__) . '/frontend/clean-embedded.php';

			$this->css_mapping = array('plsbvs-background-color', 'plsbvs-background-image',
				'plsbvs-width', 'responsive-768-plsbvs-width', 'responsive-520-plsbvs-width', 'plsbvs-outer-half-width', 'responsive-768-plsbvs-outer-half-width', 'responsive-520-plsbvs-outer-half-width', 'plsbvs-outer-half-height',
				'plsbvs-height', 'plsbvs-text-color', 'plsbvs-headline-top', 'plsbvs-headline-left',
				'plsbvs-name-field-top', 'plsbvs-name-field-left', 'plsbvs-email-field-top', 'plsbvs-email-field-left', 'plsbvs-subscribe-button-top', 'plsbvs-subscribe-button-left',
				'plsbvs-subscribe-button-color', 'plsbvs-subscribe-button-text-color',
				'plsbvs-headline-left', 'responsive-768-plsbvs-headline-left', 'responsive-520-plsbvs-headline-left',
				'plsbvs-name-field-left', 'responsive-768-plsbvs-name-field-left', 'responsive-520-plsbvs-name-field-left',
				'plsbvs-email-field-left', 'responsive-768-plsbvs-email-field-left', 'responsive-520-plsbvs-email-field-left',
				'plsbvs-subscribe-button-left', 'responsive-768-plsbvs-subscribe-button-left', 'responsive-520-plsbvs-subscribe-button-left',
				);
			$this->html_mapping = array('plsbvs-name-placeholder', 'plsbvs-email-placeholder', 'plsbvs-subscribe-button-text', 'sign-up-form-action', 'sign-up-form-name-field',
				'sign-up-form-email-field');
			$this->no_escape_html_mapping = array('plsbvs-headline');
			$this->default_values = array('plsbvs-background-img-action' => '',
				'plsbvs-background-color' => '#d3d3d3',
				'plsbvs-image-url' => '',
				'plsbvs-width' => '940',
				'plsbvs-height' => '60',
				'plsbvs-text-color' => '#111111',
				'plsbvs-headline' => 'Get free weekly updates:',
				'plsbvs-headline-top' => '15',
				'plsbvs-headline-left' => '60',
				'plsbvs-name-placeholder' => 'Name',
				'plsbvs-name-field-top' => '15',
				'plsbvs-name-field-left' => '90',
				'plsbvs-email-placeholder' => 'Email',
				'plsbvs-email-field-top' => '15',
				'plsbvs-email-field-left' => '90',
				'plsbvs-subscribe-button-text' => 'Sign up!',
				'plsbvs-subscribe-button-color' => '#00c98d',
				'plsbvs-subscribe-button-text-color' => '#ffffff',
				'plsbvs-subscribe-button-top' => '15',
				'plsbvs-subscribe-button-left' => '90',
			);
		}
		private static $responsive_width_elements = array('plsbvs-width', 'plsbvs-headline-left', 'plsbvs-name-field-left', 'plsbvs-email-field-left', 'plsbvs-subscribe-button-left');

		public function sanitize_style($setting, $id) {
			if('upload' === $setting['plsbvs-background-img-action'] && !empty($_FILES['plsbvs-img-file-' . $id]['size'])) {
				$setting['plsbvs-image-url'] = '';

				$file_upload_result = wp_handle_upload($_FILES['plsbvs-img-file-' . $id], array('test_form' => false));
				if(!empty($file_upload_result['url'])) {
					$image_size_result = @getimagesize($file_upload_result['file']);
					if(false === $image_size_result) {
						add_settings_error('popupally_style', 'img-upload-error-' . $id, 'Please upload a valid image filetype for Popup #' . $id, 'error');
					} else {
						$setting['plsbvs-image-url'] = $file_upload_result['url'];
					}
				} else if(!empty($file_upload_result['error'])) {
					add_settings_error('popupally_style', 'img-upload-error-' . $id, 'File upload error for Popup #' . $id . ': ' . $file_upload_result['error'], 'error');
				}
			}
			unset($setting['plsbvs-background-img-action']);
			return $setting;
		}

		public function prepare_for_code_generation($style) {
			if ($style['plsbvs-image-url']) {
				$style['plsbvs-background-image'] = 'url(' . $style['plsbvs-image-url'] . ')';
			} else {
				$style['plsbvs-background-image'] = 'none';
			}
			$style['plsbvs-outer-half-width'] = intval($style['plsbvs-width']) / 2;
			$style['plsbvs-outer-half-height'] = intval($style['plsbvs-height']) / 2;

			$style = self::calculate_responsive_width($style, 1000, 768);
			$style = self::calculate_responsive_width($style, 1000, 520);
			return $style;
		}
		private static function calculate_responsive_width($style, $full_page_width, $media_width) {
			$prefix = 'responsive-' . $media_width . '-';
			foreach(self::$responsive_width_elements as $elem) {
				$style[$prefix . $elem] = self::get_responsive_width($style[$elem], $full_page_width, $media_width);
			}
			$style[$prefix . 'plsbvs-outer-half-width'] = intval($style[$prefix . 'plsbvs-width']) / 2;
			return $style;
		}
		private static function get_responsive_width($element_width, $full_page_width, $media_width) {
			return min(intval($element_width) / $full_page_width, 1.0) * $media_width;
		}
	}
	PopupAlly::add_template(new PopupAllyCleanTemplate());
}

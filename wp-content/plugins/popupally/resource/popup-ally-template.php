<?php
if (!class_exists('PopupAllyTemplate')) {
	class PopupAllyTemplate {
		public $uid = null;
		public $template_name = null;
		public $template_order = 0;

		public $backend_css = null;
		public $backend_php = null;

		public $frontend_css = null;
		public $frontend_php = null;
		public $frontend_embedded_php = null;

		public $popup_html_template = null;
		public $popup_embedded_template = null;
		public $popup_css_template = null;

		public $css_mapping = null;
		public $html_mapping = null;
		public $no_escape_html_mapping = null;
		public $default_values = null;

		public function sanitize_style($input, $id) {
			return $input;
		}

		public function prepare_for_code_generation($style) {
			return $style;
		}
	}
}
<?php
	require "CNGann_Lib.class.php";
	require "CNGann_AjaxCalls.class.php";
	require "CNGann_ShortCodes.class.php";

	class CNGann extends CNGann_Lib {

		private $scripts = array();

		private $namespace = 'cngann_';

		public $shortcodes;

		public $ajaxCalls;

		public function add_script($script){ $this->scripts[] = $script; }

		public function enqueue_scripts(){
			foreach( $this->scripts as $s ) wp_enqueue_script( $this->namespace. $s, plugins_url( "/js/{$s}.js", ___FILE___ ), array('jquery'), '1.0' );
			wp_enqueue_style('cngann_style', plugins_url( '/css/style.css', ___FILE___ ), array(), '1.0');
		}

		public function ajax(){
			foreach( (array) $this->ajaxCalls->get_methods() as $call){
				if(!empty($_GET[$this->namespace.$call])){
					echo $this->ajaxCalls->$call();
					die;
				}
			}
		}

		public function add_shortcode($shortcode){
			if(file_exists(___DIR___."/js/{$shortcode}.js")) $this->add_script($shortcode);
			add_shortcode($shortcode, array($this->shortcodes, $shortcode) );
		}

		function __construct() {
			add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts'), 11 );
			add_action( 'init' , array($this,'ajax') );
			$this->shortcodes = new CNGann_ShortCodes;
			$this->ajaxCalls = new CNGann_AjaxCalls;
			foreach((array) $this->shortcodes->get_methods() as $shortcode) $this->add_shortcode($shortcode);

		}
	}
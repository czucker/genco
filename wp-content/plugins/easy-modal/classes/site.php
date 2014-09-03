<?php 
class EModal_Site {
	public function __construct()
	{
		add_action('wp_head', array('EModal_Modals', 'factory'), 1000);
		add_action('wp_footer', array('EModal_Modals', 'print_modals'), 1);
		add_action('wp_enqueue_scripts', array($this, 'styles'), 0);
		add_action('wp_enqueue_scripts', array($this, 'scripts'), 0);
	}
	public function styles()
	{
		wp_enqueue_style(EMCORE_SLUG.'-site', EMCORE_URL.'/assets/styles/'.EMCORE_SLUG.'-site.css', false, 0.1);
	}
	public function scripts()
	{
		wp_register_script( 'jquery-transit', EMCORE_URL.'/assets/scripts/jquery.transit.min.js', array('jquery'), '0.9.11', true );
		wp_enqueue_script(EMCORE_SLUG.'-site', EMCORE_URL.'/assets/scripts/'.EMCORE_SLUG.'-site.js', array('jquery', 'jquery-ui-position', 'jquery-transit'), '2', true);
		$themes = array();
		foreach(get_all_modal_themes() as $theme)
		{
			$meta = $theme->as_array();
			$themes[$theme->id] = $meta['meta'];
			//unset($themes[$theme->id]['id'], $themes[$theme->id]['theme_id']);
		}
		wp_localize_script(EMCORE_SLUG.'-site', 'emodal_themes', array('l10n_print_after' => 'emodal_themes = ' . json_encode($themes) . ';'));
	}
}
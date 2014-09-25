<?php
add_filter('emodal_admin_modal_form_tabs', 'emodal_admin_modal_form_examples_tab', 100);
function emodal_admin_modal_form_examples_tab($tabs)
{
	$tabs[] = array( 'id' => 'examples', 'label' => __('Examples', EMCORE_SLUG) );
	return $tabs;
}

add_action('emodal_admin_modal_form_tab_examples', 'emodal_admin_modal_form_examples_tab_settings', 30);
function emodal_admin_modal_form_examples_tab_settings()
{
	$modal = get_current_modal();
	?><h4>
		<?php _e('Copy this class to the link/button you want to open this modal.', EMCORE_SLUG)?>
		<span class="desc">eModal-<?php esc_html_e($modal->id)?></span>
	</h4>
	<div class="tab-box">
		<h4><?php _e('Link Example', EMCORE_SLUG)?></h4>
		<a href="#" onclick="return false;" class="eModal-<?php esc_html_e($modal->id)?>"><?php _e('Open Modal', EMCORE_SLUG)?></a>
		<pre>&lt;a href="#" class="eModal-<?php esc_html_e($modal->id)?>"><?php _e('Open Modal', EMCORE_SLUG)?>&lt;/a></pre>
	</div>
	<div class="tab-box">
		<h4><?php _e('Button Example', EMCORE_SLUG)?></h4>
		<button onclick="return false;" class="eModal-<?php esc_html_e($modal->id)?>"><?php _e('Open Modal', EMCORE_SLUG)?></button>
		<pre>&lt;button class="eModal-<?php esc_html_e($modal->id)?>"><?php _e('Open Modal', EMCORE_SLUG)?>&lt;/button></pre>
	</div>
	<div class="tab-box">
		<h4><?php _e('Image Example', EMCORE_SLUG)?></h4>
		<img style="cursor:pointer;" src="<?php echo EMCORE_URL?>/assets/images/admin/easy-modal-icon.png" onclick="return false;" class="eModal-<?php esc_html_e($modal->id)?>" />
		<pre>&lt;img src="easy-modal-icon.png" class="eModal-<?php esc_html_e($modal->id)?>" /></pre>
	</div><?php
}
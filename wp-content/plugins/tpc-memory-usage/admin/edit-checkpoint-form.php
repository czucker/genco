<?php
/**
 * Edit checkpoint form for inclusion in Administration Panel
 * 
 * @package TPC_Memory_Usage
 * @subpackage Administration
 */

if (!defined('ABSPATH'))
	die('-1');

if (!empty($checkpoint_id)) {
	$submit_text = __('Update Checkpoint');
	$form = '<form name="editCheckpoint" id="editCheckpoint" method="post" action="admin.php?page=tpcmem-checkpoint-manager">';
	$nonce_action = 'update-checkpoint_' . $checkpoint_id;
} else {
	$submit_text = __('Add Checkpoint');
	$form = '<form name="addCheckpoint" id="addCheckpoint" method="post" action="admin.php?page=tpcmem-checkpoint-manager">';
	$nonce_action = 'add-checkpoint';
}

function tpcmem_checkpoint_submit_meta_box($checkpoint) {
?>
<div class="submitbox" id="submitlink">

<div id="minor-publishing">

<?php // Hidden submit button early on so that the browser chooses the right button when form is submitted with Return key ?>
<div style="display:none;">
<input type="submit" name="save" value="<?php esc_attr_e('Save'); ?>" />
</div>

</div>

<div id="major-publishing-actions">
<?php do_action('post_submitbox_start'); ?>
<div id="delete-action">
<?php
if ( !empty($_GET['action']) && 'edit' == $_GET['action'] ) { ?>
	<a class="submitdelete deletion" href="<?php echo wp_nonce_url("admin.php?action=delete&amp;page=tpcmem-checkpoint-manager&amp;checkpoint_id=$checkpoint->checkpoint_id", 'delete-checkpoint_' . $checkpoint->checkpoint_id); ?>" onclick="if ( confirm('<?php echo esc_js(sprintf(__("You are about to delete this checkpoint '%s'\n  'Cancel' to stop, 'OK' to delete."), $checkpoint->checkpoint_action )); ?>') ) {return true;}return false;"><?php _e('Delete'); ?></a>
<?php } ?>
</div>

<div id="publishing-action">
<?php if ( !empty($checkpoint->checkpoint_id) ) { ?>
	<input name="save" type="submit" class="button-primary" id="publish" tabindex="4" accesskey="p" value="<?php esc_attr_e('Update Checkpoint') ?>" />
<?php } else { ?>
	<input name="save" type="submit" class="button-primary" id="publish" tabindex="4" accesskey="p" value="<?php esc_attr_e('Add Checkpoint') ?>" />
<?php } ?>
</div>
<div class="clear"></div>
</div>
<?php do_action('submitlink_box'); ?>
<div class="clear"></div>
</div>
<?php
}

add_meta_box('tpcmemcheckpointsubmitdiv', __('Save'), 'tpcmem_checkpoint_submit_meta_box', 'tpcmem_checkpoint', 'side', 'core');
do_action('do_meta_boxes', 'tpcmem_checkpoint', 'side', $checkpoint);

?>

<div class="wrap">
<?php screen_icon('options-general'); ?>
<h2><?php echo esc_html($title); ?></h2>

<?php if (isset($_GET['added'])): ?>
<div id="message" class="updated fade"><p><?php esc_html_e('Checkpoint added.'); ?></p></div>
<?php endif; ?>

<?php
if (!empty($form))
	echo $form;

wp_nonce_field($nonce_action);
?>

<div id="poststuff" class="metabox-holder has-right-sidebar">
<div id="side-info-column" class="inner-sidebar">
<?php

do_action('submitlink_box');
$side_meta_boxes = do_meta_boxes('tpcmem_checkpoint', 'side', $checkpoint);

?>
</div>

<div id="post-body">
<div id="post-body-content">

<div class="stuffbox">
<h3><label for="checkpoint_action"><?php _e('Checkpoint Action')?></label></h3>
<div class="inside">
	<input type="text" name="checkpoint_action" id="checkpoint_action" size="30" tabindex="1" value="<?php echo esc_attr($checkpoint->checkpoint_action); ?>" id="checkpoint_action" />
	<p><?php _e('Example: add_link'); ?></p>
</div>
</div>

<div class="stuffbox">
<h3><label for="checkpoint_desc"><?php _e('Checkpoint Action')?></label></h3>
<div class="inside">
	<textarea name="checkpoint_desc" id="checkpoint_desc" tabindex="2"><?php echo esc_html($checkpoint->checkpoint_desc); ?></textarea>
	<p><?php _e('Example: Hook executed after new link is added'); ?></p>
</div>
</div>

<?php if (isset($checkpoint_id) && $checkpoint_id): ?>
<input type="hidden" name="action" value="save" />
<input type="hidden" name="checkpoint_id" value="<?php echo (int) $checkpoint_id; ?>" />
<?php else: ?>
<input type="hidden" name="action" value="add" />
<?php endif; ?>

</div><!-- #post-body-content -->
</div><!-- #post-body -->
</div><!-- #poststuff -->

</form>
</div>
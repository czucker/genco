<?php
$id = trim(strip_tags($_GET['id']));
?>
jQuery(document).ready(function($){
<?php include(WP_EMEMBER_PATH . '/js/emember_js_form_validation_rules.php'); ?>
$.validationEngineLanguage.allRules['ajaxUserCall']['url']= '<?php echo admin_url('admin-ajax.php'); ?>';
$("#<?php echo $id; ?>").validationEngine('attach');
});
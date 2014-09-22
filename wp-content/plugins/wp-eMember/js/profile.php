<?php
$emember_auth = Emember_Auth::getInstance();
$emember_config = Emember_Config::getInstance();
$use_gravatar = $emember_config->getValue('eMember_use_gravatar');
?>
jQuery(document).ready(function($){
$('#emember-profile-remove-cont').on('emember_profile',function(){
var button = $('#remove_button');
var id = button.attr('href');
if(id)$(this).show();
else $(this).hide();
}).trigger('emember_profile');
$("#delete_account_btn").click(function(){
top.document.location = $(this).attr("href");
}).confirm({timeout:5000,msg: "<?php echo EMEMBER_CONFIRM; ?>",buttons:{'ok':'<?php echo EMEMBER_YES ?>','cancel':'<?php echo EMEMBER_NO; ?>'}});
<?php if ($emember_config->getValue('eMember_profile_thumbnail') && empty($use_gravatar)): ?>
    $('#remove_button').click(function(e){
    var imagepath = $(this).attr('href');
    if(imagepath){
    $.get( '<?php echo admin_url('admin-ajax.php'); ?>',{"action":"delete_profile_picture","path":imagepath},
    function(data){
    $("#emem_profile_image").attr("src",   "<?php echo WP_EMEMBER_URL; ?>/images/default_image.gif?" + (new Date()).getTime());
    $('#remove_button').attr('href','');
    $('#emember-profile-remove-cont').trigger('emember_profile');
    },
    "json");
    }
    e.preventDefault();
    });

    if($('#emember-file-uploader').length)
    var uploader = new qq.FileUploader({
    button_label: '<?php echo EMEMBER_UPLOAD; ?>',
    element: document.getElementById('emember-file-uploader'),
    action: '<?php echo admin_url("admin-ajax.php"); ?>',
    params: {'action':'emember_upload_ajax',
    'image_id':<?php echo $emember_auth->getUserInfo('member_id'); ?>},
    onComplete: function(id, fileName, responseJSON){
    if(responseJSON.success){
    <?php $upload_dir = wp_upload_dir(); ?>
    var $url = "<?php echo $upload_dir['baseurl']; ?>/emember/" +responseJSON.filename +"?" + (new Date()).getTime();
    var $dir =  +responseJSON.id;
    $("#emem_profile_image").attr("src", $url);
    $('#remove_button').attr('href',$dir);
    $('#emember-profile-remove-cont').trigger('emember_profile');
    }
    }});
<?php endif; ?>
});

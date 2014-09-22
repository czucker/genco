<?php include_once('membership_level_list_view.php'); ?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $.validationEngineLanguage = {
            newLang: function() {
                $.validationEngineLanguage.allRules = {
                    "required": {
                        "regex": "none",
                        "alertText": "* " + 'This field is required ',
                        "alertTextCheckboxe": "* " + 'This field is required '
                    },
                    "ajaxUserLevelCall": {
                        "url": "ajaxurl",
                        "regex": "none",
                        "extraData": "&event=check_level_name&action=check_level_name",
                        "alertText": "* Name Already Used",
                        "alertTextOk": "* Name Available",
                        "alertTextLoad": "* Please Wait"
                    }
                };
            }
        };
        $.validationEngineLanguage.newLang();
        function toggle_form(show) {
            if (show) {
                $('#emember_membership_list').slideUp('slow');
                $('#emember_membership_form').slideDown('slow').html("");
            } else {
                $('#emember_membership_list').slideDown('slow');
                $('#emember_membership_form').slideUp('slow');
                $('#emember_form').validationEngine('hideAll');
            }
        }
        function emember_get_form(id) {
            toggle_form(true);
            var id = (id == undefined) ? "" : id;
            var params = {action: 'emember_load_membership_form', id: id};
            $('#emember_membership_form').load(ajaxurl, params, function() {
                $("#expire_on_fixed_date_new_level").dateinput({'format': 'yyyy-mm-dd', selectors: true, yearRange: [-100, 100]});
                $('#cancel_button').click(function() {
                    toggle_form(false);
                });
                $('.emember_sub_duration').click(function() {
                    switch (this.value) {
                        case 'interval':
                            $('#level_name_new_calendar').removeAttr('disabled');
                            $('#level_name_new_expire').removeAttr('disabled');
                            $('#expire_on_fixed_date_new_level').attr('disabled', 'disabled');
                            break;
                        case 'fixed_date':
                            $('#level_name_new_calendar').attr('disabled', 'disabled');
                            $('#level_name_new_expire').attr('disabled', 'disabled');
                            $('#expire_on_fixed_date_new_level').removeAttr('disabled');
                            break;
                        case 'noexpire':
                            $('#level_name_new_calendar').attr('disabled', 'disabled');
                            $('#level_name_new_expire').attr('disabled', 'disabled');
                            $('#expire_on_fixed_date_new_level').attr('disabled', 'disabled');
                            break;
                    }
                });
                $.validationEngineLanguage.allRules['ajaxUserLevelCall']['url'] = '<?php echo admin_url('admin-ajax.php'); ?>';
                $("#emember_form").validationEngine('attach');
            });
        }
        $('#add_new').click(function() {
            emember_get_form()
        });
        $('.emember_edit').click(function() {
            emember_get_form($(this).attr('id'));
        });
        $('.emember_delete').click(function() {
            top.document.location = 'admin.php?page=eMember_membership_level_menu&delete=' + $(this).attr('id');
            return false;
        }).confirm({msg: "", timeout: 5000});
        $('#emember_form').submit(function() {
            var ok = true;
            $(this).find('input').each(function(i) {
                if ((this.value == '') && (!this.disabled) && $(this).attr('emember_required')) {
                    $(this).css('background', 'red');
                    ok = false;
                }
            });
            return ok;
        });
    });
</script>

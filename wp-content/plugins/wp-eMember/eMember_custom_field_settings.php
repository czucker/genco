<?php

function emember_custom_field_settings() {
    $emember_config = Emember_Config::getInstance();
    if (isset($_POST['info_update'])) {
//        wp_emember_printd($_POST);
//        die();
        unset($_POST['info_update']);
        $fields = $_POST;
        $fields['emember_field_name'] = array_values((array) $fields['emember_field_name']);
        $fields['emember_field_type'] = array_values((array) $fields['emember_field_type']);

        $fields['emember_field_requred'] = array_values((array) $fields['emember_field_requred']);
        $fields['emember_field_extra'] = array_values((array) $fields['emember_field_extra']);
        if (isset($_POST['emember_field_flag']))
            $fields['emember_field_flag'] = $_POST['emember_field_flag'];
        update_option('emember_custom_field_type', $fields);
    }
    else {
        $fields = get_option('emember_custom_field_type');
    }

    if ($emember_config->getValue('eMember_custom_field') == '') {//custom field settings is not enabled
        echo '<div class="wrap">';
        echo '<p><strong>If you want to use custom fields on your registration and edit profile forms then please check the "Enable Custom Fields" checkbox from the WP eMember\'s General Settings to enable this feature</strong></p>';
        echo '</div>';
        return;
    }
    ?>
    <form id="emember-dyn-form" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
        <div class="wrap">
            <div id="poststuff">
                <div id="post-body">
                    <div class="eMember_yellow_box">
                        <p><i>You can turn the custom fields feature on or off by checking the "Enable Custom Fields" checkbox from the WP eMember's General Settings</i></p>
                        <p><strong>The fields that you configure below will just show up on your registration and edit profile page directly. You DO NOT need to configure these fields from the "Pages/Forms Settings" section (no need to look for them there).</strong></p>
                        <p>For Dropdown field types, write down key=&gt;value pairs as a comma separated list in the "Extra Field Info" field. (Example: 1=&gt;option1,2=&gt;option2). Here is another example (1=>America,2=>Africa,3=>Europe,4=>Asia) that will create a dropdown list with the options being America, Africa, Europe and Asia.</p>
                    </div>
                    <fieldset class="inlineLabels" id="cfU-204BD901-09C4-BEF8-6008F40594EA946F">
                        <div id="add-name-container" class="emember-add-field-container">
                            <span class="emember-add-field-trigger">
                                <img src="<?php echo WP_EMEMBER_URL; ?>/images/add.gif" alt="" title="Add New Item" />
                                Add Custom Field
                            </span>
                        </div>
                        <div class="ctrlHolder">
                            <?php
                            $i = 0;
                            $fields['emember_field_requred'] = is_null($fields['emember_field_requred']) ? array() : $fields['emember_field_requred'];
                            do {
                                ?>
                                <div id="removable-name-container-<?php echo ($i); ?>" class="postbox" style="padding:10px;border:3px solid #DFDFDF;<?php echo isset($fields['emember_field_flag']) ? "display:none" : ""; ?>">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="6">
                                        <tr>
                                            <td>
                                                <label for="emember_field_name_<?php echo ($i); ?>"><strong>Field Name</strong></label>
                                            </td>
                                            <td>
                                                <input type="text" name="emember_field_name[<?php echo $i ?>]" id="name_<?php echo ($i); ?>" value="<?php echo htmlspecialchars(stripslashes($fields['emember_field_name'][$i])); ?>" class="textInput emember-removable" />
                                                <input <?php echo in_array($i, $fields['emember_field_requred']) ? "checked='checked'" : ""; ?> type="checkbox" name="emember_field_requred[<?php echo $i ?>]" id="required_<?php echo ($i); ?>" value="<?php echo $i ?>" class="textInput" /> required.
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="emember_field_type_<?php echo ($i); ?>"><strong>Field Type</strong></label>
                                            </td>
                                            <td>
                                                <select  name="emember_field_type[<?php echo $i ?>]" id="emember_field_type_<?php echo ($i); ?>" class="textInput emember-removable" >
                                                    <option <?php echo (isset($fields['emember_field_type'][$i]) && ($fields['emember_field_type'][$i] == 'text')) ? "selected='selected'" : ""; ?> value="text">Text</option>
                                                    <option <?php echo (isset($fields['emember_field_type'][$i]) && ($fields['emember_field_type'][$i] == 'dropdown')) ? "selected='selected'" : ""; ?> value="dropdown">Dropdown List</option>
                                                    <option <?php echo (isset($fields['emember_field_type'][$i]) && ($fields['emember_field_type'][$i] == 'checkbox')) ? "selected='selected'" : ""; ?> value="checkbox">Checkbox</option>
                                                    <option <?php echo (isset($fields['emember_field_type'][$i]) && ($fields['emember_field_type'][$i] == 'textarea')) ? "selected='selected'" : ""; ?> value="textarea">Text Area</option>
                                                </select>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="name_<?php echo ($i); ?>"><strong>Extra Field Info</strong></label>
                                            </td>
                                            <td>
                                                <textarea name="emember_field_extra[<?php echo $i ?>]" id="extra_<?php echo ($i); ?>"  rows="1" cols="70"  class="textInput emember-removable" ><?php echo stripslashes($fields['emember_field_extra'][$i]); ?></textarea>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="nameindex_<?php echo ($i); ?>"><strong>Display Order</strong></label>
                                            </td>
                                            <td>
                                                <input type="text" size="4" maxlength="4" name="emember_field_order[<?php echo $i ?>]" id="nameindex_<?php echo ($i); ?>" value="<?php echo $fields['emember_field_order'][$i]; ?>" class="textInput emember-removable onlynumber displayorder" />
                                                <br /><i>Enter a number for display order purpose (example value: 1). The custom fields will be shown according to this order number on the registration and edit profile page.</i>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </table>
                                    <img class="emember-remove_segment" src="<?php echo WP_EMEMBER_URL; ?>/images/spacer.gif" width="16" height="16" alt="" title="Remove This Item" class="" />
                                </div>
                                <?php
                                $i++;
                            } while ($i < count($fields['emember_field_name']));
                            ?>
                        </div>
                    </fieldset>
                    <div class="submit">
                        <input type="submit"  name="info_update" class="button-primary" value="<?php _e('Update options'); ?> &raquo;" />
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        ;
        (function($) {
            $(document).ready(function() {
                $('.onlynumber').keypress(function(e) {
                    if (window.event)
                        var charCode = e.keyCode;
                    else if (e.which)
                        var charCode = e.which;
                    if (charCode > 31 && (charCode < 48 || charCode > 57))
                        return false;
                    return true;
                });
                $('form').submit(function() {
                    var $ok = true;
                    var $this = this;
                    $('input.textInput:text').each(function() {
                        if ($(this).parents('div:first').css('display') == 'none') {
                            $("<input type='hidden' name='emember_field_flag' value = '1' />").appendTo($($this));
                            $ok = true;
                            return false;
                        }
                        if ($(this).val() == "") {
                            $ok = false;
                            return false;
                        }
                    });
                    if (!$ok)
                        alert('"Display Order" and "Field Name" field(s) cannot be kept empty.');
                    return $ok;
                });
                $("button[name='cancel']").click(function() {
                    var input = $(':input');
                    input.each(function(i) {
                        $(this).rules('remove');
                    });
                    $(':input').removeClass('required').addClass('ignore');
                    $('#emember-dyn-form').validate({ignore: '.ignore'});
                });

                $("#emember-dyn-form #removable-name-container-0").dynamicField({
                    removeImgSrc: '<?php echo WP_EMEMBER_URL; ?>/images/cross.png',
                    spacerImgSrc: '<?php echo WP_EMEMBER_URL; ?>/images/spacer.gif',
                    addTriggerClass: "emember-add-field-trigger",
                    removeImgClass: "emember-remove-field-trigger"
                });
            });
        })(jQuery);
    </script>

    <?php
}

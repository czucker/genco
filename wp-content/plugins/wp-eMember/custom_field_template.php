<?php
if ($emember_config->getValue('eMember_custom_field')):
    $custom_fields = get_option('emember_custom_field_type');
    $inversed_order = array();
    $revised_order = array();
    $num_field = count($custom_fields['emember_field_name']);
    for ($i = 1; $i <= $num_field; $i++) {
        $inversed_order[$i] = $i;
    }

    if (is_array($custom_fields['emember_field_order'])) {
        foreach ($custom_fields['emember_field_order'] as $key => $value) {
            $inversed_order[$value] = $key;
        }
        $order_values = array_values($custom_fields['emember_field_order']);
        sort($order_values);

        foreach ($order_values as $key => $value) {
            $revised_order[] = $inversed_order[$value];
        }
    } else {
        $num_field = count($custom_fields['emember_field_name']);
        for ($i = 0; $i <= $num_field; $i++) {
            $revised_order[] = $i;
        }
    }
    if (!isset($custom_fields['emember_field_flag']))
        for ($i = 0; isset($revised_order[$i]) && isset($custom_fields['emember_field_name'][$revised_order[$i]]); $i++) {
            $emember_field_name = stripslashes($custom_fields['emember_field_name'][$revised_order[$i]]);
            $emember_field_name_index = emember_escape_custom_field($emember_field_name);
            ?>
            <tr>
                <td><label for="<?php echo $emember_field_name_index ?>" class="eMember_label"><?php _e($emember_field_name, "wp_emember"); ?>: </label></td>
                <td>
                    <?php
                    $field_value = isset($edit_custom_fields[$emember_field_name_index]) ? $edit_custom_fields[$emember_field_name_index] : "";
                    $field_value = isset($_POST['emember_custom'][$emember_field_name_index]) ? $_POST['emember_custom'][$emember_field_name_index] : $field_value;
                    $field_value = stripslashes($field_value);
                    switch ($custom_fields['emember_field_type'][$revised_order[$i]]) {
                        case 'text':
                            ?>
                            <input type="text"  id="wp_emember_<?php echo $emember_field_name_index; ?>" name="emember_custom[<?php echo $emember_field_name_index; ?>]" size="20" value="<?php echo $field_value; ?>" class="<?php echo in_array($revised_order[$i], $custom_fields['emember_field_requred']) ? 'validate[required] ' : ""; ?>eMember_text_input" />
                            <?php
                            break;
                        case 'dropdown':
                            ?>
                            <select id="wp_emember_<?php echo $emember_field_name_index; ?>" name="emember_custom[<?php echo $emember_field_name_index; ?>]" class="<?php echo in_array($revised_order[$i], $custom_fields['emember_field_requred']) ? 'validate[required] ' : ""; ?>eMember_text_input">
                                <option value=""><?php echo EMEMBER_SELECT_ONE; ?></option>
                                <?php
                                $options = stripslashes($custom_fields['emember_field_extra'][$revised_order[$i]]);
                                $options = explode(',', $options);
                                foreach ($options as $option) {
                                    $option = explode("=>", $option);
                                    ?>
                                    <option <?php echo ($field_value === $option[0]) ? "selected='selected'" : ""; ?> value="<?php echo $option[0]; ?>"><?php echo $option[1]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?php
                            break;
                        case 'checkbox':
                            ?>
                            <input type="checkbox" <?php echo $field_value ? "checked='checked'" : ""; ?> id="wp_emember_<?php echo $emember_field_name_index; ?>" name="emember_custom[<?php echo $emember_field_name_index; ?>]" class="<?php echo in_array($i, $custom_fields['emember_field_requred']) ? 'validate[required]' : ""; ?>" class="" />
                            <?php
                            break;
                        case 'textarea':
                            ?>
                            <textarea id="wp_emember_<?php echo $emember_field_name_index; ?>" name="emember_custom[<?php echo $emember_field_name_index; ?>]" class="<?php echo in_array($i, $custom_fields['emember_field_requred']) ? 'validate[required]' : ""; ?>" ><?php echo $field_value; ?></textarea>
                            <?php
                            break;
                            ?>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
endif;
?>

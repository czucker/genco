<!-- dynamic js block -->
<div class="emember_modal" id="emember_forgot_pass_prompt">
    <div class="emember_modal_title eMember_red"><?php echo EMEMBER_PASS_RESET; ?></div>
    <div id="wp_emember_email_mailMsg"></div>
    <div id="wp_emember_email_mailForm">
        <?php echo EMEMBER_PASS_RESET_MSG; ?>
        <form action="javascript:void(0);" method="post" name="wp_emember_mailSendForm" id="wp_emember_mailSendForm" >
            <p class="textbox">
                <label for="wp_emember_email" class="eMember_label"><?php echo EMEMBER_EMAIL; ?>: </label>
                <input class="eMember_text_input" type="text" id="wp_emember_email" name="wp_emember_email" size="20" value="" />
                <input class="eMember_text_input" type="hidden" id="event" name="event" size="20" value="send_mail" />
            </p>
            <p>
                <input name="wp_emember_email_doSend" type="submit" id="wp_emember_email_doSend" class="emember_button"  value="<?php echo EMEMBER_RESET; ?>" />
                <input type="button" id="emember_forgot_pass_prompt_close_btn" class="close emember_button" value="<?php echo EMEMBER_CLOSE; ?>" />
            </p>
        </form>
    </div>
</div>

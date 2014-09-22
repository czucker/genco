<div class="wrap">
    <form id="list_form" method="post">
        <div class="eMember_yellow_box">
            <p>First of all, globally protect the content on your site by selecting "General Protection" from the drop-down box below and then select the items that should be protected from non-logged in users.</p>
            <p>Next, select an existing membership level from the drop-down box below and then select the items you want to grant access to (for that particular membership level).</p>
            <p>Note: You can also set the protection settings for an individual post or page in the WordPress editor (look for the "eMember Protection Options" section when editing the post or page). If you can't see that section, click on "Screen Options" (top RHS in the editor) and enable "eMember Protection Options".</p>
        </div>

        <blockquote>
            <select id="wpm_content_level"  name="wpm_content_level">
                <option value="-1" selected="selected">Select...</option>
                <option value="1">General Protection</option>
                <?php
                foreach ($levels as $level) {
                    ?>
                    <option  value="<?php echo $level->id; ?>"><?php echo stripslashes($level->alias); ?></option>
                <?php } ?>
            </select>
        </blockquote>
        <!-- </form>-->
        <div id="secondary_nav" style="display:none;">
              <h2 style="font-size: 18px;"><a name="specific"></a><span id="label_str">Manage Content Protection</span> &raquo; <!--<span id="head">Posts</span>--></h2>
            <ul class="eMemberSubMenu">
                <li id="custom-posts"><a href="#">Custom Posts</a></li>
                <!--  <li id="attachments"><a href="#">Attachments</a></li>	-->
                <li id="comments"><a href="#">Comments</a></li>
                <li id="categories"><a href="#">Categories</a></li>
                <li id="pages"><a href="#">Pages</a></li>
                <li id="posts" class="current"><a href="#">Posts</a></li>
            </ul>
            <div id="submit_button">
                <div class="mcp-action-section" style="margin: 0 0 10px 0;">
                    <span id="button_legend">Select which content to protect:</span>
                    <input type="submit" name="submit" value="Set Protection" class="button-primary"/> <span id="ajax_msg"></span>
                </div>
                <div id="emember_Pagination" class="emember_pagination"></div>
            </div>
            <table id="wpm_post_page_table" class="widefat">
            </table>
        </div>
    </form>
</div>
<div class="emember_apple_overlay" id="emember_post_preview_overlay">

    <!-- the external content is loaded inside this tag -->
    <div class="emember_contentWrap"></div>

</div>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        var loadTabContent = function(tab, level) {
            $('#list_form .eMemberSubMenu li').removeClass('current');
            $('#' + tab).addClass('current');
            params = {action: "access_list_ajax", level: level, tab: tab}
            $.get(ajaxurl, params, function(data) {
                window.eval($(data).filter('script').html());
            })
        };
        var selectedLevel = $.cookie('selected_level') ? $.cookie('selected_level') : -1;
        var selectedTab = $.cookie('selected_tab') ? $.cookie('selected_tab') : "posts";
        var submenu = $('#secondary_nav');
        $('#list_form .eMemberSubMenu li').click(function() {
            selectedTab = $(this).attr('id');
            $.cookie('selected_tab', selectedTab)
            loadTabContent(selectedTab, selectedLevel);
        });
        $('#wpm_content_level').val(selectedLevel).change(function() {
            selectedLevel = $(this).val();
            var buttonLabel = (selectedLevel == 1) ? "Set Protection" : "Grant Access";
            var buttonLegend = (selectedLevel == 1) ? "<p>Select which content to protect then hit the set protection button</p>" :
                    "<p>Select which content to grant access to for the selected level then hit the grant access button</p>";
            $('#submit_button input:submit').val(buttonLabel);
            $('#button_legend').html(buttonLegend);
            $.cookie('selected_level', selectedLevel);
            if (selectedLevel == -1) {
                submenu.slideUp('slow');
            }
            else {
                submenu.slideDown('slow');
                loadTabContent(selectedTab, selectedLevel);
            }
        }).change();
    });
</script>
